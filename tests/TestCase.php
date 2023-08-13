<?php

declare(strict_types=1);

namespace Geocaching\Client\Tests;

use Geocaching\ClientBuilder;
use Geocaching\Enum\Environment;
use Geocaching\Options;
use Geocaching\GeocachingSdk;
use Http\Mock\Client;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Client $mockClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = new Client();
    }

    protected function givenSdk(): GeocachingSdk
    {
        return new GeocachingSdk(new Options([
            'access_token'   => 'fakeToken',
            'client_builder' => new ClientBuilder($this->mockClient),
            'environment'    => Environment::STAGING,
        ]));
    }
}