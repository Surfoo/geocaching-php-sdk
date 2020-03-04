<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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
        $options = array_merge_recursive($this->options, $options);

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->request('GET', $uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode(), ['uri' => $uri, 'query' => $query, 'options' => $options]);
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = [])
    {
        $options = array_merge_recursive($this->options, $options);

        if (!empty($body)) {
            $options['json'] = $body;
        }

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->request('POST', $uri, $options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode(), ['uri' => $uri, 'body' => $body, 'query' => $query, 'options' => $options]);
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function put(string $uri, array $body, array $query = [], array $options = [])
    {
        $this->options = array_merge_recursive($this->options, $options);

        if (!empty($body)) {
            $this->options['json'] = $body;
        }

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->request('PUT', $uri, $this->options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode(), ['uri' => $uri, 'body' => $body, 'query' => $query, 'options' => $this->options]);
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function delete(string $uri)
    {
        $response = null;

        try {
            $this->response = $this->client->request('DELETE', $uri, $this->options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode(), ['uri' => $uri, 'options' => $this->options]);
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @throws GeocachingSdkException The request is invalid
     */
    private function handleErrorResponse(?ResponseInterface $response): void
    {
        if (is_null($response)) {
            throw new GeocachingSdkException('Error: Empty response.');
        }

        switch ($response->getStatusCode()) {
            case 401:
                throw new GeocachingSdkException($this->decodeError401($response->getHeaders()), $response->getStatusCode());
            case 404:
                throw new GeocachingSdkException($this->decodeError404ResponseBody($response->getBody()), $response->getStatusCode());
            default:
                throw new GeocachingSdkException($this->decodeErrorResponseBody($response->getBody()), $response->getStatusCode());
        }
    }

    private function decodeError401(array $headers): string
    {
        return $headers['WWW-Authenticate'][0];
    }

    private function decodeError404ResponseBody(StreamInterface $responseBody): string
    {
        $body = json_decode($responseBody);

        if ($body && $body->errorMessage) {
            $content = json_decode($body->errorMessage);
            if ($content && $body->errorMessage != $content && isset($content->message)) {
                return $content->message;
            } else {
                return (string) $body->errorMessage;
            }
        }

        return (string) $responseBody;
    }

    private function decodeErrorResponseBody(StreamInterface $responseBody): string
    {
        $body = json_decode($responseBody);

        if ($body && isset($body->errors) && !empty($body->errors)) {
            return (string) $body->errors[0]->message;
        }
        if ($body && isset($body->errorMessage) && !empty($body->errorMessage)) {
            return (string) $body->errorMessage;
        }

        return (string) $responseBody;
    }
}
