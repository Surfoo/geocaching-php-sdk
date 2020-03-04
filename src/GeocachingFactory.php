<?php

namespace Geocaching;

use Geocaching\Lib\Adapters\GuzzleHttpClient;
use Geocaching\Sdk\GeocachingSdk;
use Geocaching\Sdk\GeocachingSdkExtended;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

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
     * @const string
     */
    const ENVIRONMENT_STAGING = 'staging';

    /**
     * @const string
     */
    const ENVIRONMENT_PRODUCTION = 'production';

    /**
     * Version of the API.
     *
     * @const string
     */
    const API_VERSION = 'v1';

    /**
     * @var \GuzzleHttp\HandlerStack|null
     */
    private static $stack;

    const LOG_FORMAT = ['{method} {uri} HTTP/{version} {req_body}',
                        'RESPONSE: {code} - {res_body}',
                    ];
    /**
     * Return Geocaching SDK to use API's methods
     *
     *
     * @return GeocachingSdk
     */
    public static function createSdk(
        string $accessToken,
        string $environment = self::ENVIRONMENT_PRODUCTION,
        array $options = []
    ) {
        $adapter = self::createHandler($accessToken, $environment, $options);

        return new GeocachingSdk($adapter);
    }

    /**
     * Return Geocaching custom methods
     *
     * @return GeocachingSdkExtended
     */
    public static function createSdkExtended(
        string $accessToken,
        string $environment = self::ENVIRONMENT_PRODUCTION,
        array $options = []
    ) {
        $adapter = self::createHandler($accessToken, $environment, $options);

        return new GeocachingSdkExtended($adapter);
    }

    /**
     * @return void
     */
    public static function setLogger(LoggerInterface $logger, array $messageFormats = [])
    {
        if (empty($messageFormats)) {
            $messageFormats = self::LOG_FORMAT;
        }

        self::$stack = \GuzzleHttp\HandlerStack::create();

        foreach ($messageFormats as $messageFormat) {
            self::$stack->unshift(
                \GuzzleHttp\Middleware::log(
                    $logger,
                    new \GuzzleHttp\MessageFormatter($messageFormat)
                )
            );
        }
    }

    /**
     * @return GuzzleHttpClient
     */
    private static function createHandler(string $accessToken, string $environment, array $options = [])
    {
        $baseUri = self::ENVIRONMENT_STAGING == $environment ? self::STAGING_API_URL : self::PRODUCTION_API_URL;

        $config = ['base_uri' => sprintf('%s/%s/', $baseUri, self::API_VERSION)];
        if (!is_null(self::$stack)) {
            $config['handler'] = self::$stack;
        }
        $client = new Client($config);

        return new GuzzleHttpClient($client, $accessToken, $options);
    }
}
