<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\UserWaypointClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class UserWaypointClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected UserWaypointClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new UserWaypointClient($this->clientBuilder);
    }

    public function testGetUserWaypoints(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/userwaypoints'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserWaypoints();
        $this->assertSame($response, $result);
    }

    public function testSetGeocacheUserWaypoint(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/userwaypoints'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setGeocacheUserWaypoint('GC123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheUserWaypoints(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocaches/GC123/userwaypoints'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheUserWaypoints('GC123');
        $this->assertSame($response, $result);
    }

    public function testDeleteUserWaypoint(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/userwaypoints/GC123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteUserWaypoint('GC123');
        $this->assertSame($response, $result);
    }

    public function testUpdateCorrectedCoordinates(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/geocaches/GC123/correctedcoordinates'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateCorrectedCoordinates('GC123', ['lat' => 1, 'lon' => 2]);
        $this->assertSame($response, $result);
    }

    public function testDeleteCorrectedCoordinates(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/geocaches/GC123/correctedcoordinates'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteCorrectedCoordinates('GC123');
        $this->assertSame($response, $result);
    }

    public function testUpdateUserWaypoint(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/userwaypoints/GC123'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateUserWaypoint('GC123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }
}
