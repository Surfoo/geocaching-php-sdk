<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Geocaching\Enum\Environment;

class EnvironmentTest extends TestCase
{
    public function testEnvironmentCases(): void
    {
        $cases = Environment::cases();
        
        $this->assertCount(2, $cases);
        $this->assertContains(Environment::STAGING, $cases);
        $this->assertContains(Environment::PRODUCTION, $cases);
    }

    public function testEnvironmentValues(): void
    {
        $this->assertSame('staging', Environment::STAGING->value);
        $this->assertSame('production', Environment::PRODUCTION->value);
    }

    public function testEnvironmentStringRepresentation(): void
    {
        $this->assertSame('staging', (string) Environment::STAGING->value);
        $this->assertSame('production', (string) Environment::PRODUCTION->value);
    }

    public function testEnvironmentFromString(): void
    {
        $staging = Environment::from('staging');
        $production = Environment::from('production');
        
        $this->assertSame(Environment::STAGING, $staging);
        $this->assertSame(Environment::PRODUCTION, $production);
    }

    public function testEnvironmentFromInvalidString(): void
    {
        $this->expectException(\ValueError::class);
        Environment::from('invalid');
    }

    public function testEnvironmentTryFromValid(): void
    {
        $staging = Environment::tryFrom('staging');
        $production = Environment::tryFrom('production');
        
        $this->assertSame(Environment::STAGING, $staging);
        $this->assertSame(Environment::PRODUCTION, $production);
    }

    public function testEnvironmentTryFromInvalid(): void
    {
        $result = Environment::tryFrom('invalid');
        $this->assertNull($result);
    }
}