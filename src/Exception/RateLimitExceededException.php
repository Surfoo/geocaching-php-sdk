<?php

declare(strict_types=1);

namespace Geocaching\Exception;

use Http\Client\Exception\HttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Exception thrown when the Geocaching API rate limit (HTTP 429) is exceeded
 * and all configured retry attempts have been exhausted.
 */
class RateLimitExceededException extends HttpException
{
    public function __construct(
        string $message,
        RequestInterface $request,
        ResponseInterface $response,
        private readonly ?int $retryAfterSeconds,
        ?\Exception $previous = null
    ) {
        parent::__construct($message, $request, $response, $previous);
    }

    /**
     * Returns the response.
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Number of seconds until the rate limit resets, taken from the
     * x-rate-limit-reset response header, if available.
     */
    public function getRetryAfterSeconds(): ?int
    {
        return $this->retryAfterSeconds;
    }
}
