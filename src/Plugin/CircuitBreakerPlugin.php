<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Geocaching\Exception\CircuitBreakerOpenException;
use Geocaching\Reliability\CircuitBreaker;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * HTTPlug plugin that integrates Circuit Breaker pattern
 */
class CircuitBreakerPlugin implements Plugin
{
    public function __construct(
        private readonly CircuitBreaker $circuitBreaker,
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        // Check if circuit breaker allows the request
        if (!$this->circuitBreaker->canExecute()) {
            $this->logger->warning('Circuit breaker blocked request', [
                'uri'           => (string) $request->getUri(),
                'method'        => $request->getMethod(),
                'circuit_state' => $this->circuitBreaker->getState(),
                'failure_count' => $this->circuitBreaker->getFailureCount(),
                'next_retry'    => $this->circuitBreaker->getNextRetryTime()?->format('Y-m-d H:i:s'),
            ]);

            throw new CircuitBreakerOpenException(
                "Circuit breaker is open. Next retry at: " .
                $this->circuitBreaker->getNextRetryTime()?->format('Y-m-d H:i:s')
            );
        }

        // Execute request with circuit breaker protection
        return $this->circuitBreaker->call(fn() => $next($request));
    }
}
