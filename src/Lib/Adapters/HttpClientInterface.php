<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;
use GuzzleHttp\Psr7\Response;

interface HttpClientInterface
{
    /**
     * @param bool $toArray
     *
     * @return \stdClass|array
     */
    public function getBody(bool $toArray = false);

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param string $header
     *
     * @return array
     */
    public function getHeader(string $header): array;

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $options
     *
     * @return Response
     *
     * @throws GeocachingSdkException
     */
    public function get(string $uri, array $data = [], array $options = []);

    /**
     * @param string $uri
     * @param array  $body
     * @param array  $query
     * @param array  $options
     *
     * @return Response
     *
     * @throws GeocachingSdkException
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = []);

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $query
     *
     * @return Response
     *
     * @throws GeocachingSdkException
     */
    public function put(string $uri, array $data, array $query = []);

    /**
     * @param string $uri
     *
     * @return Response
     *
     * @throws GeocachingSdkException
     */
    public function delete(string $uri);
}
