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
}
