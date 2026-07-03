<?php

declare(strict_types=1);

namespace Tests\Reliability;

use Geocaching\Reliability\ExponentialBackoffStrategy;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Exception\HttpException;
use PHPUnit\Framework\TestCase;

class ExponentialBackoffStrategyTest extends TestCase
{
    public function testRetriesOn429ByDefault(): void
    {
        $strategy  = new ExponentialBackoffStrategy(maxAttempts: 3);
        $exception = $this->httpException(429);

        $this->assertTrue($strategy->shouldRetry($exception, 1));
    }

    public function testDelayHonorsRateLimitResetHeaderOver429(): void
    {
        $strategy  = new ExponentialBackoffStrategy(baseDelayMs: 1000, maxDelayMs: 30000);
        $exception = $this->httpException(429, ['x-rate-limit-reset' => '5']);

        $this->assertSame(5000, $strategy->getDelay(2, $exception));
    }

    public function testDelayClampsRateLimitResetToMaxDelay(): void
    {
        $strategy  = new ExponentialBackoffStrategy(maxDelayMs: 3000);
        $exception = $this->httpException(429, ['x-rate-limit-reset' => '60']);

        $this->assertSame(3000, $strategy->getDelay(2, $exception));
    }

    public function testDelayFallsBackToBackoffWhenHeaderMissing(): void
    {
        $strategy  = new ExponentialBackoffStrategy(baseDelayMs: 1000, multiplier: 2.0, maxDelayMs: 30000);
        $exception = $this->httpException(429);

        $delay = $strategy->getDelay(2, $exception);

        // base_delay_ms * multiplier^0 = 1000, +/-20% jitter
        $this->assertGreaterThanOrEqual(800, $delay);
        $this->assertLessThanOrEqual(1200, $delay);
    }

    public function testDelayIgnoresRateLimitHeaderForNon429Responses(): void
    {
        $strategy  = new ExponentialBackoffStrategy(baseDelayMs: 1000, maxDelayMs: 30000);
        $exception = $this->httpException(503, ['x-rate-limit-reset' => '5']);

        $delay = $strategy->getDelay(2, $exception);

        $this->assertNotSame(5000, $delay);
    }

    private function httpException(int $status, array $headers = []): HttpException
    {
        $request  = new Request('GET', '/geocaches');
        $response = new Response($status, $headers);

        return new HttpException('HTTP error', $request, $response);
    }
}
