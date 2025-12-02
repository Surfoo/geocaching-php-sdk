<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Options;
use Geocaching\Enum\Environment;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class OptionsCreateConfiguredLoggerEdgeCasesTest extends TestCase
{
    public function testEnableHttpLoggingWithCustomLoggerAddsPlugin(): void
    {
        $options = new Options([
            'environment' => Environment::STAGING,
            'access_token' => 'token',
        ]);

        $logger = new Logger('custom');
        $logger->pushHandler(new StreamHandler('php://memory'));

        $clientBuilder = $options->getClientBuilder();
        $reflection    = new ReflectionClass($clientBuilder);
        $property      = $reflection->getProperty('plugins');
        $property->setAccessible(true);
        $initialCount = count($property->getValue($clientBuilder));

        $options->enableHttpLoggingWithLogger($logger, logBodies: true);

        $updatedPlugins = $property->getValue($clientBuilder);
        $this->assertCount($initialCount + 1, $updatedPlugins);
    }
}
