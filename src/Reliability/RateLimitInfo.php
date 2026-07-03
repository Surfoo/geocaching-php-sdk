<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Psr\Http\Message\ResponseInterface;

/**
 * Parses Geocaching API rate limit headers
 */
final class RateLimitInfo
{
    public const HEADER_RESET = 'x-rate-limit-reset';

    /**
     * Get the number of seconds until the rate limit resets, if present on the response.
     */
    public static function getResetSeconds(ResponseInterface $response): ?int
    {
        if (!$response->hasHeader(self::HEADER_RESET)) {
            return null;
        }

        $value = $response->getHeaderLine(self::HEADER_RESET);

        if (!is_numeric($value)) {
            return null;
        }

        return max(0, (int) $value);
    }
}
