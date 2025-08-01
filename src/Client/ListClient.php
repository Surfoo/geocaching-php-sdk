<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class ListClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function deleteList(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/lists/' . $referenceCode, $headers);
    }

    public function getList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/lists/' . $referenceCode . $queryString, $headers);
    }

    public function updateList(string $referenceCode, array $list, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->put('/lists/' . $referenceCode . $queryString, $headers, $list);
    }

    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $headers = []): ResponseInterface
    {
        $fullAbsolutePath = sprintf('%s/%s.zip', $dirname, $referenceCode);
        $headers          = array_merge($headers, ['sink' => $fullAbsolutePath]);
        return $this->getHttpClient()->get('/lists/' . $referenceCode . '/geocaches/zipped', $headers);
    }

    public function getGeocacheList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/lists/' . $referenceCode . '/geocaches' . $queryString, $headers);
    }

    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/lists/' . $referenceCode . '/geocaches' . $queryString, $headers, $geocache);
    }

    public function setList(array $list, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/lists' . $queryString, $headers, $list);
    }

    public function setBulkGeocachesList(string $referenceCode, array $body, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/lists/' . $referenceCode . '/bulkgeocaches', $body, $headers);
    }

    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/lists/' . $referenceCode . '/geocaches/' . $geocacheCode, $headers);
    }
}
