<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\AdventureClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class AdventureClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected AdventureClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new AdventureClient($this->clientBuilder);
    }

    public function testGetAdventure(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/adventures/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getAdventure('adv123');
        $this->assertSame($response, $result);
    }

    public function testGetStartLocationAdventure(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/adventures/anon/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getStartLocationAdventure('adv123');
        $this->assertSame($response, $result);
    }

    public function testSearchAdventures(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/adventures'), $this->anything())
            ->willReturn($response);
        $result = $this->client->searchAdventures(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testSearchAdventuresStages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/adventures/stages/search'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->searchAdventuresStages(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }
}
