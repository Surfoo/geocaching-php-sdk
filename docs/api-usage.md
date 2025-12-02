# API Usage by Domain

All API methods live on the `GeocachingSdk` class. Each method returns a PSR-7 `ResponseInterface`; decode JSON bodies as needed. Query parameters are passed as associative arrays, and optional headers can be added per call.

```php
$response = $sdk->searchGeocaches(['q' => 'traditional cache', 'take' => 10]);
$data = json_decode($response->getBody()->getContents(), true);
```

## Geocaches

```php
// Fetch a single geocache with selected fields
$sdk->getGeocache('GC123ABC', [
    'fields' => 'referenceCode,name,difficulty,terrain,size',
]);

// Search near a point
$sdk->searchGeocaches([
    'origin' => '47.6062,-122.3321',
    'radius' => '10mi',
    'take'   => 25,
]);

// Retrieve logs for a cache
$sdk->getGeocacheLogs('GC123ABC', [
    'take' => 20,
    'skip' => 0,
]);

// Update a personal note
$sdk->updateGeocacheNote('GC123ABC', [
    'note' => 'Bring a pen and check the nearby trailhead.',
]);
```

## Users

```php
// Profile with optional query params (e.g., fields or cultureCode)
$sdk->getUser('PR12345', ['fields' => 'referenceCode,username,memberType']);

// A user's logs and lists
$sdk->getUserGeocacheLogs('PR12345', ['take' => 50]);
$sdk->getUserLists('PR12345');

// Multiple users in one call
$sdk->getUsers(['usernames' => 'alice,bob,charlie']);
```

## Adventures

```php
// Search adventures by location
$sdk->searchAdventures([
    'origin' => '45.5152,-122.6784',
    'radius' => '15mi',
    'take'   => 10,
]);

// Get full details for one adventure
$sdk->getAdventure('adventure-guid-here');
```

## Lists

```php
// Get a bookmark list and its caches
$sdk->getList('LSTABCDE', ['fields' => 'referenceCode,name,geocaches']);
$sdk->getGeocacheList('LSTABCDE', ['take' => 50]);

// Add caches in bulk
$sdk->setBulkGeocachesList('LSTABCDE', [
    'geocacheCodes' => ['GC123ABC', 'GC456DEF'],
]);
```

## Trackables

```php
// Trackable details and journey
$sdk->getTrackable('TB1234');
$sdk->getTrackableJourneys('TB1234', ['take' => 10]);

// Post a log with an image
$sdk->setTrackableLog('TB1234', [
    'logTypeId'     => 14,  // e.g., "Retrieve It"
    'text'          => 'Picked up at the event.',
    'geocacheCode'  => 'GC123ABC',
]);
$sdk->setTrackableLogImages('TB1234', [
    'imageUri'   => 'https://example.com/pickup.jpg',
    'description'=> 'Pickup proof',
]);
```

## Status, Reference Data, and Health Checks

```php
// API health
$sdk->ping(); // alias: status()

// Reference data for filters
$sdk->getGeocacheTypes();
$sdk->getGeocacheLogTypes();
$sdk->getCountries();
$sdk->getStatesByCountry(2); // e.g., USA
```

Add per-request headers (e.g., culture or client identifiers) with the optional `$headers` argument on any method:

```php
$sdk->getGeocache('GC123ABC', [], [
    'Accept-Language' => 'en-US',
    'X-Client'        => 'my-app/1.2.3',
]);
```
