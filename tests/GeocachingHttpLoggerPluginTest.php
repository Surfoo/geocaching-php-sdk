<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
use Http\Promise\FulfilledPromise;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Psr\Log\NullLogger;
use Psr\Log\LogLevel;

class GeocachingHttpLoggerPluginTest extends TestCase
{
    public function testHandleRequestReturnsSameResponse(): void
    {
        $plugin = new GeocachingHttpLoggerPlugin(
            new NullLogger(),
            LogLevel::INFO,
            false,
            true,
            1000
        );

        $request  = new Request('GET', 'https://example.test');
        $response = new Response(200);

        $promise = $plugin->handleRequest(
            $request,
            fn ($req) => new FulfilledPromise($response),
            fn ($req) => new FulfilledPromise($response)
        );

        $this->assertSame($response, $promise->wait());
    }
}
