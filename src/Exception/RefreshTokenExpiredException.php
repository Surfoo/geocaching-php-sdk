<?php

declare(strict_types=1);

namespace Geocaching\Exception;

/**
 * Exception thrown when the refresh token is expired or invalid.
 * 
 * This indicates that the user must re-authenticate to obtain new tokens.
 */
class RefreshTokenExpiredException extends TokenRefreshException
{
    public function __construct(
        string $message = 'Refresh token has expired. User must re-authenticate.',
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}