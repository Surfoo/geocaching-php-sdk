<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\UserClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class UserClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected UserClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new UserClient($this->clientBuilder);
    }

    public function testGetUser(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUser('user123');
        $this->assertSame($response, $result);
    }

    public function testGetUserPrivacySettings(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/user123/privacysettings'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserPrivacySettings('user123');
        $this->assertSame($response, $result);
    }

    public function testGetOptedOutUsers(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/optedoutusers'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getOptedOutUsers(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetUserImages(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/user123/images'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserImages('user123');
        $this->assertSame($response, $result);
    }

    public function testGetUserSouvenirs(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/user123/souvenirs'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserSouvenirs('user123');
        $this->assertSame($response, $result);
    }

    public function testGetUsers(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUsers();
        $this->assertSame($response, $result);
    }

    public function testGetUserLists(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/user123/lists'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserLists('user123');
        $this->assertSame($response, $result);
    }

    public function testGetUserGeocacheLogs(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/users/user123/geocachelogs'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getUserGeocacheLogs('user123');
        $this->assertSame($response, $result);
    }
}