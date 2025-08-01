<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\WherigoClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class WherigoClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected WherigoClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new WherigoClient($this->clientBuilder);
    }

    public function testGetWherigoCartridge(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/wherigo/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getWherigoCartridge('guid123');
        $this->assertSame($response, $result);
    }
}
