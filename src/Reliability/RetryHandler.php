<?php

declare(strict_types=1);

namespace Geocaching\Reliability;

use Geocaching\Exception\RateLimitExceededException;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\Exception\ServerErrorException;
use Http\Client\Exception as HttplugException;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Promise\HttpFulfilledPromise;
use Http\Client\Promise\HttpRejectedPromise;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
     * Execute a callable with retry logic.
     *
     * This assumes $callable either returns a successful result or throws
     * synchronously. It does not detect failures represented as a resolved
     * value (e.g. an HTTP client Promise, or a plain 4xx/5xx Response
     * returned without an exception) — use executeRequest() for those.
     */
    public function execute(callable $callable): mixed
    {
        $attempt = 1;

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
                if (!$this->strategy->shouldRetry($e, $attempt)) {
                    $this->logger->error("Retry exhausted or not retryable", [
                        'exception'       => $e->getMessage(),
                        'attempt'         => $attempt,
                        'exception_class' => $e::class,
                    ]);

                    throw $this->toFinalException($e);
                }

                $delay = $this->strategy->getDelay($attempt, $e);

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
     * Execute an HTTPlug plugin's $next($request) call with retry logic.
     *
     * A PSR-18 client is not required to throw for 4xx/5xx responses, and
     * upstream plugins that do throw (e.g. ErrorPlugin) only surface that
     * failure as a rejected Promise, not a synchronous throw. This resolves
     * each attempt's Promise synchronously via wait() so retry decisions can
     * be made against the real outcome (response status or exception)
     * instead of assuming $next($request) throws directly.
     *
     * Note: resolving via wait() means retries block the caller even for an
     * async-capable underlying client; this SDK's plugins and clients are
     * synchronous throughout, so that matches existing behavior.
     */
    public function executeRequest(RequestInterface $request, callable $next): Promise
    {
        $attempt = 1;

        while (true) {
            try {
                $response = $next($request)->wait();

                $exception = $this->exceptionForResponse($request, $response);

                if ($exception === null) {
                    if ($attempt > 1) {
                        $this->logger->info("Retry succeeded", [
                            'attempt'        => $attempt,
                            'total_attempts' => $attempt,
                        ]);
                    }

                    return new HttpFulfilledPromise($response);
                }
            } catch (\Throwable $e) {
                $exception = $e;
            }

            if (!$this->strategy->shouldRetry($exception, $attempt)) {
                $this->logger->error("Retry exhausted or not retryable", [
                    'exception'       => $exception->getMessage(),
                    'attempt'         => $attempt,
                    'exception_class' => $exception::class,
                ]);

                return new HttpRejectedPromise($this->toRejectable($this->toFinalException($exception), $request));
            }

            $delay = $this->strategy->getDelay($attempt, $exception);

            $this->logger->warning("Retry attempt failed, will retry", [
                'exception'       => $exception->getMessage(),
                'attempt'         => $attempt,
                'delay_ms'        => $delay,
                'exception_class' => $exception::class,
            ]);

            if ($delay > 0) {
                usleep($delay * 1000); // Convert ms to microseconds
            }

            $attempt++;
        }
    }

    /**
     * Build an HttpException from a fulfilled response when its status code
     * is configured as retryable, so status-code-based retry works even
     * without an ErrorPlugin converting the response into an exception.
     */
    private function exceptionForResponse(RequestInterface $request, ResponseInterface $response): ?HttpException
    {
        $statusCode = $response->getStatusCode();

        if (!$this->strategy->isRetryableStatusCode($statusCode)) {
            return null;
        }

        return $statusCode >= 500
            ? new ServerErrorException($response->getReasonPhrase(), $request, $response)
            : new ClientErrorException($response->getReasonPhrase(), $request, $response);
    }

    /**
     * HttpRejectedPromise requires the Http\Client\Exception marker
     * interface. Wrap exceptions that don't implement it (e.g. a raw
     * Guzzle-native exception from the underlying PSR-18 client) so the
     * final rejection can always be constructed safely.
     */
    private function toRejectable(\Throwable $e, RequestInterface $request): HttplugException
    {
        if ($e instanceof HttplugException) {
            return $e;
        }

        return new NetworkException($e->getMessage(), $request, $e instanceof \Exception ? $e : null);
    }

    /**
     * Get the configured retry strategy
     */
    public function getStrategy(): RetryStrategy
    {
        return $this->strategy;
    }

    /**
     * Convert a final (non-retryable or exhausted) 429 failure into a
     * RateLimitExceededException carrying the x-rate-limit-reset value.
     */
    private function toFinalException(\Throwable $e): \Throwable
    {
        if (!$e instanceof HttpException || $e->getResponse()->getStatusCode() !== 429) {
            return $e;
        }

        $retryAfterSeconds = RateLimitInfo::getResetSeconds($e->getResponse());

        return new RateLimitExceededException(
            'Geocaching API rate limit exceeded',
            $e->getRequest(),
            $e->getResponse(),
            $retryAfterSeconds,
            $e
        );
    }
}
