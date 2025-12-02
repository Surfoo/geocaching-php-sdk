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
     * @param  int $attempt Current attempt number (1-based)
     * @return int Delay in milliseconds
     */
    public function getDelay(int $attempt): int;

    /**
     * Check if should retry for this exception
     */
    public function shouldRetry(\Throwable $exception, int $attempt): bool;
}
