<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class LogClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function deleteGeocacheLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode, $headers);
    }

    public function getGeocacheLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/geocachelogs/' . $referenceCode . $queryString, $headers);
    }

    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->put('/geocachelogs/' . $referenceCode . $queryString, $headers, $geocacheLog);
    }

    public function getGeocacheLogUpvotes(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/geocachelogs/upvotes' . $queryString, $headers);
    }

    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/geocachelogs/' . $referenceCode . '/images' . $queryString, $headers);
    }

    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/geocachelogs/' . $referenceCode . '/images' . $queryString, $headers, $imageToUpload);
    }

    public function setGeocacheLog(array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/geocachelogs' . $queryString, $headers, $geocacheLog);
    }

    public function deleteGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    public function setGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }
}
