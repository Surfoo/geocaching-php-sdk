<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Geocaching\Exception\RateLimitExceededException;
use Geocaching\Plugin\RetryPlugin;
use Geocaching\Reliability\ExponentialBackoffStrategy;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;

/**
 * Exercises RetryPlugin through the real HTTPlug plugin chain (PluginClientFactory),
 * rather than calling RetryHandler directly, since the retry-on-429 bug only
 * surfaced through the Promise-based plugin contract.
 */
class RetryPluginIntegrationTest extends TestCase
{
    public function testRetriesOn429WithoutErrorPlugin(): void
    {
        $mock = new MockClient();
        $mock->addResponse(new Response(429, ['x-rate-limit-reset' => '0']));
        $mock->addResponse(new Response(429, ['x-rate-limit-reset' => '0']));
        $mock->addResponse(new Response(200, [], 'ok'));

        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 3);
        $client   = (new PluginClientFactory())->createClient($mock, [new RetryPlugin($strategy)]);

        $response = $client->sendRequest(new Request('GET', '/geocaches'));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertCount(3, $mock->getRequests());
    }

    public function testRetriesOn429WithErrorPluginConvertingResponseToException(): void
    {
        $mock = new MockClient();
        $mock->addResponse(new Response(429, ['x-rate-limit-reset' => '0']));
        $mock->addResponse(new Response(200, [], 'ok'));

        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 3);
        $client   = (new PluginClientFactory())->createClient(
            $mock,
            [new RetryPlugin($strategy), new ErrorPlugin()]
        );

        $response = $client->sendRequest(new Request('GET', '/geocaches'));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertCount(2, $mock->getRequests());
    }

    public function testThrowsRateLimitExceededExceptionWhenRetriesExhausted(): void
    {
        $mock = new MockClient();
        $mock->addResponse(new Response(429, ['x-rate-limit-reset' => '7']));
        $mock->addResponse(new Response(429, ['x-rate-limit-reset' => '7']));

        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1, maxDelayMs: 1, maxAttempts: 2);
        $client   = (new PluginClientFactory())->createClient($mock, [new RetryPlugin($strategy)]);

        try {
            $client->sendRequest(new Request('GET', '/geocaches'));
            $this->fail('Expected RateLimitExceededException');
        } catch (RateLimitExceededException $e) {
            $this->assertSame(7, $e->getRetryAfterSeconds());
        }

        $this->assertCount(2, $mock->getRequests());
    }
}
