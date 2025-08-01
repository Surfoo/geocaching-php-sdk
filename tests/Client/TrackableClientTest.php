<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\TrackableClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class TrackableClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected TrackableClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new TrackableClient($this->clientBuilder);
    }

    public function testGetTrackableLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackablelogs/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableLog('TB123');
        $this->assertSame($response, $result);
    }

    public function testDeleteTrackableLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/trackablelogs/TB123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteTrackableLog('TB123');
        $this->assertSame($response, $result);
    }

    public function testUpdateTrackableLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('put')
            ->with($this->stringContains('/trackablelogs/TB123'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->updateTrackableLog('TB123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetUserTrackableLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackablelogs/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserTrackableLog();
        $this->assertSame($response, $result);
    }

    public function testGetTrackableLogImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackablelogs/TB123/images'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableLogImages('TB123');
        $this->assertSame($response, $result);
    }

    public function testSetTrackableLogImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/trackablelogs/TB123/images'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setTrackableLogImages('TB123', ['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testDeleteTrackableLogImage(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/trackablelogs/TB123/images/img123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteTrackableLogImage('TB123', 'img123');
        $this->assertSame($response, $result);
    }

    public function testSetTrackableLog(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/trackablelogs'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->setTrackableLog(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetTrackable(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackables/TB123'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackable('TB123');
        $this->assertSame($response, $result);
    }

    public function testGetUserTrackables(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackables'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserTrackables();
        $this->assertSame($response, $result);
    }

    public function testGetTrackableJourneys(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackables/TB123/journeys'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableJourneys('TB123');
        $this->assertSame($response, $result);
    }

    public function testGetGeocoinTypes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocointypes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocoinTypes();
        $this->assertSame($response, $result);
    }

    public function testGetTrackableImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackables/TB123/images'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableImages('TB123');
        $this->assertSame($response, $result);
    }

    public function testGetTrackableLogs(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackables/TB123/trackablelogs'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableLogs('TB123');
        $this->assertSame($response, $result);
    }
}
