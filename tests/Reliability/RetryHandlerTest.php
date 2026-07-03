<?php

declare(strict_types=1);

namespace Tests\Reliability;

use Geocaching\Exception\RateLimitExceededException;
use Geocaching\Reliability\ExponentialBackoffStrategy;
use Geocaching\Reliability\RetryHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Exception\HttpException;
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

    private function httpException(int $status, array $headers = []): HttpException
    {
        $request  = new Request('GET', '/geocaches');
        $response = new Response($status, $headers);

        return new HttpException('HTTP error', $request, $response);
    }
}
