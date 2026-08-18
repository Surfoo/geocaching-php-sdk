<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

/**
 * Exponential backoff retry strategy
 */
class ExponentialBackoffStrategy extends AbstractRetryStrategy
{
    public function __construct(
        private readonly int $baseDelayMs = 1000,
        private readonly float $multiplier = 2.0,
        private readonly int $maxDelayMs = 30000,
        int $maxAttempts = 3,
        ?array $retryableExceptions = null,
        ?array $retryableStatusCodes = null
    ) {
        parent::__construct($maxAttempts, $retryableExceptions, $retryableStatusCodes);
    }

    public function getDelay(int $attempt, ?\Throwable $exception = null): int
    {
        if ($attempt <= 1) {
            return 0;
        }

        $rateLimitDelay = $this->getRateLimitDelayMs($exception, $this->maxDelayMs);

        if ($rateLimitDelay !== null) {
            return $rateLimitDelay;
        }

        $delay = $this->baseDelayMs * $this->multiplier ** ($attempt - 2);

        // Add jitter (±20%) to prevent thundering herd
        $jitter = $delay * (random_int(-20, 20) / 100);
        $delay += $jitter;

        return min((int) $delay, $this->maxDelayMs);
    }
}
