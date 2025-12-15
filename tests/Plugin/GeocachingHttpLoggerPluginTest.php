<?php
declare(strict_types=1);

namespace Geocaching\Plugin\Tests;

use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
use Http\Promise\FulfilledPromise;
use Http\Promise\RejectedPromise;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class GeocachingHttpLoggerPluginTest extends TestCase
{
    public function testHandleRequestLogsException(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test');
        $exception = new \Exception('Test error');
        $next = fn() => new RejectedPromise($exception);
        $first = fn() => null;
        $logger->expects($this->once())
            ->method('error')
            ->with(
                $this->stringContains('HTTP Exception'),
                $this->arrayHasKey('exception_class')
            );
        $this->expectException(\Exception::class);
        $plugin->handleRequest($request, $next, $first)->wait();
    }

    public function testMaskSensitiveDataNoMaskingWhenDisabled(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, false, false);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('maskSensitiveData');
        $method->setAccessible(true);
        $uri = 'https://api/?access_token=abc123&token=def456&key=ghi789';
        $masked = $method->invoke($plugin, $uri);
        $this->assertSame($uri, $masked);
    }


    public function testMaskHeadersNoMaskingWhenDisabled(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, false, false);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('maskHeaders');
        $method->setAccessible(true);
        $headers = [
            'Authorization' => ['Bearer secret-token'],
            'X-API-Key' => ['api-key-123']
        ];
        $masked = $method->invoke($plugin, $headers);
        $this->assertEquals($headers, $masked);
    }

    public function testFilterResponseHeadersReturnsEmptyIfNoInterestingHeaders(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('filterResponseHeaders');
        $method->setAccessible(true);
        $headers = [
            'X-Not-Interesting' => ['foo'],
            'Another' => ['bar']
        ];
        $filtered = $method->invoke($plugin, $headers);
        $this->assertSame([], $filtered);
    }

    public function testTruncateBodyNoTruncationIfShort(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, true, true, 100);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('truncateBody');
        $method->setAccessible(true);
        $body = 'short';
        $result = $method->invoke($plugin, $body);
        $this->assertSame('short', $result);
    }

    public function testGetLogLevelForStatusAllBranches(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('getLogLevelForStatus');
        $method->setAccessible(true);
        $this->assertSame(LogLevel::ERROR, $method->invoke($plugin, 500));
        $this->assertSame(LogLevel::WARNING, $method->invoke($plugin, 404));
        $this->assertSame(LogLevel::INFO, $method->invoke($plugin, 301));
        $this->assertSame(LogLevel::INFO, $method->invoke($plugin, 200));
    }

    public function testConstructSetsPropertiesLegacy(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::DEBUG, true, false, 123);
        $ref = new \ReflectionClass($plugin);
        $this->assertSame($logger, $ref->getProperty('logger')->getValue($plugin));
        $this->assertSame(LogLevel::DEBUG, $ref->getProperty('logLevel')->getValue($plugin));
        $this->assertTrue($ref->getProperty('logBodies')->getValue($plugin));
        $this->assertFalse($ref->getProperty('maskTokens')->getValue($plugin));
        $this->assertSame(123, $ref->getProperty('maxBodyLength')->getValue($plugin));
    }

    public function testMaskSensitiveDataMasksTokensLegacy(): void
    {
        $logger = $this->createStub(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $ref = new \ReflectionClass($plugin);
        $method = $ref->getMethod('maskSensitiveData');
        $method->setAccessible(true);
        $uri = 'https://api/?access_token=abc123&token=def456&key=ghi789';
        $masked = $method->invoke($plugin, $uri);
        $this->assertStringNotContainsString('abc123', $masked);
        $this->assertStringNotContainsString('def456', $masked);
        $this->assertStringNotContainsString('ghi789', $masked);
        $this->assertStringContainsString('access_token=***', $masked);
        $this->assertStringContainsString('token=***', $masked);
        $this->assertStringContainsString('key=***', $masked);
    }

    public function testMasksAuthorizationHeaders(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test', [
            'Authorization' => ['Bearer secret-token'],
            'Content-Type' => ['application/json'],
            'X-API-Key' => ['api-key-123']
        ]);
        $response = $this->createMockResponse(200, 'OK');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $logger->expects($this->exactly(2))->method('log');
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertTrue(true);
    }

    public function testLogsRequestBodiesWhenEnabled(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, true);
        $body = $this->createMockStream('{"test":"data"}');
        $request = $this->createMockRequest('POST', 'https://api.example.com/test', [], $body);
        $response = $this->createMockResponse(200, 'OK');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $loggedContext = null;
        $logger->expects($this->exactly(2))
            ->method('log')
            ->willReturnCallback(function ($level, $message, $context) use (&$loggedContext) {
                if (str_contains($message, 'Request')) {
                    $loggedContext = $context;
                }
            });
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertIsArray($loggedContext);
        if (is_array($loggedContext)) {
            $this->assertArrayHasKey('body', $loggedContext);
            $this->assertEquals('{"test":"data"}', $loggedContext['body']);
        }
    }

    public function testTruncatesLongBodies(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, true, true, 10);
        $longBody = str_repeat('x', 20);
        $body = $this->createMockStream($longBody);
        $request = $this->createMockRequest('POST', 'https://api.example.com/test', [], $body);
        $response = $this->createMockResponse(200, 'OK');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $loggedContext = null;
        $logger->expects($this->exactly(2))
            ->method('log')
            ->willReturnCallback(function ($level, $message, $context) use (&$loggedContext) {
                if (str_contains($message, 'Request')) {
                    $loggedContext = $context;
                }
            });
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertIsArray($loggedContext);
        $this->assertEquals(str_repeat('x', 10) . '... (truncated)', $loggedContext['body']);
    }

    public function testUsesErrorLogLevelFor5xxResponses(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test');
        $response = $this->createMockResponse(500, 'Internal Server Error');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $responseLogLevel = null;
        $logger->expects($this->exactly(2))
            ->method('log')
            ->willReturnCallback(function ($level, $message, $context) use (&$responseLogLevel) {
                if (str_contains($message, 'Response')) {
                    $responseLogLevel = $level;
                }
            });
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertEquals(LogLevel::ERROR, $responseLogLevel);
    }

    public function testUsesWarningLogLevelFor4xxResponses(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test');
        $response = $this->createMockResponse(404, 'Not Found');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $responseLogLevel = null;
        $logger->expects($this->exactly(2))
            ->method('log')
            ->willReturnCallback(function ($level, $message, $context) use (&$responseLogLevel) {
                if (str_contains($message, 'Response')) {
                    $responseLogLevel = $level;
                }
            });
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertEquals(LogLevel::WARNING, $responseLogLevel);
    }

    public function testDisablesTokenMaskingWhenConfigured(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, false, false);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test?access_token=secret123', [
            'Authorization' => ['Bearer secret-token']
        ]);
        $response = $this->createMockResponse(200, 'OK');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $logger->expects($this->exactly(2))->method('log');
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertTrue(true);
    }

    public function testLogsResponseBodyWhenEnabled(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $plugin = new GeocachingHttpLoggerPlugin($logger, LogLevel::INFO, true);
        $bodyContent = '{"foo":"bar"}';
        $body = $this->createMockStream($bodyContent);
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getReasonPhrase')->willReturn('OK');
        $response->method('getHeaders')->willReturn(['Content-Type' => ['application/json']]);
        $response->method('getBody')->willReturn($body);
        $request = $this->createMockRequest('GET', 'https://api.example.com/test');
        $next = fn() => new FulfilledPromise($response);
        $first = fn() => null;
        $loggedContext = null;
        $logger->expects($this->exactly(2))
            ->method('log')
            ->willReturnCallback(function ($level, $message, $context) use (&$loggedContext) {
                if (str_contains($message, 'Response')) {
                    $loggedContext = $context;
                }
            });
        $promise = $plugin->handleRequest($request, $next, $first);
        $promise->wait();
        $this->assertIsArray($loggedContext);
        if (is_array($loggedContext)) {
            $this->assertArrayHasKey('body', $loggedContext);
            $this->assertEquals($bodyContent, $loggedContext['body']);
        }
    }

    private function createMockRequest(string $method, string $uri, array $headers = [], ?StreamInterface $body = null): RequestInterface
    {
        $request = $this->createStub(RequestInterface::class);
        $request->method('getMethod')->willReturn($method);
        $uriMock = $this->createStub(UriInterface::class);
        $uriMock->method('__toString')->willReturn($uri);
        $request->method('getUri')->willReturn($uriMock);
        $request->method('getHeaders')->willReturn($headers);
        if ($body === null) {
            $body = $this->createMockStream('');
        }
        $request->method('getBody')->willReturn($body);
        return $request;
    }

    private function createMockResponse(int $statusCode, string $reasonPhrase, array $headers = []): ResponseInterface
    {
        $response = $this->createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn($statusCode);
        $response->method('getReasonPhrase')->willReturn($reasonPhrase);
        $response->method('getHeaders')->willReturn($headers);
        $response->method('getBody')->willReturn($this->createMockStream(''));
        return $response;
    }

    private function createMockStream(string $content): StreamInterface
    {
        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn($content);
        $stream->method('getSize')->willReturn(strlen($content));
        return $stream;
    }
}
