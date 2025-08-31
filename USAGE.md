# Geocaching PHP SDK – Usage Guide

This document explains how to use the Geocaching PHP SDK with its centralized architecture.

## Table of Contents
- [Getting Started](#getting-started)
- [Basic Usage](#basic-usage)
- [Complete API Reference](#complete-api-reference)
- [Examples](#examples)

---

## Getting Started

Install via Composer:

```bash
composer require surfoo/geocaching-php-sdk
```

Create an SDK instance:

```php
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\Enum\Environment;

$options = new Options([
    'environment' => Environment::PRODUCTION, // or Environment::STAGING
    'access_token' => 'your_access_token_here'
]);

$sdk = new GeocachingSdk($options);
```

---

## Basic Usage

The SDK provides a centralized interface where all API methods are directly available on the main `GeocachingSdk` class:

```php
// Get a geocache
$response = $sdk->getGeocache('GC123ABC');

// Get user information
$response = $sdk->getUser('PR12345');

// Search for geocaches
$response = $sdk->searchGeocaches(['q' => 'traditional cache']);

// Check API status
$response = $sdk->ping();
```

All methods return a PSR-7 `ResponseInterface` object that you can process as needed.

---

## Complete API Reference

The SDK implements **all** Geocaching API endpoints organized by functional domain:

### Adventures API
- `getAdventure($adventureId, $headers = [])`
- `getStartLocationAdventure($adventureId, $headers = [])`
- `searchAdventures($query = [], $headers = [])`
- `searchAdventuresStages($stageSearchModel, $headers = [])`

### Geocaches API
- `getGeocache($referenceCode, $query = [], $headers = [])`
- `getGeocacheImages($referenceCode, $query = [], $headers = [])`
- `getFavoritedUsersByGeocache($referenceCode, $query = [], $headers = [])`
- `getGeocaches($query, $headers = [])`
- `getGeocacheTrackables($referenceCode, $query = [], $headers = [])`
- `getGeocacheLogs($referenceCode, $query = [], $headers = [])`
- `searchGeocaches($query, $headers = [])`
- `checkFinalCoordinates($referenceCode, $coordinates, $headers = [])`
- `setBulkTrackableLogs($referenceCode, $logs, $query = [], $headers = [])`
- `updateGeocacheNote($referenceCode, $notes, $headers = [])`
- `deleteGeocacheNote($referenceCode, $headers = [])`
- `getGeocacheUserWaypoints($referenceCode, $query = [], $headers = [])`
- `updateCorrectedCoordinates($referenceCode, $coordinates, $headers = [])`
- `deleteCorrectedCoordinates($referenceCode, $headers = [])`

### Users API
- `getUserPrivacySettings($referenceCode, $headers = [])`
- `getUser($referenceCode, $query = [], $headers = [])`
- `getOptedOutUsers($query, $headers = [])`
- `getUserImages($referenceCode, $query = [], $headers = [])`
- `getUserSouvenirs($referenceCode, $query = [], $headers = [])`
- `getUsers($query = [], $headers = [])`
- `getUserLists($referenceCode, $query = [], $headers = [])`
- `getUserGeocacheLogs($referenceCode, $query = [], $headers = [])`

### Friends API
- `getFriendRequests($query = [], $headers = [])`
- `sendFriendRequest($friendRequest, $query = [], $headers = [])`
- `getFriends($query = [], $headers = [])`
- `getFriendsGeocacheLogsByGeocache($referenceCode, $query = [], $headers = [])`
- `acceptFriendRequest($requestId, $headers = [])`
- `deleteFriend($referenceCode, $headers = [])`
- `deleteFriendRequest($requestId, $headers = [])`

### Geocache Logs API
- `deleteGeocacheLog($referenceCode, $headers = [])`
- `getGeocacheLog($referenceCode, $query = [], $headers = [])`
- `updateGeocacheLog($referenceCode, $geocacheLog, $query = [], $headers = [])`
- `getGeocacheLogUpvotes($query = [], $headers = [])`
- `getGeocacheLogImages($referenceCode, $query = [], $headers = [])`
- `setGeocacheLogImages($referenceCode, $imageToUpload, $query = [], $headers = [])`
- `setGeocacheLog($geocacheLog, $query = [], $headers = [])`
- `deleteGeocacheLogUpvotes($referenceCode, $upvoteTypeId, $headers = [])`
- `setGeocacheLogUpvotes($referenceCode, $upvoteTypeId, $headers = [])`
- `deleteGeocacheLogImage($referenceCode, $imageGuid, $headers = [])`

### Lists API
- `deleteList($referenceCode, $headers = [])`
- `getList($referenceCode, $query = [], $headers = [])`
- `updateList($referenceCode, $list, $query = [], $headers = [])`
- `getZippedPocketQuery($referenceCode, $dirname, $headers = [])`
- `getGeocacheList($referenceCode, $query = [], $headers = [])`
- `setGeocacheList($referenceCode, $geocache, $query = [], $headers = [])`
- `setList($list, $query = [], $headers = [])`
- `setBulkGeocachesList($referenceCode, $body, $headers = [])`
- `deleteGeocacheList($referenceCode, $geocacheCode, $headers = [])`

### Trackables API
- `deleteTrackableLog($referenceCode, $headers = [])`
- `getTrackableLog($referenceCode, $query = [], $headers = [])`
- `updateTrackableLog($referenceCode, $trackableLog, $query = [], $headers = [])`
- `getUserTrackableLog($query = [], $headers = [])`
- `getTrackableLogImages($referenceCode, $query = [], $headers = [])`
- `setTrackableLogImages($referenceCode, $imageToUpload, $query = [], $headers = [])`
- `deleteTrackableLogImage($referenceCode, $imageGuid, $headers = [])`
- `setTrackableLog($trackableLog, $query = [], $headers = [])`
- `getTrackable($referenceCode, $query = [], $headers = [])`
- `getUserTrackables($query = [], $headers = [])`
- `getTrackableJourneys($referenceCode, $query = [], $headers = [])`
- `getGeocoinTypes($query = [], $headers = [])`
- `getTrackableImages($referenceCode, $query = [], $headers = [])`
- `getTrackableLogs($referenceCode, $query = [], $headers = [])`

### Log Drafts API
- `deleteLogdraft($referenceCode, $headers = [])`
- `getLogdraft($referenceCode, $query = [], $headers = [])`
- `updateLogdraft($referenceCode, $logDraft, $query = [], $headers = [])`
- `getLogdrafts($query = [], $headers = [])`
- `setLogdraft($logDraft, $query = [], $headers = [])`
- `promoteLogdraft($referenceCode, $logDraft, $headers = [])`
- `setLogdraftImage($referenceCode, $postImage, $query = [], $headers = [])`
- `deleteImageFromLogdraft($referenceCode, $guid, $headers = [])`

### User Waypoints API
- `getUserWaypoints($query = [], $headers = [])`
- `setGeocacheUserWaypoint($body, $headers = [])`
- `deleteUserWaypoint($referenceCode, $headers = [])`
- `updateUserWaypoint($referenceCode, $waypoint, $headers = [])`

### Reference Data API
- `getReferenceCodeFromId($query, $headers = [])`
- `getCountries($headers = [])`
- `getStates($headers = [])`
- `getStatesByCountry($countryId, $headers = [])`
- `getMembershipLevels($headers = [])`
- `getGeocacheTypes($headers = [])`
- `getAttributes($headers = [])`
- `getGeocacheSizes($headers = [])`
- `getGeocacheStatuses($headers = [])`
- `getGeocacheLogTypes($headers = [])`
- `getTrackableLogTypes($headers = [])`

### Statistics API
- `getDifficultyTerrainStatistics($headers = [])`

### Status API
- `ping()`
- `status()` (alias for ping)

### Wherigo API
- `getWherigoCartridge($guid, $query = [], $headers = [])`

### Geotours API
- `getGeotours($query = [], $headers = [])`
- `getGeotour($referenceCode, $query = [], $headers = [])`
- `getGeotourGeocaches($referenceCode, $query = [], $headers = [])`

### HQ Promotions API
- `getHQPromotionsMetadata($query = [], $headers = [])`

---

## Examples

### Basic Geocache Operations

```php
// Get a specific geocache with details
$response = $sdk->getGeocache('GC123ABC', [
    'fields' => 'referenceCode,name,difficulty,terrain'
]);

// Search for nearby geocaches
$response = $sdk->searchGeocaches([
    'origin' => '45.75,-122.68', // Portland, OR
    'radius' => '10mi',
    'take' => 20
]);

// Get geocache logs
$response = $sdk->getGeocacheLogs('GC123ABC', [
    'take' => 10
]);
```

### User Operations

```php
// Get user profile
$response = $sdk->getUser('PR12345');

// Get user's geocache logs
$response = $sdk->getUserGeocacheLogs('PR12345', [
    'take' => 50
]);

// Get user's favorites
$response = $sdk->getUserLists('PR12345');
```

### Adventure Operations

```php
// Search for adventures
$response = $sdk->searchAdventures([
    'origin' => '47.6062,-122.3321', // Seattle, WA
    'radius' => '25mi'
]);

// Get adventure details
$response = $sdk->getAdventure('12345-adventure-guid');
```

### Reference Data

```php
// Get all geocache types
$response = $sdk->getGeocacheTypes();

// Get countries
$response = $sdk->getCountries();

// Get states for USA (country ID 2)
$response = $sdk->getStatesByCountry(2);
```

### Status and Health Checks

```php
// Simple API status check
$response = $sdk->ping();

// Get your statistics
$response = $sdk->getDifficultyTerrainStatistics();
```

### Processing Responses

All methods return PSR-7 `ResponseInterface` objects:

```php
$response = $sdk->getGeocache('GC123ABC');

// Get response status
$statusCode = $response->getStatusCode(); // 200

// Get JSON body
$data = json_decode($response->getBody()->getContents(), true);

// Access geocache data
$geocacheName = $data['name'];
$difficulty = $data['difficulty'];
```

---

For HTTP logging configuration and advanced features, see the main `README.md`.