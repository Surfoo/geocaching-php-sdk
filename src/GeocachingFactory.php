<?php

namespace Geocaching;

use GuzzleHttp\Client;
use Geocaching\Api\GeocachingApi;
use Geocaching\Lib\Adapters\GuzzleHttpClient;

class GeocachingFactory
{

    /**
     * Staging URL of Groundspeak API.
     *
     * @const string
     */
    const STAGING_API_URL = 'https://staging.api.groundspeak.com';

    /**
     * Production URL of Groundspeak API.
     *
     * @const string
     */
    const PRODUCTION_API_URL = 'https://api.groundspeak.com';

    /**
     * Version of the API
     *
     * @const string
     */
    const API_VERSION = '/v1/';

    /**
     * @param string $accessToken
     * @param string $environment
     * @param bool $responseToArray
     * @param array $options
     *
     * @return GeocachingApi
     */
    public static function create(
        string $accessToken,
        string $environment = 'production',
        array $options = []
    ) {
        $baseUri = $environment == 'staging' ? self::STAGING_API_URL : self::PRODUCTION_API_URL;

        $client = new Client([
            'base_uri' => $baseUri . self::API_VERSION
        ]);

        $adapter = new GuzzleHttpClient($client, $accessToken, $options);

        return new GeocachingApi($adapter);
    }
}
