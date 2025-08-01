<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class TrackableClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function deleteTrackableLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/trackablelogs/' . $referenceCode, $headers);
    }

    public function getTrackableLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogs/' . $referenceCode, $query, $headers);
    }

    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->put('/trackablelogs/' . $referenceCode, $trackableLog, $query, $headers);
    }

    public function getUserTrackableLog(array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogs/', $query, $headers);
    }

    public function getTrackableLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackablelogs/' . $referenceCode . '/images' . $queryString, $headers);
    }

    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/trackablelogs/' . $referenceCode . '/images' . $queryString, $headers, $imageToUpload);
    }

    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/trackablelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }

    public function setTrackableLog(array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/trackablelogs' . $queryString, $headers, $trackableLog);
    }

    public function getTrackable(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . $queryString, $headers);
    }

    public function getUserTrackables(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables' . $queryString, $headers);
    }

    public function getTrackableJourneys(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/journeys' . $queryString, $headers);
    }

    public function getGeocoinTypes(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables/geocointypes' . $queryString, $headers);
    }

    public function getTrackableImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/images' . $queryString, $headers);
    }

    public function getTrackableLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/trackablelogs' . $queryString, $headers);
    }
}
