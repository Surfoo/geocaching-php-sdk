<?php

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class StatisticsClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    /**
     * Returns the D/T grid statistics for the calling user.
     * GET /v1/statistics/difficultyterrain
     *
     * @param array $headers Optional HTTP headers
     */
    public function getDifficultyTerrainStatistics(array $headers = []): ResponseInterface
    {
        $httpClient = $this->getHttpClient();
        $uri        = '/v1/statistics/difficultyterrain';
        return $httpClient->get($uri, $headers);
    }
}
