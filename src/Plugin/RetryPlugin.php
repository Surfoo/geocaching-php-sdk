<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Geocaching\Reliability\RetryHandler;
use Geocaching\Reliability\RetryStrategy;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * HTTPlug plugin that integrates retry logic
 */
class RetryPlugin implements Plugin
{
    private readonly RetryHandler $retryHandler;

    public function __construct(
        RetryStrategy $retryStrategy,
        LoggerInterface $logger = new NullLogger()
    ) {
        $this->retryHandler = new RetryHandler($retryStrategy, $logger);
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $this->retryHandler->execute(fn() => $next($request));
    }

    /**
     * Get the retry handler instance
     */
    public function getRetryHandler(): RetryHandler
    {
        return $this->retryHandler;
    }
}
