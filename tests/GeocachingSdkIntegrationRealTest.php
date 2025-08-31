<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class GeocachingSdkIntegrationRealTest extends TestCase
{
    public function testSdkIntegrationWithRealClientBuilder()
    {
        $options = new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'test-token'
        ]);
        
        $sdk = new GeocachingSdk($options);

        // Test that we get the expected HTTP client interface
        $httpClient = $sdk->getHttpClient();
        $this->assertInstanceOf(\Http\Client\Common\HttpMethodsClientInterface::class, $httpClient);
        
        // Test that some key methods exist and are callable
        $this->assertTrue(method_exists($sdk, 'getGeocache'));
        $this->assertTrue(method_exists($sdk, 'ping'));
        $this->assertTrue(method_exists($sdk, 'getGeotours')); // New method
    }

    public function testMethodParametersAndReturnTypes()
    {
        $options = new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'test-token'
        ]);
        
        $sdk = new GeocachingSdk($options);
        $reflection = new ReflectionClass($sdk);

        // Test specific method signatures
        $getGeocacheMethod = $reflection->getMethod('getGeocache');
        $parameters = $getGeocacheMethod->getParameters();
        
        $this->assertCount(3, $parameters); // referenceCode, query, headers
        $this->assertEquals('referenceCode', $parameters[0]->getName());
        $this->assertEquals('query', $parameters[1]->getName());
        $this->assertEquals('headers', $parameters[2]->getName());
        
        // Check return type
        $returnType = $getGeocacheMethod->getReturnType();
        $this->assertEquals('Psr\Http\Message\ResponseInterface', $returnType->getName());
    }
}