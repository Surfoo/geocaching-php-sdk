<?php

declare(strict_types=1);

namespace Tests\Reliability;

use Geocaching\Reliability\FixedDelayStrategy;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Exception\HttpException;
use PHPUnit\Framework\TestCase;

class FixedDelayStrategyTest extends TestCase
{
    public function testDelayHonorsRateLimitResetHeaderOver429(): void
    {
        $strategy  = new FixedDelayStrategy(delayMs: 1000, maxDelayMs: 30000);
        $exception = $this->httpException(429, ['x-rate-limit-reset' => '7']);

        $this->assertSame(7000, $strategy->getDelay(2, $exception));
    }

    public function testDelayFallsBackToFixedDelayWhenHeaderMissing(): void
    {
        $strategy  = new FixedDelayStrategy(delayMs: 1500);
        $exception = $this->httpException(429);

        $this->assertSame(1500, $strategy->getDelay(2, $exception));
    }

    public function testDelayClampsRateLimitResetToMaxDelay(): void
    {
        $strategy  = new FixedDelayStrategy(delayMs: 1000, maxDelayMs: 2000);
        $exception = $this->httpException(429, ['x-rate-limit-reset' => '60']);

        $this->assertSame(2000, $strategy->getDelay(2, $exception));
    }

    private function httpException(int $status, array $headers = []): HttpException
    {
        $request  = new Request('GET', '/geocaches');
        $response = new Response($status, $headers);

        return new HttpException('HTTP error', $request, $response);
    }
}
