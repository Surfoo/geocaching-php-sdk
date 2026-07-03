<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

/**
 * Retry strategy interface
 */
interface RetryStrategy
{
    /**
     * Calculate delay before next retry
     *
     * @param  int             $attempt   Current attempt number (1-based)
     * @param  \Throwable|null $exception The exception that triggered the retry, if any.
     *                                    When it wraps a 429 response carrying an
     *                                    x-rate-limit-reset header, that value takes
     *                                    precedence over the computed backoff.
     * @return int Delay in milliseconds
     */
    public function getDelay(int $attempt, ?\Throwable $exception = null): int;

    /**
     * Check if should retry for this exception
     */
    public function shouldRetry(\Throwable $exception, int $attempt): bool;
}
