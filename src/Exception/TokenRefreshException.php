<?php

declare(strict_types=1);

namespace Geocaching\Exception;

use Exception;
use Throwable;

/**
 * Exception thrown when token refresh fails.
 */
class TokenRefreshException extends Exception
{
    public function __construct(
        string $message = 'Failed to refresh access token',
        int $code = 0,
        ?Throwable $previous = null,
        private ?array $responseData = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the response data from the OAuth server (if available).
     *
     * @return array|null
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    /**
     * Create exception from OAuth error response.
     *
     * @param array $responseData
     * @param int $httpCode
     * @param Throwable|null $previous
     * @return self
     */
    public static function fromOAuthResponse(array $responseData, int $httpCode = 0, ?Throwable $previous = null): self
    {
        $error = $responseData['error'] ?? 'unknown_error';
        $description = $responseData['error_description'] ?? 'Token refresh failed';
        
        $message = "OAuth error '{$error}': {$description}";
        
        return new self($message, $httpCode, $previous, $responseData);
    }
}