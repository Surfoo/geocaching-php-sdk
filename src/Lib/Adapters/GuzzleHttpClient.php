<?php

namespace Geocaching\Lib\Adapters;

use Geocaching\Exception\GeocachingSdkException;
use Geocaching\Lib\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    const HEADER_AUTHORIZATION = 'Authorization';

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
            $this->options = array_merge($this->options, $options);
        }

        $this->client = $client;
    }

    /**
     * @param bool $toArray
     *
     * @return stdClass|array
     */
    public function getBody(bool $toArray = false)
    {
        return json_decode((string) $this->response->getBody(), $toArray);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
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
        } catch (\Exception $e) {
            $this->handleErrorResponse($e->getBody());
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
    public function post(string $uri, array $body = [], array $query = [])
    {
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        $this->options['json'] = $body;

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
    public function put(string $uri, array $body, array $query = [])
    {
        $this->options['json'] = $body;

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
     * @param ResponseInterface $response
     *
     * @throws GeocachingSdkException The request is invalid
     */
    private function handleErrorResponse(ResponseInterface $response)
    {
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
     * @param GuzzleHttp\Psr7\Stream $responseBody
     *
     * @return string
     */
    private function decodeError404ResponseBody(Stream $responseBody): string
    {
        $body = json_decode($responseBody);
        if ($body->errorMessage) {
            $content = json_decode($body->errorMessage);

            return $content->message;
        }

        return (string) $responseBody;
    }

    /**
     * @param GuzzleHttp\Psr7\Stream $responseBody
     *
     * @return string
     */
    private function decodeErrorResponseBody(Stream $responseBody): string
    {
        $body = json_decode($responseBody);
        if (isset($body->errors) && !empty($body->errors)) {
            return (string) $body->errors[0]->message;
        }

        return $body->errorMessage;
    }
}
