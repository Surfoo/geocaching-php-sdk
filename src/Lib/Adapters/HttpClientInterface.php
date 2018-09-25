<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Lib\Response\Response;

interface HttpClientInterface
{
    /**
     * @param bool $toArray
     *
     * @return stdClass|array
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
     *
     * @return Response
     *
     * @throws GeocachingException
     */
    public function get(string $uri, array $data);

    /**
     * @param string $uri
     * @param array $body
     * @param array $query
     * @param array $options
     *
     * @return Response
     *
     * @throws GeocachingException
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = []);

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return Response
     *
     * @throws GeocachingException
     */
    public function put(string $uri, array $data);

    /**
     * @param string $uri
     *
     * @return Response
     *
     * @throws GeocachingException
     */
    public function delete(string $uri);
}
