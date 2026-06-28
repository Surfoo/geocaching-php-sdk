# Upgrading from 3.x to 4.0.0

## Requirements

- PHP **8.2** or higher (raised from 8.1)
- `surfoo/oauth2-geocaching` **^3.0** (new required package — see Authentication section)

Update your dependencies:

```bash
composer require surfoo/geocaching-php-sdk:^4.0 surfoo/oauth2-geocaching:^3.0
```

---

## Breaking Changes

### PHP 8.1 dropped

PHP 8.1 is no longer supported. Update your runtime to PHP 8.2+.

### `GeocachingSdkInterface` removed

The `GeocachingSdkInterface` interface has been removed. `GeocachingSdk` is no longer `final` either. If you were type-hinting against the interface, switch to the concrete class or your own interface.

**Before:**
```php
use Geocaching\GeocachingSdkInterface;

function doSomething(GeocachingSdkInterface $sdk): void { ... }
```

**After:**
```php
use Geocaching\GeocachingSdk;

function doSomething(GeocachingSdk $sdk): void { ... }
```

### `ClientBuilder::getHttpClient()` return type changed

The return type of `ClientBuilder::getHttpClient()` changed from `ClientInterface` (PSR-18) to `HttpMethodsClientInterface` (HTTPlug), which is a superset. This is only a breaking change if you stored the result in a typed variable or type-hinted against `ClientInterface`.

**Before:**
```php
use Psr\Http\Client\ClientInterface;

$client = $options->getClientBuilder()->getHttpClient(); // ClientInterface
```

**After:**
```php
use Http\Client\Common\HttpMethodsClientInterface;

$client = $options->getClientBuilder()->getHttpClient(); // HttpMethodsClientInterface
```

### `Options` and `ClientBuilder` are no longer `final`

Both classes were `final` in 3.x. In 4.0 this restriction is removed, so extension is now possible.

### `setGeocacheUserWaypoint()` signature changed

The `$referenceCode` first parameter has been removed.

**Before:**
```php
$sdk->setGeocacheUserWaypoint($referenceCode, $body, $headers);
```

**After:**
```php
$sdk->setGeocacheUserWaypoint($body, $headers);
```

### `updateUserWaypoint()` parameter renamed

The third parameter was `array $query` (misleading); it is now `array $waypoint` to reflect its actual purpose. The call signature is unchanged but semantics are clearer.

### `updateGeocacheNote()` parameter renamed

The parameter `array $note` is now `array $notes` (plural). No functional change.

### `getHQPromotions()` now accepts a `$query` parameter

**Before:**
```php
$sdk->getHQPromotions($headers);
```

**After:**
```php
$sdk->getHQPromotions($query, $headers);
// or keep passing only headers (first arg defaults to [])
$sdk->getHQPromotions([], $headers);
```

### `getGeocachesGeotour()` renamed to `getGeotourGeocaches()`

**Before:**
```php
$sdk->getGeocachesGeotour($referenceCode, $query, $headers);
```

**After:**
```php
$sdk->getGeotourGeocaches($referenceCode, $query, $headers);
```

### `getStartLocationAdventure()` removed

This endpoint was removed from the Geocaching API and is no longer available.

---

## New Features

The sections below describe what 4.0 adds. Nothing else you already use has been removed.

### Automatic token refresh

Pass a `TokenStorageInterface` and a `reference_code` (the user's Geocaching reference code, e.g. `'PR12345'`) to `Options` to enable automatic access-token refresh on `401` responses. The SDK will refresh, store the new token, and retry the request transparently.

```php
use Geocaching\Options;
use Geocaching\Enum\Environment;
use League\OAuth2\Client\Provider\Geocaching as OAuthProvider;

$provider = new OAuthProvider([
    'clientId'     => 'your-client-id',
    'clientSecret' => 'your-client-secret',
    'redirectUri'  => 'https://example.com/callback',
    'environment'  => 'production',
]);

$options = new Options([
    'environment'    => Environment::PRODUCTION,
    'access_token'   => $storedAccessToken,
    'token_storage'  => new MyTokenStorage(), // implements TokenStorageInterface
    'reference_code' => 'PR12345',
]);
```

`TokenStorageInterface` and `TokenSet` come from `surfoo/oauth2-geocaching ^3.0`. See that package's `UPGRADE-3.0.md` for implementation details.

When `token_storage` and `reference_code` are omitted, the SDK behaves exactly as in 3.x with a static bearer token.

### HTTP request/response logging

```php
use Psr\Log\LogLevel;

$options->enableHttpLogging(
    'php://stdout',  // destination: file path, php://stdout, php://stderr
    LogLevel::INFO,  // minimum log level
    false,           // log request/response bodies
    true,            // mask bearer tokens in logs
    1000             // max body length before truncation
);
```

Each request gets a unique correlation ID so requests and responses can be matched. Sensitive tokens are masked automatically. HTTP 4xx/5xx responses are logged at `WARNING`/`ERROR` level regardless of the configured level.

### Reliability plugins

#### Retry

```php
use Geocaching\Reliability\ExponentialBackoffStrategy;
use Geocaching\Reliability\FixedDelayStrategy;

// Exponential back-off: 100ms, 200ms, 400ms, …
$options->enableRetry(
    maxRetries: 3,
    strategy: new ExponentialBackoffStrategy(initialDelayMs: 100)
);

// Fixed delay
$options->enableRetry(
    maxRetries: 3,
    strategy: new FixedDelayStrategy(delayMs: 500)
);
```

#### Circuit breaker

```php
$options->enableCircuitBreaker(
    failureThreshold: 5,   // open after this many consecutive failures
    resetTimeout: 60       // seconds before attempting to close again
);
```

#### Combined reliability plugin

`ReliabilityPlugin` bundles retry and circuit breaker together:

```php
$options->enableReliability(
    maxRetries: 3,
    strategy: new ExponentialBackoffStrategy(100),
    failureThreshold: 5,
    resetTimeout: 60
);
```

### New enum: `Attribute`

`Geocaching\Enum\Attribute` covers all 65 geocache attributes (dogs, wheelchair accessible, night cache, etc.) with `id()` returning the Groundspeak attribute ID.

```php
use Geocaching\Enum\Attribute;

$attr = Attribute::WHEELCHAIR_ACCESSIBLE;
$attr->value; // 'Wheelchair accessible'
$attr->id();  // 24
```

### `EnumTrait` on all enums

All enums now use `EnumTrait`, which adds three helpers:

```php
// Look up an enum by its integer ID
$type = GeocacheType::fromId(2); // GeocacheType::TRADITIONAL

// Get all human-readable values
GeocacheType::getList(); // ['Traditional Cache', 'Multi-cache', ...]

// Get all IDs
GeocacheType::getListId(); // [2, 3, ...]
```

### New method: `getDifficultyTerrainStatistics()`

Returns aggregated D/T statistics from the Geocaching API:

```php
$response = $sdk->getDifficultyTerrainStatistics();
```

### New method: `deleteImageFromLogdraft()`

```php
$sdk->deleteImageFromLogdraft($referenceCode, $guid, $headers);
```

### `ClientBuilderInterface`

A new `ClientBuilderInterface` is available if you need to swap or mock the client builder in your own code:

```php
use Geocaching\ClientBuilderInterface;
```

---

## New exception: `CircuitBreakerOpenException`

Thrown by `CircuitBreakerPlugin` when the circuit is open and the request is rejected immediately. Catch it to short-circuit your own retry logic:

```php
use Geocaching\Exception\CircuitBreakerOpenException;

try {
    $response = $sdk->getGeocache('GC12345');
} catch (CircuitBreakerOpenException $e) {
    // API is unavailable; serve from cache or return a degraded response
}
```
