<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class GeocacheClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . $queryString, $headers);
    }

    public function getGeocacheImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/images' . $queryString, $headers);
    }

    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/favoritedby' . $queryString, $headers);
    }

    public function getGeocaches(array $query, array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocaches' . $queryString, $headers);
    }

    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/trackables' . $queryString, $headers);
    }

    public function getGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }

    public function searchGeocaches(array $query, array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocaches/search' . $queryString, $headers);
    }

    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/geocaches/' . $referenceCode . '/finalcoordinates', $headers, $coordinates);
    }

    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/geocaches/' . $referenceCode . '/bulktrackablelogs' . $queryString, $headers, $logs);
    }
}
