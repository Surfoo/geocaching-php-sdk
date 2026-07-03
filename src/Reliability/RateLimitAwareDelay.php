<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Http\Client\Exception\HttpException;

/**
 * Shared logic for retry strategies to honor the Geocaching API's
 * x-rate-limit-reset header on 429 responses, ahead of the computed backoff.
 */
trait RateLimitAwareDelay
{
    private function getRateLimitDelayMs(?\Throwable $exception, int $maxDelayMs): ?int
    {
        if (!$exception instanceof HttpException) {
            return null;
        }

        $response = $exception->getResponse();

        if ($response->getStatusCode() !== 429) {
            return null;
        }

        $resetSeconds = RateLimitInfo::getResetSeconds($response);

        if ($resetSeconds === null) {
            return null;
        }

        return min($resetSeconds * 1000, $maxDelayMs);
    }
}
