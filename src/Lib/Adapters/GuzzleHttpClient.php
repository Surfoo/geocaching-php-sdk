<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class GuzzleHttpClient implements HttpClientInterface
{
    const HEADER_AUTHORIZATION = 'Authorization';

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    private $options = [
        'headers' => [
            self::HEADER_AUTHORIZATION => '',
        ],
        'timeout'         => 3,
        'connect_timeout' => 3,
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * GuzzleHttpClient constructor.
     */
    public function __construct(Client $client, string $token, array $options = [])
    {
        $this->options['headers'][self::HEADER_AUTHORIZATION] = sprintf('Bearer %s', $token);
        if (!empty($options)) {
            $this->options = array_replace_recursive($this->options, $options);
        }

        $this->client = $client;
    }

    /**
     * @return \stdClass|array
     */
    public function getBody(bool $toArray = false)
    {
        if ($this->response === null) {
            throw new GeocachingSdkException('response is null');
        }

        $content = (string) $this->response->getBody();
        if (empty($content)) {
            $content = '{}';
        }
        return json_decode($content, $toArray);
    }

    public function getHeaders(): array
    {
        if ($this->response === null) {
            throw new GeocachingSdkException('response is null');
        }
        return $this->response->getHeaders();
    }

    public function getHeader(string $header): array
    {
        if ($this->response === null) {
            throw new GeocachingSdkException('response is null');
        }
        return $this->response->getHeader($header);
    }

    public function getStatusCode(): int
    {
        if ($this->response === null) {
            throw new GeocachingSdkException('response is null');
        }
        return $this->response->getStatusCode();
    }

    public function getReasonPhrase(): string
    {
        if ($this->response === null) {
            throw new GeocachingSdkException('response is null');
        }
        return $this->response->getReasonPhrase();
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function get(string $uri, array $query = [], array $options = [])
    {
        $options = array_replace_recursive($this->options, $options);

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->get($uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'uri'      => $uri,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        } catch (RequestException $e) {
            $response = null;
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
            }
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'response' => $response,
                 'uri'      => $uri,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = [])
    {
        $options = array_replace_recursive($this->options, $options);

        if (!empty($body)) {
            $options['json'] = $body;
        }

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->post($uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'uri'      => $uri,
                 'body'     => $body,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        } catch (RequestException $e) {
            $response = null;
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
            }
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'response' => $response,
                 'uri'      => $uri,
                 'body'     => $body,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function put(string $uri, array $body, array $query = [], array $options = [])
    {
        $options = array_replace_recursive($this->options, $options);

        if (!empty($body)) {
            $options['json'] = $body;
        }

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->put($uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'uri'      => $uri,
                 'body'     => $body,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        } catch (RequestException $e) {
            $response = null;
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
            }
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'response' => $response,
                 'uri'      => $uri,
                 'body'     => $body,
                 'query'    => $query,
                 'options'  => $options,
                ]
            );
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function delete(string $uri, array $options = [])
    {
        $options = array_replace_recursive($this->options, $options);

        try {
            $this->response = $this->client->delete($uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'uri'      => $uri,
                 'options'  => $options,
                ]
            );
        } catch (RequestException $e) {
            $response = null;
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
            }
            throw new GeocachingSdkException(
                $e->getMessage(),
                $e->getCode(),
                [
                 'response' => $response,
                 'uri'      => $uri,
                 'options'  => $options,
                ]
            );
        }

        return $this;
    }
}
