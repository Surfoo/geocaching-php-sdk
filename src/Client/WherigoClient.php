<?php

declare(strict_types=1);

namespace Geocaching\Client;

use Geocaching\ClientBuilderInterface;
use Psr\Http\Message\ResponseInterface;

class WherigoClient extends AbstractClient
{
    public function __construct(protected ClientBuilderInterface $clientBuilder)
    {
        parent::__construct($clientBuilder);
    }

    public function getWherigoCartridge(string $guid, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->getHttpClient()->get('/wherigo/' . $guid . '/cartridge' . $queryString, $headers);
    }

    // Ajoutez ici les autres méthodes liées à Wherigo (getWherigoCartridge, etc.)
}
