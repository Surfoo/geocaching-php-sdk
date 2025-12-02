<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class OptionsHttpLoggingTest extends TestCase
{
    public function testEnableHttpLoggingDoesNotThrow(): void
    {
        $options = new Options([
            'environment' => Environment::STAGING,
            'access_token' => 'token',
        ]);

        $this->assertNull(
            $options->enableHttpLogging('php://memory', logBodies: true, maskTokens: true, maxBodyLength: 10)
        );
    }
}
