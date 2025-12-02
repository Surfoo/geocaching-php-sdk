<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Handles retry logic with configurable strategies
 */
class RetryHandler
{
    public function __construct(
        private readonly RetryStrategy $strategy,
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
    }

    /**
     * Execute a callable with retry logic
     */
    public function execute(callable $callable): mixed
    {
        $attempt       = 1;
        $lastException = null;

        while (true) {
            try {
                $result = $callable();
                
                if ($attempt > 1) {
                    $this->logger->info("Retry succeeded", [
                        'attempt'        => $attempt,
                        'total_attempts' => $attempt,
                    ]);
                }
                
                return $result;
            } catch (\Throwable $e) {
                $lastException = $e;

                if (!$this->strategy->shouldRetry($e, $attempt)) {
                    $this->logger->error("Retry exhausted or not retryable", [
                        'exception'       => $e->getMessage(),
                        'attempt'         => $attempt,
                        'exception_class' => $e::class,
                    ]);
                    throw $e;
                }

                $delay = $this->strategy->getDelay($attempt);
                
                $this->logger->warning("Retry attempt failed, will retry", [
                    'exception'       => $e->getMessage(),
                    'attempt'         => $attempt,
                    'delay_ms'        => $delay,
                    'exception_class' => $e::class,
                ]);

                if ($delay > 0) {
                    usleep($delay * 1000); // Convert ms to microseconds
                }

                $attempt++;
            }
        }
    }

    /**
     * Get the configured retry strategy
     */
    public function getStrategy(): RetryStrategy
    {
        return $this->strategy;
    }
}
