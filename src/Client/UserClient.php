<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getUserPrivacySettings(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/privacysettings', $headers);
    }

    public function getUser(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users/' . $referenceCode . $queryString, $headers);
    }

    public function getOptedOutUsers(array $query, array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/optedoutusers' . $queryString, $headers);
    }

    public function getUserImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/images' . $queryString, $headers);
    }

    public function getUserSouvenirs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/souvenirs' . $queryString, $headers);
    }

    public function getUsers(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users' . $queryString, $headers);
    }

    public function getUserLists(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/lists' . $queryString, $headers);
    }

    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }
}
