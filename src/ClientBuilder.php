<?php

declare(strict_types=1);

namespace Geocaching;

use Geocaching\Enum\BaseUri;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ClientBuilder implements ClientBuilderInterface
{
    private array $plugins   = [];
    private ?string $baseUri = null;

    public function __construct(
        private ?ClientInterface $httpClient = null,
        private ?RequestFactoryInterface $requestFactory = null,
        private ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient     = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory  = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();

        $this->addPlugin(new HeaderDefaultsPlugin([
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ]));
    }
    
    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }
    
    public function setBaseUri(string $baseUri): void
    {
        $this->baseUri = $baseUri;
    }
    
    public function getHttpClient(): HttpMethodsClientInterface
    {
        $pluginClient = (new PluginClientFactory())->createClient($this->httpClient, $this->plugins);

        return new HttpMethodsClient(
            $pluginClient,
            $this->requestFactory,
            $this->streamFactory
        );
    }

    public function getBaseUri(): string
    {
        return $this->baseUri ?? BaseUri::PRODUCTION->value;
    }

    // Client factory methods for dependency injection
    public function getAdventureClient(): \Geocaching\Client\AdventureClient
    {
        return new \Geocaching\Client\AdventureClient($this);
    }
    public function getFriendClient(): \Geocaching\Client\FriendClient
    {
        return new \Geocaching\Client\FriendClient($this);
    }
    public function getLogClient(): \Geocaching\Client\LogClient
    {
        return new \Geocaching\Client\LogClient($this);
    }
    public function getGeocacheClient(): \Geocaching\Client\GeocacheClient
    {
        return new \Geocaching\Client\GeocacheClient($this);
    }
    public function getTrackableClient(): \Geocaching\Client\TrackableClient
    {
        return new \Geocaching\Client\TrackableClient($this);
    }
    public function getUserClient(): \Geocaching\Client\UserClient
    {
        return new \Geocaching\Client\UserClient($this);
    }
    public function getListClient(): \Geocaching\Client\ListClient
    {
        return new \Geocaching\Client\ListClient($this);
    }
    public function getLogdraftClient(): \Geocaching\Client\LogdraftClient
    {
        return new \Geocaching\Client\LogdraftClient($this);
    }
    public function getReferenceDataClient(): \Geocaching\Client\ReferenceDataClient
    {
        return new \Geocaching\Client\ReferenceDataClient($this);
    }
    public function getUserWaypointClient(): \Geocaching\Client\UserWaypointClient
    {
        return new \Geocaching\Client\UserWaypointClient($this);
    }
    public function getStatusClient(): \Geocaching\Client\StatusClient
    {
        return new \Geocaching\Client\StatusClient($this);
    }
    public function getWherigoClient(): \Geocaching\Client\WherigoClient
    {
        return new \Geocaching\Client\WherigoClient($this);
    }
    public function getStatisticsClient(): \Geocaching\Client\StatisticsClient
    {
        return new \Geocaching\Client\StatisticsClient($this);
    }
}
