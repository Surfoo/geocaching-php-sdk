<?php

use Geocaching\ClientBuilder;
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Message\Authentication\Bearer;

require __DIR__ . '/vendor/autoload.php';

$bearer = new Bearer('xxx');

$clientBuilder = new ClientBuilder();

$clientBuilder->addPlugin(new AuthenticationPlugin($bearer));
$clientBuilder->addPlugin(new HeaderDefaultsPlugin([
    'Accept' => 'application/json',
]));

$options = new Options([
            'environment'    => Environment::STAGING,
            'client_builder' => $clientBuilder,
        ]);

$api = new GeocachingSdk($options);

$response = $api->getUser('me', ['fields' => 'referenceCode,geocacheLimits']);

var_dump($response->getReasonPhrase());
var_dump((string) $response->getBody());