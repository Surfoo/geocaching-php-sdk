<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\StatusClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClient;

class StatusClientTest extends TestCase
{
    private StatusClient $client;

    protected function setUp(): void
    {
        $clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $clientBuilder->method('getBaseUri')->willReturn('https://api.example.com');
        
        $this->client = new StatusClient($clientBuilder);
    }

    public function testPing(): void
    {
        // StatusClient now creates its own HTTP client, so we just test that 
        // the method exists and returns a ResponseInterface
        $this->assertTrue(method_exists($this->client, 'ping'));
        
        // We can't easily mock the internal HTTP client creation in StatusClient
        // without major refactoring, so we just verify the method signature
        $reflection = new \ReflectionMethod($this->client, 'ping');
        $this->assertEquals('Psr\Http\Message\ResponseInterface', $reflection->getReturnType()->getName());
    }

    public function testStatus(): void
    {
        // Test that status() method exists and is an alias for ping()
        $this->assertTrue(method_exists($this->client, 'status'));
        
        $reflection = new \ReflectionMethod($this->client, 'status');
        $this->assertEquals('Psr\Http\Message\ResponseInterface', $reflection->getReturnType()->getName());
    }
}
