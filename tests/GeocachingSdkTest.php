<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Geocaching\ClientBuilder;
use Geocaching\Client\AdventureClient;
use Geocaching\Client\FriendClient;
use Geocaching\Client\LogClient;
use Geocaching\Client\GeocacheClient;
use Geocaching\Client\TrackableClient;
use Geocaching\Client\UserClient;
use Geocaching\Client\ListClient;
use Geocaching\Client\LogdraftClient;
use Geocaching\Client\ReferenceDataClient;
use Geocaching\Client\UserWaypointClient;
use Geocaching\Client\StatusClient;
use Geocaching\Client\WherigoClient;
use Psr\Http\Client\ClientInterface;


class GeocachingSdkTest extends TestCase
{

    private GeocachingSdk $sdk;
    private $clientBuilder;
    private $clients = [];

    protected function setUp(): void
    {
        $this->clientBuilder = $this->createMock(ClientBuilder::class);
        $options = $this->createMock(Options::class);
        $options->method('getClientBuilder')->willReturn($this->clientBuilder);

        // Mock all client classes
        $clientClasses = [
            'adventureClient' => AdventureClient::class,
            'friendClient' => FriendClient::class,
            'logClient' => LogClient::class,
            'geocacheClient' => GeocacheClient::class,
            'trackableClient' => TrackableClient::class,
            'userClient' => UserClient::class,
            'listClient' => ListClient::class,
            'logdraftClient' => LogdraftClient::class,
            'referenceDataClient' => ReferenceDataClient::class,
            'userWaypointClient' => UserWaypointClient::class,
            'statusClient' => StatusClient::class,
            'wherigoClient' => WherigoClient::class,
        ];
        foreach ($clientClasses as $property => $class) {
            $this->clients[$property] = $this->createMock($class);
        }

        // Inject mocks into the SDK instance
        $this->sdk = $this->getMockBuilder(GeocachingSdk::class)
            ->setConstructorArgs([$options])
            ->onlyMethods(array_keys($clientClasses))
            ->getMock();
        foreach ($this->clients as $property => $mock) {
            $this->sdk->$property = $mock;
        }
    }

    public function testClientsAreInstantiated(): void
    {
        foreach ($this->clients as $property => $mock) {
            $this->assertSame($mock, $this->sdk->$property);
        }
    }

    public function testGetHttpClientDelegatesToClientBuilder(): void
    {
        $mockHttpClient = $this->createMock(\Http\Client\Common\HttpMethodsClientInterface::class);
        $this->clientBuilder->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClient);
        $this->assertSame($mockHttpClient, $this->sdk->getHttpClient());
    }



    public static function proxyMethodProvider(): array
    {
        return [
            // GeocacheClient proxies
            ['getGeocache', ['GC123'], 'geocacheClient', 'getGeocache'],
            ['getGeocacheImages', ['GC123'], 'geocacheClient', 'getGeocacheImages'],
            ['getFavoritedUsersByGeocache', ['GC123'], 'geocacheClient', 'getFavoritedUsersByGeocache'],
            ['getGeocaches', [['foo'=>'bar']], 'geocacheClient', 'getGeocaches'],
            ['getGeocacheTrackables', ['GC123'], 'geocacheClient', 'getGeocacheTrackables'],
            ['getGeocacheLogs', ['GC123'], 'geocacheClient', 'getGeocacheLogs'],
            ['searchGeocaches', [['foo'=>'bar']], 'geocacheClient', 'searchGeocaches'],
            ['checkFinalCoordinates', ['GC123', ['lat'=>1,'lon'=>2]], 'geocacheClient', 'checkFinalCoordinates'],
            ['setBulkTrackableLogs', ['GC123', [['foo'=>'bar']]], 'geocacheClient', 'setBulkTrackableLogs'],
            // LogClient proxies
            ['getGeocacheLog', ['GC123'], 'logClient', 'getGeocacheLog'],
            ['deleteGeocacheLog', ['GC123'], 'logClient', 'deleteGeocacheLog'],
            ['updateGeocacheLog', ['GC123', ['foo'=>'bar']], 'logClient', 'updateGeocacheLog'],
            ['getGeocacheLogUpvotes', [], 'logClient', 'getGeocacheLogUpvotes'],
            ['getGeocacheLogImages', ['GC123'], 'logClient', 'getGeocacheLogImages'],
            ['setGeocacheLogImages', ['GC123', ['foo'=>'bar']], 'logClient', 'setGeocacheLogImages'],
            ['setGeocacheLog', [['foo'=>'bar']], 'logClient', 'setGeocacheLog'],
            ['deleteGeocacheLogUpvotes', ['GC123', 1], 'logClient', 'deleteGeocacheLogUpvotes'],
            ['setGeocacheLogUpvotes', ['GC123', 1], 'logClient', 'setGeocacheLogUpvotes'],
            ['deleteGeocacheLogImage', ['GC123', 'img123'], 'logClient', 'deleteGeocacheLogImage'],
            // UserClient proxies
            ['getUserPrivacySettings', ['user123'], 'userClient', 'getUserPrivacySettings'],
            ['getUser', ['user123'], 'userClient', 'getUser'],
            ['getOptedOutUsers', [['foo'=>'bar']], 'userClient', 'getOptedOutUsers'],
            ['getUserImages', ['user123'], 'userClient', 'getUserImages'],
            ['getUserSouvenirs', ['user123'], 'userClient', 'getUserSouvenirs'],
            ['getUsers', [], 'userClient', 'getUsers'],
            ['getUserLists', ['user123'], 'userClient', 'getUserLists'],
            ['getUserGeocacheLogs', ['user123'], 'userClient', 'getUserGeocacheLogs'],
            // ListClient proxies
            ['deleteList', ['list123'], 'listClient', 'deleteList'],
            ['getList', ['list123'], 'listClient', 'getList'],
            ['updateList', ['list123', ['foo'=>'bar']], 'listClient', 'updateList'],
            ['getZippedPocketQuery', ['list123', '/tmp'], 'listClient', 'getZippedPocketQuery'],
            ['getGeocacheList', ['list123'], 'listClient', 'getGeocacheList'],
            ['setGeocacheList', ['list123', ['foo'=>'bar']], 'listClient', 'setGeocacheList'],
            ['setList', [['foo'=>'bar']], 'listClient', 'setList'],
            ['setBulkGeocachesList', ['list123', [['foo'=>'bar']]], 'listClient', 'setBulkGeocachesList'],
            ['deleteGeocacheList', ['list123', 'GC123'], 'listClient', 'deleteGeocacheList'],
            // TrackableClient proxies
            ['deleteTrackableLog', ['TB123'], 'trackableClient', 'deleteTrackableLog'],
            ['getTrackableLog', ['TB123'], 'trackableClient', 'getTrackableLog'],
            ['updateTrackableLog', ['TB123', ['foo'=>'bar']], 'trackableClient', 'updateTrackableLog'],
            ['getUserTrackableLog', [], 'trackableClient', 'getUserTrackableLog'],
            ['getTrackableLogImages', ['TB123'], 'trackableClient', 'getTrackableLogImages'],
            ['setTrackableLogImages', ['TB123', ['foo'=>'bar']], 'trackableClient', 'setTrackableLogImages'],
            ['deleteTrackableLogImage', ['TB123', 'img123'], 'trackableClient', 'deleteTrackableLogImage'],
            ['setTrackableLog', [['foo'=>'bar']], 'trackableClient', 'setTrackableLog'],
            ['getTrackable', ['TB123'], 'trackableClient', 'getTrackable'],
            ['getUserTrackables', [], 'trackableClient', 'getUserTrackables'],
            ['getTrackableJourneys', ['TB123'], 'trackableClient', 'getTrackableJourneys'],
            ['getGeocoinTypes', [], 'trackableClient', 'getGeocoinTypes'],
            ['getTrackableImages', ['TB123'], 'trackableClient', 'getTrackableImages'],
            ['getTrackableLogs', ['TB123'], 'trackableClient', 'getTrackableLogs'],
            // AdventureClient proxies
            ['getAdventure', ['adv123'], 'adventureClient', 'getAdventure'],
            ['getStartLocationAdventure', ['adv123'], 'adventureClient', 'getStartLocationAdventure'],
            ['searchAdventures', [['foo'=>'bar']], 'adventureClient', 'searchAdventures'],
            ['searchAdventuresStages', [[['foo'=>'bar']]], 'adventureClient', 'searchAdventuresStages'],
            // FriendClient proxies
            ['getFriendRequests', [], 'friendClient', 'getFriendRequests'],
            ['sendFriendRequest', [['foo'=>'bar']], 'friendClient', 'sendFriendRequest'],
            ['getFriends', [], 'friendClient', 'getFriends'],
            ['getFriendsGeocacheLogsByGeocache', ['GC123'], 'friendClient', 'getFriendsGeocacheLogsByGeocache'],
            ['acceptFriendRequest', ['req123'], 'friendClient', 'acceptFriendRequest'],
            ['deleteFriend', ['friend123'], 'friendClient', 'deleteFriend'],
            ['deleteFriendRequest', ['req123'], 'friendClient', 'deleteFriendRequest'],
            // LogdraftClient proxies
            ['deleteLogdraft', ['logdraft123'], 'logdraftClient', 'deleteLogdraft'],
            ['getLogdraft', ['logdraft123'], 'logdraftClient', 'getLogdraft'],
            ['updateLogdraft', ['logdraft123', ['foo'=>'bar']], 'logdraftClient', 'updateLogdraft'],
            ['getLogdrafts', [], 'logdraftClient', 'getLogdrafts'],
            ['setLogdraft', [['foo'=>'bar']], 'logdraftClient', 'setLogdraft'],
            ['promoteLogdraft', ['logdraft123', ['foo'=>'bar']], 'logdraftClient', 'promoteLogdraft'],
            ['setLogdraftImage', ['logdraft123', ['foo'=>'bar']], 'logdraftClient', 'setLogdraftImage'],
            ['deleteImageFromLogdraft', ['logdraft123', 'guid123'], 'logdraftClient', 'deleteImageFromLogdraft'],
            // ReferenceDataClient proxies
            ['getReferenceCodeFromId', [['foo'=>'bar']], 'referenceDataClient', 'getReferenceCodeFromId'],
            ['getCountries', [], 'referenceDataClient', 'getCountries'],
            ['getStates', [], 'referenceDataClient', 'getStates'],
            ['getStatesByCountry', [1], 'referenceDataClient', 'getStatesByCountry'],
            ['getMembershipLevels', [], 'referenceDataClient', 'getMembershipLevels'],
            ['getGeocacheTypes', [], 'referenceDataClient', 'getGeocacheTypes'],
            ['getAttributes', [], 'referenceDataClient', 'getAttributes'],
            ['getGeocacheSizes', [], 'referenceDataClient', 'getGeocacheSizes'],
            ['getGeocacheStatuses', [], 'referenceDataClient', 'getGeocacheStatuses'],
            ['getGeocacheLogTypes', [], 'referenceDataClient', 'getGeocacheLogTypes'],
            ['getTrackableLogTypes', [], 'referenceDataClient', 'getTrackableLogTypes'],
            // UserWaypointClient proxies
            ['getUserWaypoints', [], 'userWaypointClient', 'getUserWaypoints'],
            ['setGeocacheUserWaypoint', ['GC123', ['foo'=>'bar']], 'userWaypointClient', 'setGeocacheUserWaypoint'],
            ['getGeocacheUserWaypoints', ['GC123'], 'userWaypointClient', 'getGeocacheUserWaypoints'],
            ['deleteUserWaypoint', ['GC123'], 'userWaypointClient', 'deleteUserWaypoint'],
            ['updateCorrectedCoordinates', ['GC123', ['lat'=>1,'lon'=>2]], 'userWaypointClient', 'updateCorrectedCoordinates'],
            ['deleteCorrectedCoordinates', ['GC123'], 'userWaypointClient', 'deleteCorrectedCoordinates'],
            ['updateUserWaypoint', ['GC123', ['foo'=>'bar']], 'userWaypointClient', 'updateUserWaypoint'],
            // StatusClient proxies
            ['ping', [], 'statusClient', 'ping'],
            ['status', [], 'statusClient', 'status'],
            // WherigoClient proxies
            ['getWherigoCartridge', ['guid123'], 'wherigoClient', 'getWherigoCartridge'],
        ];
    }
}



class GeocachingSdkIntegrationTest extends TestCase
{
    private $sdk;
    private $clients = [];

    protected function setUp(): void
    {
        // Create mocks for all client classes
        $clientClasses = [
            'adventureClient' => AdventureClient::class,
            'friendClient' => FriendClient::class,
            'logClient' => LogClient::class,
            'geocacheClient' => GeocacheClient::class,
            'trackableClient' => TrackableClient::class,
            'userClient' => UserClient::class,
            'listClient' => ListClient::class,
            'logdraftClient' => LogdraftClient::class,
            'referenceDataClient' => ReferenceDataClient::class,
            'userWaypointClient' => UserWaypointClient::class,
            'statusClient' => StatusClient::class,
            'wherigoClient' => WherigoClient::class,
        ];
        foreach ($clientClasses as $property => $class) {
            $this->clients[$property] = $this->createMock($class);
        }

        // Create a ClientBuilder mock that returns the right client mocks
        $clientBuilder = $this->createMock(ClientBuilder::class);
        $clientBuilderMethods = [
            'getAdventureClient' => 'adventureClient',
            'getFriendClient' => 'friendClient',
            'getLogClient' => 'logClient',
            'getGeocacheClient' => 'geocacheClient',
            'getTrackableClient' => 'trackableClient',
            'getUserClient' => 'userClient',
            'getListClient' => 'listClient',
            'getLogdraftClient' => 'logdraftClient',
            'getReferenceDataClient' => 'referenceDataClient',
            'getUserWaypointClient' => 'userWaypointClient',
            'getStatusClient' => 'statusClient',
            'getWherigoClient' => 'wherigoClient',
            'getStatisticsClient' => 'statisticsClient',
        ];
        foreach ($clientBuilderMethods as $method => $property) {
            if (method_exists($clientBuilder, $method)) {
                $clientBuilder->method($method)->willReturn($this->clients[$property]);
            }
        }
        // getHttpClient can return a generic mock
        $clientBuilder->method('getHttpClient')->willReturn($this->createMock(ClientInterface::class));

        $options = $this->createMock(Options::class);
        $options->method('getClientBuilder')->willReturn($clientBuilder);

        // Instantiate the real SDK (no property override)
        $this->sdk = new GeocachingSdk($options);
    }

    /**
     * @dataProvider proxyMethodProvider
     */
    public function testProxyMethodsCallRealCode($method, $args, $clientProperty, $clientMethod)
    {
        $expected = 'integration-result';
        $this->clients[$clientProperty]
            ->expects($this->once())
            ->method($clientMethod)
            ->with(...$args)
            ->willReturn($expected);
        $this->assertSame($expected, $this->sdk->$method(...$args));
    }

    public static function proxyMethodProvider(): array
    {
        return GeocachingSdkTest::proxyMethodProvider();
    }

    public function testClientAccessorsReturnClients()
    {
        foreach ($this->clients as $property => $mock) {
            $method = $property;
            $this->assertInstanceOf(get_class($mock), $this->sdk->$method());
        }
    }
}
