<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use DateTimeImmutable;
use Geocaching\Exception\CircuitBreakerOpenException;

/**
 * Circuit Breaker implementation to prevent cascading failures
 *
 * States:
 * - CLOSED: Normal operation, requests pass through
 * - OPEN: Circuit is open, requests fail fast
 * - HALF_OPEN: Testing if service is recovered
 */
class CircuitBreaker
{
    private const STATE_CLOSED    = 'closed';
    private const STATE_OPEN      = 'open';
    private const STATE_HALF_OPEN = 'half_open';

    private string $state                       = self::STATE_CLOSED;
    private int $failureCount                   = 0;
    private int $successCount                   = 0;
    private ?DateTimeImmutable $lastFailureTime = null;
    private ?DateTimeImmutable $nextRetryTime   = null;

    public function __construct(
        private readonly int $failureThreshold = 5,
        private readonly int $recoveryTimeoutSeconds = 30,
        private readonly int $successThreshold = 2
    ) {
    }

    /**
     * Execute a callable with circuit breaker protection
     */
    public function call(callable $callable): mixed
    {
        if ($this->isOpen()) {
            throw new CircuitBreakerOpenException(
                "Circuit breaker is open. Next retry at: " .
                $this->nextRetryTime?->format('Y-m-d H:i:s')
            );
        }

        try {
            $result = $callable();
            $this->onSuccess();
            return $result;
        } catch (\Throwable $e) {
            $this->onFailure();
            throw $e;
        }
    }

    /**
     * Check if circuit breaker allows the request
     */
    public function canExecute(): bool
    {
        return !$this->isOpen();
    }

    /**
     * Get current circuit breaker state
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get failure count
     */
    public function getFailureCount(): int
    {
        return $this->failureCount;
    }

    /**
     * Get next retry time (when circuit will go to half-open)
     */
    public function getNextRetryTime(): ?DateTimeImmutable
    {
        return $this->nextRetryTime;
    }

    /**
     * Reset circuit breaker to closed state
     */
    public function reset(): void
    {
        $this->state           = self::STATE_CLOSED;
        $this->failureCount    = 0;
        $this->successCount    = 0;
        $this->lastFailureTime = null;
        $this->nextRetryTime   = null;
    }

    /**
     * Force circuit breaker to open state (for testing)
     */
    public function forceOpen(): void
    {
        $this->state           = self::STATE_OPEN;
        $this->lastFailureTime = new DateTimeImmutable();
        $this->nextRetryTime   = $this->lastFailureTime->modify("+{$this->recoveryTimeoutSeconds} seconds");
    }

    private function isOpen(): bool
    {
        if ($this->state === self::STATE_CLOSED) {
            return false;
        }

        if ($this->state === self::STATE_OPEN) {
            // Check if we should transition to half-open
            if ($this->nextRetryTime && new DateTimeImmutable() >= $this->nextRetryTime) {
                $this->state = self::STATE_HALF_OPEN;
                return false;
            }
            return true;
        }

        // STATE_HALF_OPEN - allow requests to test recovery
        return false;
    }

    private function onSuccess(): void
    {
        if ($this->state === self::STATE_HALF_OPEN) {
            $this->successCount++;

            if ($this->successCount >= $this->successThreshold) {
                $this->reset();
            }
        } else {
            // Reset failure count on success in normal operation
            $this->failureCount    = 0;
            $this->lastFailureTime = null;
        }
    }

    private function onFailure(): void
    {
        $this->failureCount++;
        $this->lastFailureTime = new DateTimeImmutable();

        if ($this->state === self::STATE_HALF_OPEN) {
            // Failure in half-open state -> back to open
            $this->state         = self::STATE_OPEN;
            $this->nextRetryTime = $this->lastFailureTime->modify("+{$this->recoveryTimeoutSeconds} seconds");
        } elseif ($this->failureCount >= $this->failureThreshold) {
            // Too many failures -> open the circuit
            $this->state         = self::STATE_OPEN;
            $this->nextRetryTime = $this->lastFailureTime->modify("+{$this->recoveryTimeoutSeconds} seconds");
        }
    }
}
