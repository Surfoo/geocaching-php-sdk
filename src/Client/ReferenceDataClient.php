<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class ReferenceDataClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getReferenceCodeFromId(array $query, array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/utilities/referencecode' . $queryString, $headers);
    }

    public function getCountries(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/countries', $headers);
    }

    public function getStates(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/states', $headers);
    }

    public function getStatesByCountry(int $countryId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/countries/' . $countryId . '/states', $headers);
    }

    public function getMembershipLevels(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/membershiplevels', $headers);
    }

    public function getGeocacheTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachetypes', $headers);
    }

    public function getAttributes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/attributes', $headers);
    }

    public function getGeocacheSizes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachesizes', $headers);
    }

    public function getGeocacheStatuses(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachestatuses', $headers);
    }

    public function getGeocacheLogTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachelogtypes', $headers);
    }

    public function getTrackableLogTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogtypes', $headers);
    }

    // Ajoutez ici d'autres méthodes liées aux données de référence si nécessaire
}
