<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\Client\FriendClient;
use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClientInterface;

class FriendClientTest extends TestCase
{
    protected $clientBuilder;
    protected $httpClient;
    protected FriendClient $client;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpMethodsClientInterface::class);
        $this->clientBuilder = $this->createMock(ClientBuilderInterface::class);
        $this->clientBuilder->method('getHttpClient')->willReturn($this->httpClient);
        $this->client = new FriendClient($this->clientBuilder);
    }

    public function testGetFriendRequests(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/friendrequests'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getFriendRequests();
        $this->assertSame($response, $result);
    }

    public function testSendFriendRequest(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/friendrequests'), $this->anything(), $this->anything())
            ->willReturn($response);
        $result = $this->client->sendFriendRequest(['foo' => 'bar']);
        $this->assertSame($response, $result);
    }

    public function testGetFriends(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/friends'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getFriends();
        $this->assertSame($response, $result);
    }

    public function testGetFriendsGeocacheLogsByGeocache(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('/friends/geocaches/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->getFriendsGeocacheLogsByGeocache('GC123');
        $this->assertSame($response, $result);
    }

    public function testAcceptFriendRequest(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('post')
            ->with($this->stringContains('/friendrequests/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->acceptFriendRequest('req123');
        $this->assertSame($response, $result);
    }

    public function testDeleteFriend(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/friends/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteFriend('GC123');
        $this->assertSame($response, $result);
    }

    public function testDeleteFriendRequest(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $this->httpClient->expects($this->once())
            ->method('delete')
            ->with($this->stringContains('/friendrequests/'), $this->anything())
            ->willReturn($response);
        $result = $this->client->deleteFriendRequest('req123');
        $this->assertSame($response, $result);
    }
}
