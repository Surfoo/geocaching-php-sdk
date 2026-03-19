# API Usage by Domain

All API methods live on the `GeocachingSdk` class. Each method returns a PSR-7 `ResponseInterface`; decode JSON bodies as needed. Query parameters are passed as associative arrays, and optional headers can be added per call.

```php
$response = $sdk->searchGeocaches(['q' => 'traditional cache', 'take' => 10]);
$data = json_decode($response->getBody()->getContents(), true);
```

Add per-request headers (e.g., culture or client identifiers) with the optional `$headers` argument on any method:

```php
$sdk->getGeocache('GC123ABC', [], [
    'Accept-Language' => 'en-US',
    'X-Client'        => 'my-app/1.2.3',
]);
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

// Fetch multiple geocaches by reference codes
$sdk->getGeocaches(['referenceCodes' => 'GC123ABC,GC456DEF']);

// Geocache images
$sdk->getGeocacheImages('GC123ABC', ['take' => 10]);

// Users who favorited a geocache
$sdk->getFavoritedUsersByGeocache('GC123ABC');

// Trackables currently in a geocache
$sdk->getGeocacheTrackables('GC123ABC');

// Retrieve logs for a cache
$sdk->getGeocacheLogs('GC123ABC', ['take' => 20, 'skip' => 0]);

// Personal note
$sdk->updateGeocacheNote('GC123ABC', ['note' => 'Bring a pen.']);
$sdk->deleteGeocacheNote('GC123ABC');

// Corrected coordinates (mystery/multi)
$sdk->updateCorrectedCoordinates('GC123ABC', ['latitude' => 47.606, 'longitude' => -122.332]);
$sdk->deleteCorrectedCoordinates('GC123ABC');

// User waypoints attached to a geocache
$sdk->getGeocacheUserWaypoints('GC123ABC');

// Check final coordinates against a geocache solution
$sdk->checkFinalCoordinates('GC123ABC', ['latitude' => 47.606, 'longitude' => -122.332]);

// Post bulk trackable logs on a geocache visit
$sdk->setBulkTrackableLogs('GC123ABC', [
    ['trackableCode' => 'TB1234', 'logTypeId' => 75],
]);
```

## Geocache Logs

```php
// Post a found-it log
$sdk->setGeocacheLog([
    'geocacheCode' => 'GC123ABC',
    'logTypeId'    => 2,    // 2 = Found it
    'loggedDate'   => '2025-06-01T12:00:00',
    'text'         => 'Great hide!',
]);

// Fetch, update, delete a log
$sdk->getGeocacheLog('GL123ABC');
$sdk->updateGeocacheLog('GL123ABC', ['text' => 'Updated text.']);
$sdk->deleteGeocacheLog('GL123ABC');

// Images on a log
$sdk->getGeocacheLogImages('GL123ABC');
$sdk->setGeocacheLogImages('GL123ABC', ['imageUri' => 'https://example.com/photo.jpg', 'description' => 'Cache photo']);
$sdk->deleteGeocacheLogImage('GL123ABC', 'image-guid-here');

// Upvotes
$sdk->getGeocacheLogUpvotes(['logReferenceCode' => 'GL123ABC']);
$sdk->setGeocacheLogUpvotes('GL123ABC', 1);    // upvoteTypeId 1 = Great Story
$sdk->deleteGeocacheLogUpvotes('GL123ABC', 1);
```

## Log Drafts

```php
// Create and list drafts
$sdk->setLogdraft([
    'geocacheCode' => 'GC123ABC',
    'logTypeId'    => 2,
    'loggedDate'   => '2025-06-01T12:00:00',
    'note'         => 'Draft note',
]);
$sdk->getLogdrafts(['take' => 20]);

// Fetch, update, delete a draft
$sdk->getLogdraft('LD123ABC');
$sdk->updateLogdraft('LD123ABC', ['note' => 'Updated draft.']);
$sdk->deleteLogdraft('LD123ABC');

// Promote a draft to a real log
$sdk->promoteLogdraft('LD123ABC', ['text' => 'Final log text.']);

// Draft images
$sdk->setLogdraftImage('LD123ABC', ['imageUri' => 'https://example.com/photo.jpg']);
$sdk->deleteImageFromLogdraft('LD123ABC', 'image-guid-here');
```

## Users

```php
// Profile with optional query params (e.g., fields or cultureCode)
$sdk->getUser('PR12345', ['fields' => 'referenceCode,username,memberType']);

// Multiple users
$sdk->getUsers(['usernames' => 'alice,bob,charlie']);

// A user's logs and lists
$sdk->getUserGeocacheLogs('PR12345', ['take' => 50]);
$sdk->getUserLists('PR12345');

// User images and souvenirs
$sdk->getUserImages('PR12345', ['take' => 10]);
$sdk->getUserSouvenirs('PR12345');

// Privacy settings
$sdk->getUserPrivacySettings('PR12345');

// Users who opted out of friend searches
$sdk->getOptedOutUsers(['take' => 10]);
```

## Friends

```php
// List friends and their cache logs on a specific geocache
$sdk->getFriends(['take' => 20]);
$sdk->getFriendsGeocacheLogsByGeocache('GC123ABC');

// Friend requests
$sdk->getFriendRequests();
$sdk->sendFriendRequest(['userCode' => 'PR99999']);
$sdk->acceptFriendRequest('request-id-here');
$sdk->deleteFriendRequest('request-id-here');

// Remove a friend
$sdk->deleteFriend('PR99999');
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

// Search adventure stages
$sdk->searchAdventuresStages([
    'adventureId' => 'adventure-guid-here',
    'origin'      => '45.5152,-122.6784',
]);
```

## Lists

```php
// Create a new list
$sdk->setList([
    'name'           => 'My bucket list',
    'description'    => 'Caches I want to find.',
    'typeId'         => 2, // 2 = bookmark list
    'isPublic'       => true,
]);

// Get a bookmark list and its caches
$sdk->getList('LSTABCDE', ['fields' => 'referenceCode,name,geocaches']);
$sdk->getGeocacheList('LSTABCDE', ['take' => 50]);

// Update or delete a list
$sdk->updateList('LSTABCDE', ['name' => 'Renamed list']);
$sdk->deleteList('LSTABCDE');

// Add/remove caches
$sdk->setGeocacheList('LSTABCDE', ['geocacheCode' => 'GC123ABC']);
$sdk->setBulkGeocachesList('LSTABCDE', ['geocacheCodes' => ['GC123ABC', 'GC456DEF']]);
$sdk->deleteGeocacheList('LSTABCDE', 'GC123ABC');

// Download a pocket query as a ZIP file
$sdk->getZippedPocketQuery('PQ123ABC', '/tmp');
```

## Trackables

```php
// Trackable details and journey
$sdk->getTrackable('TB1234');
$sdk->getTrackableJourneys('TB1234', ['take' => 10]);
$sdk->getTrackableImages('TB1234');
$sdk->getTrackableLogs('TB1234');

// User's trackables
$sdk->getUserTrackables(['take' => 20]);

// Geocoin types
$sdk->getGeocoinTypes();

// Trackable logs CRUD
$sdk->setTrackableLog([
    'trackableCode' => 'TB1234',
    'logTypeId'     => 14,  // e.g. "Retrieve It"
    'text'          => 'Picked up at the event.',
    'geocacheCode'  => 'GC123ABC',
]);
$sdk->getTrackableLog('TL123ABC');
$sdk->getUserTrackableLog(['take' => 20]);
$sdk->updateTrackableLog('TL123ABC', ['text' => 'Updated text.']);
$sdk->deleteTrackableLog('TL123ABC');

// Trackable log images
$sdk->setTrackableLogImages('TL123ABC', ['imageUri' => 'https://example.com/pickup.jpg', 'description' => 'Pickup proof']);
$sdk->getTrackableLogImages('TL123ABC');
$sdk->deleteTrackableLogImage('TL123ABC', 'image-guid-here');
```

## User Waypoints

```php
// List all user waypoints across caches
$sdk->getUserWaypoints(['take' => 50]);

// Create, update, delete a waypoint
$sdk->setGeocacheUserWaypoint([
    'geocacheCode'  => 'GC123ABC',
    'isCorrectedCoordinates' => false,
    'coordinates'   => ['latitude' => 47.606, 'longitude' => -122.332],
    'description'   => 'Parking area',
]);
$sdk->updateUserWaypoint('UW123ABC', ['description' => 'Updated parking.']);
$sdk->deleteUserWaypoint('UW123ABC');
```

## Wherigo

```php
// Fetch a Wherigo cartridge by GUID
$sdk->getWherigoCartridge('cartridge-guid-here');
```

## Geotours

```php
// List all geotours
$sdk->getGeotours(['take' => 10]);

// Get a specific geotour and its geocaches
$sdk->getGeotour('GT123ABC');
$sdk->getGeotourGeocaches('GT123ABC', ['take' => 50]);
```

## HQ Promotions

```php
// Get HQ promotions (banners, events, etc.)
$sdk->getHQPromotions();
```

## Reference Data & Statistics

```php
// API health
$sdk->ping(); // alias: status()

// Convert a numeric ID to a reference code
$sdk->getReferenceCodeFromId(['id' => 12345, 'type' => 3]);

// Difficulty/terrain statistics for the authenticated user
$sdk->getDifficultyTerrainStatistics();

// Lookup tables for filters and log forms
$sdk->getGeocacheTypes();
$sdk->getGeocacheLogTypes();
$sdk->getGeocacheSizes();
$sdk->getGeocacheStatuses();
$sdk->getAttributes();
$sdk->getMembershipLevels();
$sdk->getTrackableLogTypes();
$sdk->getGeocoinTypes();

// Geography
$sdk->getCountries();
$sdk->getStates();
$sdk->getStatesByCountry(2); // e.g., USA
```
