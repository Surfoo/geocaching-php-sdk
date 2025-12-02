# Configuration & HTTP Clients

Learn how the SDK builds requests, chooses endpoints, and lets you customize the underlying HTTP stack.

## Core Options

`Options` requires:
- `environment` (`Environment::STAGING` or `Environment::PRODUCTION`)
- `access_token` (string)

The SDK sets the API base URL from the environment and appends `/v1/` automatically. Status endpoints are called against the environment root without the version prefix.

Optional keys accepted by `Options`:
- `client_builder` (`Geocaching\ClientBuilder`) — inject your own builder instance.
- `uri_factory` (`Psr\Http\Message\UriFactoryInterface`) — override URI creation.

## Default Client Behavior

- Uses HTTPlug/PSR-18 discovery to find an HTTP client, request factory, and stream factory.
- Adds default headers (`Content-Type: application/json` and `Accept: application/json`).
- Attaches a bearer `Authorization` header for you.
- Exposes the configured PSR-18 client via `GeocachingSdk::getHttpClient()` if you need lower-level control.

## Plugging In Custom Clients

Pass your own PSR-18 client, request factory, or stream factory to `ClientBuilder`, then inject it into `Options`:

```php
use Geocaching\ClientBuilder;
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use GuzzleHttp\Client as GuzzleClient;
use Nyholm\Psr7\Factory\Psr17Factory;

$clientBuilder = new ClientBuilder(
    httpClient: new GuzzleClient(['timeout' => 5]),
    requestFactory: new Psr17Factory(),
    streamFactory: new Psr17Factory(),
);

$options = new Options([
    'environment'    => Environment::PRODUCTION,
    'access_token'   => 'your_token',
    'client_builder' => $clientBuilder,
]);

$sdk = new GeocachingSdk($options);
```

You can still call `$sdk->getHttpClient()` to work directly with the configured PSR client when you need to send custom requests.
