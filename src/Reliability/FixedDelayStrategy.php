<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Psr\Http\Message\ResponseInterface;

/**
 * Fixed delay retry strategy
 */
class FixedDelayStrategy implements RetryStrategy
{
    /** @var string[] Exception classes that should trigger a retry */
    private readonly array $retryableExceptions;

    /** @var int[] HTTP status codes that should trigger a retry */
    private readonly array $retryableStatusCodes;

    public function __construct(
        private readonly int $delayMs = 1000,
        private readonly int $maxAttempts = 3,
        ?array $retryableExceptions = null,
        ?array $retryableStatusCodes = null
    ) {
        $this->retryableExceptions = $retryableExceptions ?? [
            NetworkException::class,
            \GuzzleHttp\Exception\ConnectException::class,
            \GuzzleHttp\Exception\RequestException::class,
        ];

        $this->retryableStatusCodes = $retryableStatusCodes ?? [
            429, // Too Many Requests
            500, // Internal Server Error
            502, // Bad Gateway
            503, // Service Unavailable
            504,  // Gateway Timeout
        ];
    }

    public function getDelay(int $attempt): int
    {
        return $attempt > 1 ? $this->delayMs : 0;
    }

    public function shouldRetry(\Throwable $exception, int $attempt): bool
    {
        if ($attempt >= $this->maxAttempts) {
            return false;
        }

        // Check if exception type is retryable
        foreach ($this->retryableExceptions as $retryableClass) {
            if ($exception instanceof $retryableClass) {
                return true;
            }
        }

        // Check HTTP status codes for HttpException
        if ($exception instanceof HttpException) {
            $response = $exception->getResponse();
            return in_array($response->getStatusCode(), $this->retryableStatusCodes, true);
        }

        return false;
    }

    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }
}
