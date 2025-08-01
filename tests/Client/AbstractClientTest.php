<?php
declare(strict_types=1);

namespace Tests\Client;

use Geocaching\Client\AbstractClient;
use Geocaching\ClientBuilderInterface;
use PHPUnit\Framework\TestCase;

class TestableAbstractClient extends AbstractClient
{
    public function callGetHttpClient()
    {
        return $this->getHttpClient();
    }

    public function publicBuildQueryString(array $query): string
    {
        return $this->buildQueryString($query);
    }
}

class AbstractClientTest extends TestCase
{
    public function testGetHttpClientDelegatesToClientBuilder()
    {
        $mockHttpClient = $this->createMock(\Http\Client\Common\HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClient);

        $client = new TestableAbstractClient($this->clientBuilder);
        $this->assertSame($mockHttpClient, $client->callGetHttpClient());
    }
    private $clientBuilder;
    private $client;

    protected function setUp(): void
    {
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->client = new TestableAbstractClient($this->clientBuilder);
    }

    public function testBuildQueryStringWithParams(): void
    {
        $query = ['foo' => 'bar', 'baz' => 42];
        $result = $this->client->publicBuildQueryString($query);
        $this->assertSame('?foo=bar&baz=42', $result);
    }

    public function testBuildQueryStringEmpty(): void
    {
        $result = $this->client->publicBuildQueryString([]);
        $this->assertSame('', $result);
    }
}
