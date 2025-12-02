<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class GeocachingAdventureSdkTest extends TestCase
{
    public function testAdventureMethodsExist(): void
    {
        $sdk = new GeocachingSdk(new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'test-token',
        ]));

        $this->assertTrue(method_exists($sdk, 'getAdventure'));
        $this->assertTrue(method_exists($sdk, 'getStartLocationAdventure'));
        $this->assertTrue(method_exists($sdk, 'searchAdventures'));
        $this->assertTrue(method_exists($sdk, 'searchAdventuresStages'));
    }
}
