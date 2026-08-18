<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;

/**
 * Shared retry-eligibility logic for retry strategies
 */
abstract class AbstractRetryStrategy implements RetryStrategy
{
    use RateLimitAwareDelay;

    /** @var string[] Exception classes that should trigger a retry */
    protected readonly array $retryableExceptions;

    /** @var int[] HTTP status codes that should trigger a retry */
    protected readonly array $retryableStatusCodes;

    public function __construct(
        protected readonly int $maxAttempts,
        ?array $retryableExceptions,
        ?array $retryableStatusCodes
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

    public function isRetryableStatusCode(int $statusCode): bool
    {
        return in_array($statusCode, $this->retryableStatusCodes, true);
    }
}
