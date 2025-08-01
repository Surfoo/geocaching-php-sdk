<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\ReferenceDataClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class ReferenceDataClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected ReferenceDataClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new ReferenceDataClient($this->clientBuilder);
    }

    public function testGetCountries(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/countries'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getCountries();
        $this->assertSame($response, $result);
    }

    public function testGetReferenceCodeFromId(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/utilities/referencecode'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getReferenceCodeFromId(['id' => 1]);
        $this->assertSame($response, $result);
    }

    public function testGetStates(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/states'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getStates();
        $this->assertSame($response, $result);
    }

    public function testGetStatesByCountry(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/countries/1/states'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getStatesByCountry(1);
        $this->assertSame($response, $result);
    }

    public function testGetMembershipLevels(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/membershiplevels'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getMembershipLevels();
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheTypes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachetypes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheTypes();
        $this->assertSame($response, $result);
    }

    public function testGetAttributes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/attributes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getAttributes();
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheSizes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachesizes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheSizes();
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheStatuses(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachestatuses'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheStatuses();
        $this->assertSame($response, $result);
    }

    public function testGetGeocacheLogTypes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/geocachelogtypes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getGeocacheLogTypes();
        $this->assertSame($response, $result);
    }

    public function testGetTrackableLogTypes(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/trackablelogtypes'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getTrackableLogTypes();
        $this->assertSame($response, $result);
    }
}
