<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Geocaching\Reliability\CircuitBreaker;
use Geocaching\Reliability\RetryHandler;
use Geocaching\Reliability\RetryStrategy;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * HTTPlug plugin that combines Circuit Breaker and Retry patterns
 *
 * This plugin first checks the circuit breaker, then applies retry logic if needed.
 * The order is important: circuit breaker prevents cascading failures,
 * while retry handles transient errors within acceptable limits.
 */
class ReliabilityPlugin implements Plugin
{
    private readonly RetryHandler $retryHandler;

    public function __construct(
        private readonly CircuitBreaker $circuitBreaker,
        RetryStrategy $retryStrategy,
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
        $this->retryHandler = new RetryHandler($retryStrategy, $logger);
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        // First layer: Circuit Breaker protection
        return $this->circuitBreaker->call(fn() =>
            // Second layer: Retry logic
            $this->retryHandler->execute(fn() => $next($request)));
    }

    /**
     * Get circuit breaker state information
     */
    public function getCircuitBreakerState(): array
    {
        return [
            'state'           => $this->circuitBreaker->getState(),
            'failure_count'   => $this->circuitBreaker->getFailureCount(),
            'next_retry_time' => $this->circuitBreaker->getNextRetryTime()?->format('Y-m-d H:i:s'),
            'can_execute'     => $this->circuitBreaker->canExecute(),
        ];
    }

    /**
     * Get the circuit breaker instance
     */
    public function getCircuitBreaker(): CircuitBreaker
    {
        return $this->circuitBreaker;
    }

    /**
     * Get the retry handler instance
     */
    public function getRetryHandler(): RetryHandler
    {
        return $this->retryHandler;
    }

    /**
     * Reset circuit breaker to closed state
     */
    public function resetCircuitBreaker(): void
    {
        $this->circuitBreaker->reset();
        $this->logger->info('Circuit breaker manually reset to closed state');
    }

    /**
     * Force circuit breaker to open state (useful for maintenance)
     */
    public function openCircuitBreaker(): void
    {
        $this->circuitBreaker->forceOpen();
        $this->logger->warning('Circuit breaker manually forced to open state');
    }
}
