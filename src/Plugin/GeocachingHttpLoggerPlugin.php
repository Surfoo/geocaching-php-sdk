<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * HTTP Logger Plugin for Geocaching API requests and responses.
 *
 * This plugin logs all HTTP exchanges with configurable detail levels,
 * automatic token masking, and request/response correlation.
 */
final readonly class GeocachingHttpLoggerPlugin implements Plugin
{
    public function __construct(
        private LoggerInterface $logger,
        private string $logLevel = LogLevel::INFO,
        private bool $logBodies = false,
        private bool $maskTokens = true,
        private int $maxBodyLength = 1000
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $startTime = microtime(true);
        $requestId = uniqid('req_');
        
        // Log request
        $this->logRequest($request, $requestId);
        
        return $next($request)->then(
            function (ResponseInterface $response) use ($startTime, $requestId) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                // Log successful response
                $this->logResponse($response, $requestId, $duration);
                
                return $response;
            },
            function (\Throwable $exception) use ($startTime, $requestId) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                // Log error response
                $this->logException($exception, $requestId, $duration);
                
                throw $exception;
            }
        );
    }

    private function logRequest(RequestInterface $request, string $requestId): void
    {
        $uri = $this->maskSensitiveData((string) $request->getUri());
        
        $context = [
            'request_id' => $requestId,
            'method'     => $request->getMethod(),
            'uri'        => $uri,
            'headers'    => $this->maskHeaders($request->getHeaders()),
        ];
        
        if ($this->logBodies && $request->getBody()->getSize() > 0) {
            $body            = $request->getBody()->getContents();
            $context['body'] = $this->truncateBody($body);
            $request->getBody()->rewind();
        }
        
        $this->logger->log(
            $this->logLevel,
            sprintf('[GEOCACHING] HTTP Request: %s %s', $context['method'], $context['uri']),
            $context
        );
    }

    private function logResponse(ResponseInterface $response, string $requestId, float $duration): void
    {
        $context = [
            'request_id'    => $requestId,
            'status_code'   => $response->getStatusCode(),
            'duration_ms'   => $duration,
            'reason_phrase' => $response->getReasonPhrase(),
            'headers'       => $this->filterResponseHeaders($response->getHeaders()),
        ];
        
        if ($this->logBodies && $response->getBody()->getSize() > 0) {
            $body            = $response->getBody()->getContents();
            $context['body'] = $this->truncateBody($body);
            $response->getBody()->rewind();
        }
        
        // Use different log levels based on status code
        $level = $this->getLogLevelForStatus($response->getStatusCode());
        
        $this->logger->log(
            $level,
            sprintf('[GEOCACHING] HTTP Response: %d %s (%.2fms)', $context['status_code'], $context['reason_phrase'], $context['duration_ms']),
            $context
        );
    }

    private function logException(\Throwable $exception, string $requestId, float $duration): void
    {
        $context = [
            'request_id'        => $requestId,
            'duration_ms'       => $duration,
            'exception_class'   => $exception::class,
            'exception_message' => $exception->getMessage(),
            'exception_code'    => $exception->getCode(),
        ];
        
        $this->logger->error(
            sprintf('[GEOCACHING] HTTP Exception: %s (%.2fms)', $context['exception_class'], $context['duration_ms']),
            $context
        );
    }

    private function maskSensitiveData(string $uri): string
    {
        if (!$this->maskTokens) {
            return $uri;
        }
        
        // Mask access tokens in URLs
        $patterns = [
            '/access_token=[\w\-\.]+/i' => 'access_token=***',
            '/token=[\w\-\.]+/i'        => 'token=***',
            '/key=[\w\-\.]+/i'          => 'key=***',
        ];
        
        return preg_replace(array_keys($patterns), array_values($patterns), $uri);
    }

    private function maskHeaders(array $headers): array
    {
        if (!$this->maskTokens) {
            return $headers;
        }
        
        $maskedHeaders    = [];
        $sensitiveHeaders = ['authorization'];
        
        foreach ($headers as $name => $values) {
            if (in_array(strtolower((string) $name), $sensitiveHeaders, true)) {
                $maskedHeaders[$name] = ['***'];
            } else {
                $maskedHeaders[$name] = $values;
            }
        }
        
        return $maskedHeaders;
    }

    private function filterResponseHeaders(array $headers): array
    {
        // Keep only interesting headers for logging
        $interestingHeaders = [
            'content-type',
            'content-length',
            'x-ratelimit-remaining',
            'x-ratelimit-reset',
            'cache-control',
            'server',
        ];
        
        $filtered = [];
        foreach ($headers as $name => $values) {
            if (in_array(strtolower((string) $name), $interestingHeaders, true)) {
                $filtered[$name] = $values;
            }
        }
        
        return $filtered;
    }

    private function truncateBody(string $body): string
    {
        if (strlen($body) <= $this->maxBodyLength) {
            return $body;
        }
        
        return substr($body, 0, $this->maxBodyLength) . '... (truncated)';
    }

    private function getLogLevelForStatus(int $statusCode): string
    {
        return match (true) {
            $statusCode >= 500 => LogLevel::ERROR,
            $statusCode >= 400 => LogLevel::WARNING,
            $statusCode >= 300 => LogLevel::INFO,
            default            => $this->logLevel,
        };
    }
}
