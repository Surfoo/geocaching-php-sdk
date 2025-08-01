<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\LogClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class LogClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected LogClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new LogClient($this->clientBuilder);
    }

    public function testGetGeocacheLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachelogs/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheLog('GC123');
        $this->assertSame($response, $result);
    }

    public function testDeleteGeocacheLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/geocachelogs/GC123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteGeocacheLog('GC123');
        $this->assertSame($response, $result);
    }

    public function testUpdateGeocacheLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/geocachelogs/GC123'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateGeocacheLog('GC123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheLogUpvotes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachelogs/upvotes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheLogUpvotes();
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheLogImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachelogs/GC123/images'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheLogImages('GC123');
        $this->assertSame($response, $result);
    }

    public function testSetGeocacheLogImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/geocachelogs/GC123/images'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setGeocacheLogImages('GC123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testSetGeocacheLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/geocachelogs'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setGeocacheLog(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testDeleteGeocacheLogUpvotes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/geocachelogs/GC123/upvotes/1'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteGeocacheLogUpvotes('GC123', 1);
        $this->assertSame($response, $result);
    }

    public function testSetGeocacheLogUpvotes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/geocachelogs/GC123/upvotes/1'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setGeocacheLogUpvotes('GC123', 1);
        $this->assertSame($response, $result);
    }

    public function testDeleteGeocacheLogImage(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/geocachelogs/GC123/images/img123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteGeocacheLogImage('GC123', 'img123');
        $this->assertSame($response, $result);
    }
}
