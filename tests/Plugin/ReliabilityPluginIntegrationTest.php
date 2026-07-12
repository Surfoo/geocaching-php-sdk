<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Geocaching\Exception\CircuitBreakerOpenException;
use Geocaching\Plugin\ReliabilityPlugin;
use Geocaching\Reliability\CircuitBreaker;
use Geocaching\Reliability\ExponentialBackoffStrategy;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Common\Exception\ServerErrorException;
use Http\Client\Common\PluginClientFactory;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;

class ReliabilityPluginIntegrationTest extends TestCase
{
    public function testCircuitBreakerOpensAfterHttpErrorStatusResponses(): void
    {
        // No exception is thrown for these 500s (spec-compliant PSR-18 client);
        // the circuit breaker must still detect the failures from the response.
        $mock = new MockClient();
        $mock->addResponse(new Response(500));
        $mock->addResponse(new Response(500));

        $circuitBreaker = new CircuitBreaker(failureThreshold: 2, recoveryTimeoutSeconds: 60);
        $strategy       = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 1);
        $plugin         = new ReliabilityPlugin($circuitBreaker, $strategy);
        $client         = (new PluginClientFactory())->createClient($mock, [$plugin]);
        $request        = new Request('GET', '/geocaches');

        $this->assertSame('closed', $circuitBreaker->getState());

        try {
            $client->sendRequest($request);
        } catch (ServerErrorException) {
        }
        $this->assertSame(1, $circuitBreaker->getFailureCount());

        try {
            $client->sendRequest($request);
        } catch (ServerErrorException) {
        }
        $this->assertSame('open', $circuitBreaker->getState());

        $this->expectException(CircuitBreakerOpenException::class);
        $client->sendRequest($request);
    }
}
