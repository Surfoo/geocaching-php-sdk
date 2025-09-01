<?php

declare(strict_types=1);

namespace Geocaching\Exception;

use Exception;

/**
 * Exception thrown when token storage operations fail.
 */
class TokenStorageException extends Exception
{
    public function __construct(
        string $message = 'Token storage operation failed',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}