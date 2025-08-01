<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\BaseUri;

class BaseUriTest extends TestCase
{
    public function testBaseUriCases(): void
    {
        $cases = BaseUri::cases();
        
        $this->assertCount(2, $cases);
        $this->assertContains(BaseUri::STAGING, $cases);
        $this->assertContains(BaseUri::PRODUCTION, $cases);
    }

    public function testBaseUriValues(): void
    {
        $this->assertSame('https://staging.api.groundspeak.com', BaseUri::STAGING->value);
        $this->assertSame('https://api.groundspeak.com', BaseUri::PRODUCTION->value);
    }

    public function testBaseUriUrlFormat(): void
    {
        $this->assertStringStartsWith('https://', BaseUri::STAGING->value);
        $this->assertStringStartsWith('https://', BaseUri::PRODUCTION->value);
        $this->assertStringContainsString('groundspeak.com', BaseUri::STAGING->value);
        $this->assertStringContainsString('groundspeak.com', BaseUri::PRODUCTION->value);
    }

    public function testBaseUriFromString(): void
    {
        $staging = BaseUri::from('https://staging.api.groundspeak.com');
        $production = BaseUri::from('https://api.groundspeak.com');
        
        $this->assertSame(BaseUri::STAGING, $staging);
        $this->assertSame(BaseUri::PRODUCTION, $production);
    }

    public function testBaseUriFromInvalidString(): void
    {
        $this->expectException(\ValueError::class);
        BaseUri::from('https://invalid.com');
    }

    public function testBaseUriTryFromValid(): void
    {
        $staging = BaseUri::tryFrom('https://staging.api.groundspeak.com');
        $production = BaseUri::tryFrom('https://api.groundspeak.com');
        
        $this->assertSame(BaseUri::STAGING, $staging);
        $this->assertSame(BaseUri::PRODUCTION, $production);
    }

    public function testBaseUriTryFromInvalid(): void
    {
        $result = BaseUri::tryFrom('https://invalid.com');
        $this->assertNull($result);
    }
}