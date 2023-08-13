<?php

use Geocaching\ClientBuilder;
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use GuzzleHttp\Psr7\Response;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require __DIR__ . '/vendor/autoload.php';

define('TOKEN', 'xxx');

$clientBuilder = new ClientBuilder();

// $loggerPlugin = new LoggerPlugin(new Logger('http'));
// $clientBuilder->addPlugin($loggerPlugin);

// $retryConfig = ['retries' => 5, 
//                 'error_response_decider' => function (RequestInterface $request, ResponseInterface $response) {
//                     return $response->getStatusCode() == 429;
//             }];
// $retryPlugin = new RetryPlugin($retryConfig);
// $clientBuilder->addPlugin($retryPlugin);


$options = new Options([
    'access_token'   => TOKEN,
    'client_builder' => $clientBuilder,
    'environment'    => Environment::STAGING,
]);

$api = new GeocachingSdk($options);

$response = $api->getUser('me', ['fields' => 'referenceCode,username,geocacheLimits']);

var_dump($response->getReasonPhrase());
var_dump((string) $response->getBody());