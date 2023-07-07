<?php

declare(strict_types=1);

namespace Geocaching;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Geocaching\Enum\{Environment, BaseUri};
final class Options
{
    /**
     * Version of the API.
     *
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
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['environment', 'uri']);
        $resolver->setDefaults(
            [
                'client_builder' => new ClientBuilder(),
                'uri_factory'    => Psr17FactoryDiscovery::findUriFactory(),
            ]
        );

        $resolver->setAllowedTypes('environment', Environment::class);
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
}