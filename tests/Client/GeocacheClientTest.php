<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\GeocacheClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class GeocacheClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected GeocacheClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new GeocacheClient($this->clientBuilder);
    }

    public function testGetGeocache(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocache('GC123');
        $this->assertSame($response, $result);
    }


    public function testGetGeocacheImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/GC123/images'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheImages('GC123');
        $this->assertSame($response, $result);
    }

    public function testGetFavoritedUsersByGeocache(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/GC123/favoritedby'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getFavoritedUsersByGeocache('GC123');
        $this->assertSame($response, $result);
    }

    public function testGetGeocaches(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocaches(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheTrackables(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/GC123/trackables'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheTrackables('GC123');
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheLogs(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/GC123/geocachelogs'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheLogs('GC123');
        $this->assertSame($response, $result);
    }

    public function testSearchGeocaches(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/search'), $this->anything())
            ->willReturn($response);
        $result = $this->client->searchGeocaches(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testCheckFinalCoordinates(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/geocaches/GC123/finalcoordinates'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->checkFinalCoordinates('GC123', ['lat' => 1, 'lon' => 2]);
        $this->assertSame($response, $result);
    }

    public function testSetBulkTrackableLogs(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/geocaches/GC123/bulktrackablelogs'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setBulkTrackableLogs('GC123', [['foo' => 'bar']]);
        $this->assertSame($response, $result);
    }
}
