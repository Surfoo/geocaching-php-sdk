<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\Enum\Environment;

class GeocachingSdkTest extends TestCase
{
    private GeocachingSdk $sdk;

    protected function setUp(): void
    {
        $options = new Options([
            'environment' => Environment::PRODUCTION,
            'access_token' => 'test-token'
        ]);
        
        $this->sdk = new GeocachingSdk($options);
    }

    public function testSdkInstantiation(): void
    {
        $this->assertInstanceOf(GeocachingSdk::class, $this->sdk);
    }

    public function testGetHttpClientReturnsClientInterface(): void
    {
        $httpClient = $this->sdk->getHttpClient();
        $this->assertInstanceOf(\Psr\Http\Client\ClientInterface::class, $httpClient);
    }

    public function testAllApiMethodsExist(): void
    {
        $methods = [
            // Adventures API
            'getAdventure',
            'searchAdventures',
            'searchAdventuresStages',
            
            // Geocaches API
            'getGeocache',
            'getGeocacheImages',
            'getFavoritedUsersByGeocache',
            'getGeocaches',
            'getGeocacheTrackables',
            'getGeocacheLogs',
            'searchGeocaches',
            'checkFinalCoordinates',
            'setBulkTrackableLogs',
            'updateGeocacheNote',
            'deleteGeocacheNote',
            'getGeocacheUserWaypoints',
            'updateCorrectedCoordinates',
            'deleteCorrectedCoordinates',
            
            // Users API
            'getUserPrivacySettings',
            'getUser',
            'getOptedOutUsers',
            'getUserImages',
            'getUserSouvenirs',
            'getUsers',
            'getUserLists',
            'getUserGeocacheLogs',
            
            // Friends API
            'getFriendRequests',
            'sendFriendRequest',
            'getFriends',
            'getFriendsGeocacheLogsByGeocache',
            'acceptFriendRequest',
            'deleteFriend',
            'deleteFriendRequest',
            
            // Geocache Logs API
            'deleteGeocacheLog',
            'getGeocacheLog',
            'updateGeocacheLog',
            'getGeocacheLogUpvotes',
            'getGeocacheLogImages',
            'setGeocacheLogImages',
            'setGeocacheLog',
            'deleteGeocacheLogUpvotes',
            'setGeocacheLogUpvotes',
            'deleteGeocacheLogImage',
            
            // Lists API
            'deleteList',
            'getList',
            'updateList',
            'getZippedPocketQuery',
            'getGeocacheList',
            'setGeocacheList',
            'setList',
            'setBulkGeocachesList',
            'deleteGeocacheList',
            
            // Trackables API
            'deleteTrackableLog',
            'getTrackableLog',
            'updateTrackableLog',
            'getUserTrackableLog',
            'getTrackableLogImages',
            'setTrackableLogImages',
            'deleteTrackableLogImage',
            'setTrackableLog',
            'getTrackable',
            'getUserTrackables',
            'getTrackableJourneys',
            'getGeocoinTypes',
            'getTrackableImages',
            'getTrackableLogs',
            
            // Log Drafts API
            'deleteLogdraft',
            'getLogdraft',
            'updateLogdraft',
            'getLogdrafts',
            'setLogdraft',
            'promoteLogdraft',
            'setLogdraftImage',
            'deleteImageFromLogdraft',
            
            // User Waypoints API
            'getUserWaypoints',
            'setGeocacheUserWaypoint',
            'deleteUserWaypoint',
            'updateUserWaypoint',
            
            // Reference Data API
            'getReferenceCodeFromId',
            'getCountries',
            'getStates',
            'getStatesByCountry',
            'getMembershipLevels',
            'getGeocacheTypes',
            'getAttributes',
            'getGeocacheSizes',
            'getGeocacheStatuses',
            'getGeocacheLogTypes',
            'getTrackableLogTypes',
            
            // Statistics API
            'getDifficultyTerrainStatistics',
            
            // Status API
            'ping',
            'status',
            
            // Wherigo API
            'getWherigoCartridge',
            
            // Geotours API (New)
            'getGeotours',
            'getGeotour',
            'getGeotourGeocaches',
            
            // HQ Promotions API
            'getHQPromotions',
        ];

        foreach ($methods as $method) {
            $this->assertTrue(
                method_exists($this->sdk, $method),
                "Method $method should exist in GeocachingSdk"
            );
        }
    }

    public function testMethodsReturnResponseInterface(): void
    {
        // Test that methods have proper return type hints
        $reflection = new ReflectionClass($this->sdk);
        
        $methodsToTest = ['getGeocache', 'getUser', 'ping'];
        
        foreach ($methodsToTest as $methodName) {
            $method = $reflection->getMethod($methodName);
            $returnType = $method->getReturnType();
            
            $this->assertNotNull($returnType, "Method $methodName should have return type");
            $this->assertEquals(
                'Psr\Http\Message\ResponseInterface', 
                $returnType->getName(),
                "Method $methodName should return ResponseInterface"
            );
        }
    }
}