<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class UserWaypointClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getUserWaypoints(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/userwaypoints' . $queryString, $headers);
    }

    public function setGeocacheUserWaypoint(string $referenceCode, array $body, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/userwaypoints', $headers, $body);
    }

    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/userwaypoints' . $queryString, $headers);
    }

    public function deleteUserWaypoint(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/userwaypoints/' . $referenceCode, $headers);
    }

    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->put('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers, $coordinates);
    }

    public function deleteCorrectedCoordinates(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers);
    }

    public function updateUserWaypoint(string $referenceCode, array $query, array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->put('/userwaypoints/' . $referenceCode . $queryString, $headers);
    }

    // Ajoutez ici d'autres méthodes si nécessaire
}
