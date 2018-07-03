<?php

namespace Geocaching;

use Geocaching\Lib\Adapters\GuzzleHttpClient;
use Geocaching\Sdk\GeocachingSdk;
use Geocaching\Sdk\GeocachingSdkExtended;
use GuzzleHttp\Client;

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
     * Version of the API.
     *
     * @const string
     */
    const API_VERSION = '/v1/';

    /**
     * Return Geocaching SDK to use API's methods
     *
     * @param string $accessToken
     * @param string $environment
     * @param array  $options
     *
     * @return GeocachingSdk
     */
    public static function createSdk(
        string $accessToken,
        string $environment = 'production',
        array $options = []
    ) {
        $adapter = self::createHandler($accessToken, $environment, $options);

        return new GeocachingSdk($adapter);
    }

    /**
     * Return Geocaching custom methods
     * 
     * @param string $accessToken
     * @param string $environment
     * @param array  $options
     *
     * @return GeocachingSdkExtended
     */
    public static function createSdkExtended(
        string $accessToken,
        string $environment = 'production',
        array $options = []
    ) {
        $adapter = self::createHandler($accessToken, $environment, $options);

        return new GeocachingSdkExtended($adapter);
    }

    /**
     * @param string $accessToken
     * @param string $environment
     * @param bool   $responseToArray
     * @param array  $options
     *
     * @return GuzzleHttpClient
     */
    private static function createHandler(string $accessToken, string $environment, array $options = [])
    {
        $baseUri = 'staging' == $environment ? self::STAGING_API_URL : self::PRODUCTION_API_URL;
        $client  = new Client([
            'base_uri' => $baseUri . self::API_VERSION,
        ]);

        return new GuzzleHttpClient($client, $accessToken, $options);
    }
}
