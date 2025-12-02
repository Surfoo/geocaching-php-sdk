<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class OptionsCreateConfiguredLoggerTest extends TestCase
{
    public function testEnableHttpLoggingAddsPlugin(): void
    {
        $options = new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'token',
        ]);

        $clientBuilder = $options->getClientBuilder();
        $reflection    = new ReflectionClass($clientBuilder);
        $property      = $reflection->getProperty('plugins');
        $property->setAccessible(true);

        $initialPlugins = $property->getValue($clientBuilder);
        $options->enableHttpLogging(output: 'php://memory', logBodies: false);
        $newPlugins = $property->getValue($clientBuilder);

        $this->assertCount(count($initialPlugins) + 1, $newPlugins);
    }
}
