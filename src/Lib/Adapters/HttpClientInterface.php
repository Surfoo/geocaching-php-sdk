<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;

interface HttpClientInterface
{
    /**
     * @return \stdClass|array
     */
    public function getBody(bool $toArray = false);

    public function getHeaders(): array;

    public function getHeader(string $header): array;

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     *
     * @throws GeocachingSdkException
     */
    public function get(string $uri, array $data = [], array $options = []);

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     *
     * @throws GeocachingSdkException
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = []);

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     *
     * @throws GeocachingSdkException
     */
    public function put(string $uri, array $data, array $query = []);

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     *
     * @throws GeocachingSdkException
     */
    public function delete(string $uri);
}
