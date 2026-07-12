<?php

declare(strict_types=1);

namespace Tests\Reliability;

use Geocaching\Exception\RateLimitExceededException;
use Geocaching\Reliability\ExponentialBackoffStrategy;
use Geocaching\Reliability\RetryHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Exception\HttpException;
use Http\Client\Promise\HttpFulfilledPromise;
use Http\Client\Promise\HttpRejectedPromise;
use Http\Promise\Promise;
use PHPUnit\Framework\TestCase;

class RetryHandlerTest extends TestCase
{
    public function testThrowsRateLimitExceededExceptionWhenRetriesExhaustedOn429(): void
    {
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 2);
        $handler  = new RetryHandler($strategy);

        $exception = $this->httpException(429, ['x-rate-limit-reset' => '13']);

        $this->expectException(RateLimitExceededException::class);

        try {
            $handler->execute(static function () use ($exception): void {
                throw $exception;
            });
        } catch (RateLimitExceededException $e) {
            $this->assertSame(13, $e->getRetryAfterSeconds());
            $this->assertSame($exception, $e->getPrevious());
            $this->assertSame($exception->getRequest(), $e->getRequest());
            $this->assertSame($exception->getResponse(), $e->getResponse());

            throw $e;
        }
    }

    public function testDoesNotWrapNon429FailuresOnExhaustion(): void
    {
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 2);
        $handler  = new RetryHandler($strategy);

        $exception = $this->httpException(503);

        $this->expectException(HttpException::class);

        $handler->execute(static function () use ($exception): void {
            throw $exception;
        });
    }

    public function testSucceedsAfterTransientRateLimitRetry(): void
    {
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 3);
        $handler  = new RetryHandler($strategy);

        $attempts  = 0;
        $exception = $this->httpException(429, ['x-rate-limit-reset' => '0']);

        $result = $handler->execute(static function () use (&$attempts, $exception): string {
            $attempts++;

            if ($attempts < 2) {
                throw $exception;
            }

            return 'ok';
        });

        $this->assertSame('ok', $result);
        $this->assertSame(2, $attempts);
    }

    public function testExecuteRequestRetriesOnPlainRetryableStatusResponseWithoutAnyException(): void
    {
        // A spec-compliant PSR-18 client never throws for a 4xx/5xx response;
        // $next() just returns a fulfilled Promise carrying the response.
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 3);
        $handler  = new RetryHandler($strategy);
        $request  = new Request('GET', '/geocaches');

        $responses = [
            new Response(429, ['x-rate-limit-reset' => '0']),
            new Response(200, [], 'ok'),
        ];
        $calls = 0;

        $next = function (Request $req) use (&$responses, &$calls): HttpFulfilledPromise {
            $calls++;

            return new HttpFulfilledPromise(array_shift($responses));
        };

        $promise = $handler->executeRequest($request, $next);

        $this->assertSame(200, $promise->wait()->getStatusCode());
        $this->assertSame(2, $calls);
    }

    public function testExecuteRequestThrowsRateLimitExceededExceptionOnExhaustionWithoutAnyException(): void
    {
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 2);
        $handler  = new RetryHandler($strategy);
        $request  = new Request('GET', '/geocaches');

        $next = fn (Request $req): HttpFulfilledPromise => new HttpFulfilledPromise(
            new Response(429, ['x-rate-limit-reset' => '4'])
        );

        $promise = $handler->executeRequest($request, $next);

        $this->assertSame(Promise::REJECTED, $promise->getState());

        try {
            $promise->wait();
            $this->fail('Expected RateLimitExceededException');
        } catch (RateLimitExceededException $e) {
            $this->assertSame(4, $e->getRetryAfterSeconds());
        }
    }

    public function testExecuteRequestRetriesWhenFailureArrivesAsRejectedPromise(): void
    {
        // Mirrors what ErrorPlugin actually does: the exception is caught
        // inside HttpFulfilledPromise::then() and surfaces as a rejected
        // Promise, not a synchronous throw.
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 3);
        $handler  = new RetryHandler($strategy);
        $request  = new Request('GET', '/geocaches');

        $attempts = 0;

        $next = function (Request $req) use (&$attempts): Promise {
            $attempts++;

            if ($attempts < 2) {
                $response  = new Response(429, ['x-rate-limit-reset' => '0']);
                $exception = new ClientErrorException('Too Many Requests', $req, $response);

                return new HttpRejectedPromise($exception);
            }

            return new HttpFulfilledPromise(new Response(200, [], 'ok'));
        };

        $promise = $handler->executeRequest($request, $next);

        $this->assertSame(200, $promise->wait()->getStatusCode());
        $this->assertSame(2, $attempts);
    }

    private function httpException(int $status, array $headers = []): HttpException
    {
        $request  = new Request('GET', '/geocaches');
        $response = new Response($status, $headers);

        return new HttpException('HTTP error', $request, $response);
    }
}
