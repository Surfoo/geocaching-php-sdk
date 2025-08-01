<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;

abstract class AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
    }

    protected function getHttpClient(): \Http\Client\Common\HttpMethodsClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }

    /**
     * Build query string from array parameters.
     *
     * @param  array  $query Query parameters
     * @return string Query string with leading '?' or empty string
     */
    protected function buildQueryString(array $query): string
    {
        return !empty($query) ? '?' . http_build_query($query) : '';
    }
}
