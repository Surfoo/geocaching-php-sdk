<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\LogdraftClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class LogdraftClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected LogdraftClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new LogdraftClient($this->clientBuilder);
    }

    public function testGetLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/logdrafts/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getLogdraft('logdraft123');
        $this->assertSame($response, $result);
    }

    public function testDeleteLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/logdrafts/logdraft123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteLogdraft('logdraft123');
        $this->assertSame($response, $result);
    }

    public function testUpdateLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/logdrafts/logdraft123'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateLogdraft('logdraft123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetLogdrafts(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/logdrafts'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getLogdrafts();
        $this->assertSame($response, $result);
    }

    public function testSetLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/logdrafts'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setLogdraft(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testPromoteLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/logdrafts/logdraft123/promote'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->promoteLogdraft('logdraft123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testSetLogdraftImage(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/logdrafts/logdraft123/images'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setLogdraftImage('logdraft123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testDeleteImageFromLogdraft(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/logdrafts/logdraft123/guid123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteImageFromLogdraft('logdraft123', 'guid123');
        $this->assertSame($response, $result);
    }
}
