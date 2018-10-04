<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    const HEADER_AUTHORIZATION = 'Authorization';

    /**
     * @var Response
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
     *
     * @param Client $client
     * @param string $token
     * @param array  $options
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
     * @param bool $toArray
     *
     * @return \stdClass|array
     */
    public function getBody(bool $toArray = false)
    {
        $content = (string) $this->response->getBody();
        if (empty($content)) {
            $content = '{}';
        }
        return json_decode($content, $toArray);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * @param string $header
     *
     * @return array
     */
    public function getHeader(string $header): array
    {
        return $this->response->getHeader($header);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->response->getReasonPhrase();
    }

    /**
     * @param string $uri
     * @param array  $query
     *
     * @return \Geocaching\Lib\Response\Response|mixed
     */
    public function get(string $uri, array $query = [])
    {
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->request('GET', $uri, $this->options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @param string $uri
     * @param array  $body
     * @param array  $query
     *
     * @return \Geocaching\Lib\Response\Response|mixed
     */
    public function post(string $uri, array $body = [], array $query = [], array $options = [])
    {
        $this->options = array_merge_recursive($this->options, $options);

        if (!empty($body)) {
            $this->options['json'] = $body;
        }

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        try {
            $this->response = $this->client->request('POST', $uri, $this->options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @param string $uri
     * @param array  $body
     * @param array  $query
     *
     * @return \Geocaching\Lib\Response\Response|mixed
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
            throw new GeocachingSdkException($e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return \Geocaching\Lib\Response\Response|mixed
     */
    public function delete(string $uri)
    {
        $response = null;

        try {
            $this->response = $this->client->request('DELETE', $uri, $this->options);
        } catch (ConnectException $e) {
            throw new GeocachingSdkException($e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            $this->handleErrorResponse($e->getResponse());
        }

        return $this;
    }

    /**
     * @param ResponseInterface|null $response
     *
     * @throws GeocachingSdkException The request is invalid
     *
     * @return void
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

    /**
     * @param array $headers
     *
     * @return string
     */
    private function decodeError401(array $headers): string
    {
        return $headers['WWW-Authenticate'][0];
    }

    /**
     * @param StreamInterface $responseBody
     *
     * @return string
     */
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

    /**
     * @param StreamInterface $responseBody
     *
     * @return string
     */
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
