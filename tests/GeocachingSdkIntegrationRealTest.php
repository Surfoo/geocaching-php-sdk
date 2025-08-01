<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\ClientBuilder;

class GeocachingSdkIntegrationRealTest extends TestCase
{
    public function testInstrumentationOfGeocachingSdk()
    {
        $clientBuilder = new ClientBuilder();
        $options = $this->getMockBuilder(Options::class)
            ->disableOriginalConstructor()
            ->getMock();
        $options->method('getClientBuilder')->willReturn($clientBuilder);
        $sdk = new GeocachingSdk($options);

        // Appel explicite d'une méthode native (hors proxy)
        $httpClient = $sdk->getHttpClient();
        $this->assertInstanceOf(\Http\Client\Common\HttpMethodsClientInterface::class, $httpClient);
    }
    public function testAllFacadeMethodsAreCalled()
    {
        // On crée un ClientBuilder qui retourne de vrais clients (signatures compatibles)
        $clientBuilder = new ClientBuilder();
        $options = $this->getMockBuilder(Options::class)
            ->disableOriginalConstructor()
            ->getMock();
        $options->method('getClientBuilder')->willReturn($clientBuilder);
        $sdk = new GeocachingSdk($options);

        // Appel de tous les accesseurs (façade)
        $this->assertInstanceOf(\Geocaching\Client\AdventureClient::class, $sdk->adventureClient());
        $this->assertInstanceOf(\Geocaching\Client\FriendClient::class, $sdk->friendClient());
        $this->assertInstanceOf(\Geocaching\Client\LogClient::class, $sdk->logClient());
        $this->assertInstanceOf(\Geocaching\Client\GeocacheClient::class, $sdk->geocacheClient());
        $this->assertInstanceOf(\Geocaching\Client\TrackableClient::class, $sdk->trackableClient());
        $this->assertInstanceOf(\Geocaching\Client\UserClient::class, $sdk->userClient());
        $this->assertInstanceOf(\Geocaching\Client\ListClient::class, $sdk->listClient());
        $this->assertInstanceOf(\Geocaching\Client\LogdraftClient::class, $sdk->logdraftClient());
        $this->assertInstanceOf(\Geocaching\Client\ReferenceDataClient::class, $sdk->referenceDataClient());
        $this->assertInstanceOf(\Geocaching\Client\UserWaypointClient::class, $sdk->userWaypointClient());
        $this->assertInstanceOf(\Geocaching\Client\StatusClient::class, $sdk->statusClient());
        $this->assertInstanceOf(\Geocaching\Client\WherigoClient::class, $sdk->wherigoClient());
        $this->assertInstanceOf(\Http\Client\Common\HttpMethodsClientInterface::class, $sdk->getHttpClient());
    }
}
