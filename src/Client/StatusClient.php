<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Message\ResponseInterface;

class StatusClient
{
    public function __construct(private ClientBuilderInterface $clientBuilder)
    {
    }

    /**
     * @codeCoverageIgnore
     */
    public function status(): ResponseInterface
    {
        return $this->ping();
    }

    /**
     * @codeCoverageIgnore
     */
    public function ping(): ResponseInterface
    {
        // Status/ping endpoint doesn't follow API versioning and doesn't need auth
        // Create a client with only logging plugins (no auth, no base URI)
        $httpClient = $this->createStatusHttpClient();
        
        // Get the correct base URI based on environment (staging/production)
        $baseUri = $this->clientBuilder->getBaseUri();
        
        // Make request with absolute URL to bypass BaseUriPlugin
        return $httpClient->get($baseUri . '/status/ping');
    }

    /**
     * Create HTTP client for status endpoints with logging but without auth/BaseUri plugins.
     * @codeCoverageIgnore
     */
    private function createStatusHttpClient()
    {
        $rawHttpClient = Psr18ClientDiscovery::find();
        // Get all plugins from the client builder
        $reflection      = new \ReflectionClass($this->clientBuilder);
        $pluginsProperty = $reflection->getProperty('plugins');
        $pluginsProperty->setAccessible(true);
        $allPlugins = $pluginsProperty->getValue($this->clientBuilder);
        
        // Filter to keep only logging plugins (not auth, not base URI)
        $statusPlugins = [];
        foreach ($allPlugins as $plugin) {
            // Keep logging plugins and header defaults, skip auth and base URI
            if (!$plugin instanceof \Http\Client\Common\Plugin\AuthenticationPlugin &&
                !$plugin instanceof \Http\Client\Common\Plugin\BaseUriPlugin) {
                $statusPlugins[] = $plugin;
            }
        }
        
        // Create plugin client with filtered plugins
        $pluginClient = (new PluginClientFactory())->createClient($rawHttpClient, $statusPlugins);
        
        // Create HttpMethodsClient for convenience methods
        $requestFactory = $reflection->getProperty('requestFactory');
        $requestFactory->setAccessible(true);
        $streamFactory = $reflection->getProperty('streamFactory');
        $streamFactory->setAccessible(true);
        
        return new \Http\Client\Common\HttpMethodsClient(
            $pluginClient,
            $requestFactory->getValue($this->clientBuilder),
            $streamFactory->getValue($this->clientBuilder)
        );
    }
}
