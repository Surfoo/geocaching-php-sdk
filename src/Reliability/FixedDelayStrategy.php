<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

/**
 * Fixed delay retry strategy
 */
class FixedDelayStrategy extends AbstractRetryStrategy
{
    public function __construct(
        private readonly int $delayMs = 1000,
        int $maxAttempts = 3,
        ?array $retryableExceptions = null,
        ?array $retryableStatusCodes = null,
        private readonly int $maxDelayMs = 30000
    ) {
        parent::__construct($maxAttempts, $retryableExceptions, $retryableStatusCodes);
    }

    public function getDelay(int $attempt, ?\Throwable $exception = null): int
    {
        if ($attempt <= 1) {
            return 0;
        }

        $rateLimitDelay = $this->getRateLimitDelayMs($exception, $this->maxDelayMs);

        return $rateLimitDelay ?? $this->delayMs;
    }
}
