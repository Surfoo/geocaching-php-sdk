<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\ListClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class ListClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected ListClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new ListClient($this->clientBuilder);
    }

    public function testGetList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/lists/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getList('list123');
        $this->assertSame($response, $result);
    }

    public function testDeleteList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/lists/list123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteList('list123');
        $this->assertSame($response, $result);
    }

    public function testUpdateList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/lists/list123'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateList('list123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetZippedPocketQuery(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/lists/list123/geocaches/zipped'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getZippedPocketQuery('list123', '/tmp');
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/lists/list123/geocaches'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheList('list123');
        $this->assertSame($response, $result);
    }

    public function testSetGeocacheList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/lists/list123/geocaches'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setGeocacheList('list123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testSetList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/lists'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setList(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testSetBulkGeocachesList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/lists/list123/bulkgeocaches'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setBulkGeocachesList('list123', [['foo' => 'bar']]);
        $this->assertSame($response, $result);
    }

    public function testDeleteGeocacheList(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/lists/list123/geocaches/GC123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteGeocacheList('list123', 'GC123');
        $this->assertSame($response, $result);
    }
}
