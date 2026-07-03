<?php

declare(strict_types=1);

namespace Tests\Reliability;

use Geocaching\Reliability\RateLimitInfo;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class RateLimitInfoTest extends TestCase
{
    public function testReturnsNullWhenHeaderAbsent(): void
    {
        $response = new Response(429);

        $this->assertNull(RateLimitInfo::getResetSeconds($response));
    }

    public function testReturnsSecondsWhenHeaderPresent(): void
    {
        $response = new Response(429, ['x-rate-limit-reset' => '42']);

        $this->assertSame(42, RateLimitInfo::getResetSeconds($response));
    }

    public function testReturnsNullWhenHeaderIsNotNumeric(): void
    {
        $response = new Response(429, ['x-rate-limit-reset' => 'soon']);

        $this->assertNull(RateLimitInfo::getResetSeconds($response));
    }

    public function testClampsNegativeValuesToZero(): void
    {
        $response = new Response(429, ['x-rate-limit-reset' => '-5']);

        $this->assertSame(0, RateLimitInfo::getResetSeconds($response));
    }
}
