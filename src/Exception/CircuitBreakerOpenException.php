<?php

declare(strict_types=1);

namespace Geocaching\Exception;

use Exception;

/**
 * Exception thrown when Circuit Breaker is in open state
 */
class CircuitBreakerOpenException extends Exception
{
}
