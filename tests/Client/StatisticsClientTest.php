<?php

declare(strict_types=1);


namespace Tests;

use Geocaching\ClientBuilder;
use Geocaching\Client\StatisticsClient;
use Http\Mock\Client as MockHttpClient;
use Psr\Http\Message\ResponseInterface;

class StatisticsClientTest extends TestCase
{
    public function testGetDifficultyTerrainStatisticsReturnsResponse()
    {
        $mockHttpClient = new MockHttpClient();
        $builder = new ClientBuilder($mockHttpClient);
        $client = $this->getMockBuilder(StatisticsClient::class)
            ->setConstructorArgs([$builder])
            ->onlyMethods(['getHttpClient'])
            ->getMock();

        $response = $this->createMock(ResponseInterface::class);
        $httpClient = $this->createMock(\Http\Client\Common\HttpMethodsClientInterface::class);
        $httpClient->expects($this->once())
            ->method('get')
            ->with('/v1/statistics/difficultyterrain', [])
            ->willReturn($response);

        $client->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $result = $client->getDifficultyTerrainStatistics();
        $this->assertSame($response, $result);
    }
}
