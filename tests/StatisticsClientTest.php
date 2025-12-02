<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class StatisticsClientTest extends TestCase
{
    public function testStatisticsMethodExistsAndHasReturnType(): void
    {
        $sdk = new GeocachingSdk(new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'test-token',
        ]));

        $this->assertTrue(method_exists($sdk, 'getDifficultyTerrainStatistics'));

        $reflection = new ReflectionClass($sdk);
        $method     = $reflection->getMethod('getDifficultyTerrainStatistics');
        $this->assertSame('Psr\\Http\\Message\\ResponseInterface', $method->getReturnType()?->getName());
    }
}
