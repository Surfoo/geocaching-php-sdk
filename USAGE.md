# Geocaching PHP SDK – Usage Guide

This document explains how to use the Geocaching PHP SDK, including both the new modular client structure and backward-compatible usage.

## Table of Contents
- [Geocaching PHP SDK – Usage Guide](#geocaching-php-sdk--usage-guide)
  - [Table of Contents](#table-of-contents)
  - [Getting Started](#getting-started)
  - [Modular Client Usage (Recommended)](#modular-client-usage-recommended)
  - [Backward Compatibility](#backward-compatibility)
  - [Available Clients and Methods](#available-clients-and-methods)
  - [Examples](#examples)
    - [Get a geocache log (recommended)](#get-a-geocache-log-recommended)
    - [Get a geocache log (legacy)](#get-a-geocache-log-legacy)
    - [Search for geocaches](#search-for-geocaches)

---

## Getting Started

Install via Composer:

```bash
composer require surfoo/geocaching-php-sdk
```

Create an SDK instance (see `README.md` for authentication details):

```php
use Geocaching\GeocachingSdk;
use Geocaching\Options;

$options = new Options(/* ... */);
$sdk = new GeocachingSdk($options);
```

---

## Modular Client Usage (Recommended)

The SDK is now organized into specialized clients. Access them via methods or properties:

```php
// Access the LogClient
$logClient = $sdk->logClient();
$response = $logClient->getGeocacheLog($referenceCode);

// Or via public property
$response = $sdk->logClient->getGeocacheLog($referenceCode);
```

This pattern applies to all clients:
- `adventureClient()`
- `friendClient()`
- `logClient()`
- `geocacheClient()`
- `trackableClient()`
- `userClient()`
- `listClient()`
- `logdraftClient()`
- `referenceDataClient()`
- `userWaypointClient()`
- `statusClient()`
- `wherigoClient()`

---

## Backward Compatibility

For legacy code, you can still call API methods directly on the SDK instance:

```php
// Old usage (still supported)
$response = $sdk->getGeocacheLog($referenceCode);
```

These calls are transparently proxied to the appropriate client.

---

## Available Clients and Methods

Each client groups related API methods. For example:

- **LogClient**: `getGeocacheLog`, `deleteGeocacheLog`, ...
- **GeocacheClient**: `getGeocache`, `searchGeocaches`, ...
- **UserClient**: `getUser`, `getUserLists`, ...

See the source code or API documentation for the full list.

---

## Examples

### Get a geocache log (recommended)
```php
$response = $sdk->logClient()->getGeocacheLog($referenceCode);
```

### Get a geocache log (legacy)
```php
$response = $sdk->getGeocacheLog($referenceCode);
```

### Search for geocaches
```php
$response = $sdk->geocacheClient()->searchGeocaches(['param' => 'value']);
```

---

For more details, see the main `README.md` and the API documentation links provided there.
