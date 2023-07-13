<?php

declare(strict_types=1);

namespace Geocaching;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Geocaching\Enum\{Environment, BaseUri};
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Message\Authentication\Bearer;

final class Options
{
    /**
     * @const string
     */
    const API_VERSION = 'v1';

    private array $options;

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $baseUri = match($options['environment']) {
            Environment::STAGING => BaseUri::STAGING,
            default              => BaseUri::PRODUCTION,
        };

        $options['uri'] = sprintf('%s/%s/', $baseUri->value, self::API_VERSION);

        $this->options = $resolver->resolve($options);

        $this->getClientBuilder()->addPlugin(new BaseUriPlugin($this->getUri()));
        $this->getClientBuilder()->addPlugin(new AuthenticationPlugin(new Bearer($this->getAccessToken())));
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['environment', 'access_token', 'uri']);
        $resolver->setDefaults(
            [
                'client_builder' => new ClientBuilder(),
                'uri_factory'    => Psr17FactoryDiscovery::findUriFactory(),
            ]
        );

        $resolver->setAllowedTypes('environment', Environment::class);
        $resolver->setAllowedTypes('access_token', 'string');
        $resolver->setAllowedTypes('client_builder', ClientBuilder::class);
        $resolver->setAllowedTypes('uri_factory', UriFactoryInterface::class);
        $resolver->setAllowedTypes('uri', 'string');
    }

    public function getClientBuilder(): ClientBuilder
    {
        return $this->options['client_builder'];
    }

    public function getEnvironment(): string
    {
        return $this->options['environment'];
    }

    public function getUriFactory(): UriFactoryInterface
    {
        return $this->options['uri_factory'];
    }

    public function getUri(): UriInterface
    {
        return $this->getUriFactory()->createUri($this->options['uri']);
    }

    public function getAccessToken(): string
    {
        return $this->options['access_token'];
    }
}