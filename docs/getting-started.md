# Getting Started

Kick off quickly with installation, configuration, and a first API call.

## Prerequisites
- PHP 8.2+
- Composer
- A valid Geocaching API access token

## Install

```bash
composer require surfoo/geocaching-php-sdk
```

## Create an SDK Instance

```php
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;

$options = new Options([
    'environment'   => Environment::STAGING,   // or Environment::PRODUCTION
    'access_token'  => 'your_access_token',
]);

$sdk = new GeocachingSdk($options);
```

The SDK automatically picks the correct base URL for the selected environment and prefixes requests with the API version (`v1`). Status endpoints use the environment root URL without the version prefix.

## First Request

```php
$response = $sdk->getGeocache('GC123ABC', [
    'fields' => 'referenceCode,name,difficulty,terrain',
]);

if ($response->getStatusCode() !== 200) {
    throw new RuntimeException('Unexpected status: ' . $response->getStatusCode());
}

$data = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
echo $data['name']; // Geocache title
```

Every SDK method returns a PSR-7 `ResponseInterface`. Use `getStatusCode()`, headers, and `getBody()` to handle responses however you prefer.
