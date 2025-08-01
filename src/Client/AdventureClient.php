<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class AdventureClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    /**
     * swagger: GET /v{api-version}/adventures/{adventureId}
     *
     * @see https://api.groundspeak.com/documentation#get-adventure
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Get
     */
    public function getAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/adventures/' . $adventureId, $headers);
    }

    /**
     * swagger: GET /v{api-version}/adventures/anon/{adventureId}
     *
     * @see https://api.groundspeak.com/documentation#get-adventure-start
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_GetStartLocation
     */
    public function getStartLocationAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/adventures/anon/' . $adventureId, $headers);
    }

    /**
     * swagger: GET /v{api-version}/adventures/search
     *
     * @see https://api.groundspeak.com/documentation#adventures-search
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Search
     */
    public function searchAdventures(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/adventures/search' . $queryString, $headers);
    }

    /**
     * swagger: POST /v{api-version}/adventures/stages/search
     *
     * @see https://api.groundspeak.com/documentation#stages-search
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_SearchStages
     */
    public function searchAdventuresStages(array $stageSearchModel, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/adventures/stages/search', $headers, $stageSearchModel);
    }
}
