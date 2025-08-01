<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class FriendClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getFriendRequests(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/friendrequests' . $queryString, $headers);
    }

    public function sendFriendRequest(array $friendRequest, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/friendrequests' . $queryString, $headers, $friendRequest);
    }

    public function getFriends(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/friends' . $queryString, $headers);
    }

    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/friends/geocaches/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }

    public function acceptFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/friendrequests/' . $requestId . '/accept', $headers);
    }

    public function deleteFriend(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/friends/' . $referenceCode, $headers);
    }

    public function deleteFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/friendrequests/' . $requestId, $headers);
    }
}
