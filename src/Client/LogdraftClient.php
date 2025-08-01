<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class LogdraftClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function deleteLogdraft(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/logdrafts/' . $referenceCode, $headers);
    }

    public function getLogdraft(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/logdrafts/' . $referenceCode . $queryString, $headers);
    }

    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->put('/logdrafts/' . $referenceCode . $queryString, $headers, $logDraft);
    }

    public function getLogdrafts(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->getHttpClient()->get('/logdrafts' . $queryString, $headers);
    }

    public function setLogdraft(array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/logdrafts' . $queryString, $headers, $logDraft);
    }

    public function promoteLogdraft(string $referenceCode, array $logDraft, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/logdrafts/' . $referenceCode . '/promote', $headers, $logDraft);
    }

    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->post('/logdrafts/' . $referenceCode . '/images' . $queryString, $headers, $postImage);
    }

    public function deleteImageFromLogdraft(string $referenceCode, string $guid, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/logdrafts/' . $referenceCode . '/' . $guid, $headers);
    }
}
