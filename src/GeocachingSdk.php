<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace Geocaching;

use Geocaching\Client\AdventureClient;
use Geocaching\Client\FriendClient;
use Geocaching\Client\GeocacheClient;
use Geocaching\Client\ListClient;
use Geocaching\Client\LogClient;
use Geocaching\Client\LogdraftClient;
use Geocaching\Client\ReferenceDataClient;
use Geocaching\Client\StatisticsClient;
use Geocaching\Client\StatusClient;
use Geocaching\Client\TrackableClient;
use Geocaching\Client\UserClient;
use Geocaching\Client\UserWaypointClient;
use Geocaching\Client\WherigoClient;
use Psr\Http\Client\ClientInterface;

/**
 * List of methods from Groundspeak API.
 *
 * @see https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingSdk implements GeocachingSdkInterface
{
    private ClientBuilder $clientBuilder;
    public AdventureClient $adventureClient;
    public FriendClient $friendClient;
    public GeocacheClient $geocacheClient;
    public ListClient $listClient;
    public LogClient $logClient;
    public LogdraftClient $logdraftClient;
    public ReferenceDataClient $referenceDataClient;
    public StatisticsClient $statisticsClient;
    public StatusClient $statusClient;
    public TrackableClient $trackableClient;
    public UserClient $userClient;
    public UserWaypointClient $userWaypointClient;
    public WherigoClient $wherigoClient;

    public function __construct(Options $options)
    {
        $this->clientBuilder       = $options->getClientBuilder();
        $this->adventureClient     = $this->clientBuilder->getAdventureClient();
        $this->friendClient        = $this->clientBuilder->getFriendClient();
        $this->logClient           = $this->clientBuilder->getLogClient();
        $this->geocacheClient      = $this->clientBuilder->getGeocacheClient();
        $this->trackableClient     = $this->clientBuilder->getTrackableClient();
        $this->userClient          = $this->clientBuilder->getUserClient();
        $this->listClient          = $this->clientBuilder->getListClient();
        $this->logdraftClient      = $this->clientBuilder->getLogdraftClient();
        $this->referenceDataClient = $this->clientBuilder->getReferenceDataClient();
        $this->userWaypointClient  = $this->clientBuilder->getUserWaypointClient();
        $this->statusClient        = $this->clientBuilder->getStatusClient();
        $this->wherigoClient       = $this->clientBuilder->getWherigoClient();
        $this->statisticsClient     = $this->clientBuilder->getStatisticsClient();
    }

    /**
     * Get the underlying HTTP client (PSR-18 compatible).
     *
     * This returns the HttpMethodsClient as a ClientInterface for
     * maximum compatibility while maintaining PSR-18 compliance.
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }

    public function adventureClient(): AdventureClient
    {
        return $this->adventureClient;
    }
    public function friendClient(): FriendClient
    {
        return $this->friendClient;
    }
    public function logClient(): LogClient
    {
        return $this->logClient;
    }
    public function geocacheClient(): GeocacheClient
    {
        return $this->geocacheClient;
    }
    public function trackableClient(): TrackableClient
    {
        return $this->trackableClient;
    }
    public function userClient(): UserClient
    {
        return $this->userClient;
    }
    public function listClient(): ListClient
    {
        return $this->listClient;
    }
    public function logdraftClient(): LogdraftClient
    {
        return $this->logdraftClient;
    }
    public function referenceDataClient(): ReferenceDataClient
    {
        return $this->referenceDataClient;
    }
    public function userWaypointClient(): UserWaypointClient
    {
        return $this->userWaypointClient;
    }
    public function statisticsClient(): StatisticsClient
    {
        return $this->statisticsClient;
    }
    public function statusClient(): StatusClient
    {
        return $this->statusClient;
    }
    public function wherigoClient(): WherigoClient
    {
        return $this->wherigoClient;
    }

    // --- Backward compatibility proxy methods ---
    // GeocacheClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocache(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->getGeocache($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheImages(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->getGeocacheImages($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->getFavoritedUsersByGeocache($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocaches(array $query, array $headers = [])
    {
        return $this->geocacheClient->getGeocaches($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->getGeocacheTrackables($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheLogs(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->getGeocacheLogs($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function searchGeocaches(array $query, array $headers = [])
    {
        return $this->geocacheClient->searchGeocaches($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $headers = [])
    {
        return $this->geocacheClient->checkFinalCoordinates($referenceCode, $coordinates, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $headers = [])
    {
        return $this->geocacheClient->setBulkTrackableLogs($referenceCode, $logs, $query, $headers);
    }

    // LogClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheLog(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->logClient->getGeocacheLog($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteGeocacheLog(string $referenceCode, array $headers = [])
    {
        return $this->logClient->deleteGeocacheLog($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $headers = [])
    {
        return $this->logClient->updateGeocacheLog($referenceCode, $geocacheLog, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheLogUpvotes(array $query = [], array $headers = [])
    {
        return $this->logClient->getGeocacheLogUpvotes($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->logClient->getGeocacheLogImages($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = [])
    {
        return $this->logClient->setGeocacheLogImages($referenceCode, $imageToUpload, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setGeocacheLog(array $geocacheLog, array $query = [], array $headers = [])
    {
        return $this->logClient->setGeocacheLog($geocacheLog, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = [])
    {
        return $this->logClient->deleteGeocacheLogUpvotes($referenceCode, $upvoteTypeId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = [])
    {
        return $this->logClient->setGeocacheLogUpvotes($referenceCode, $upvoteTypeId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $headers = [])
    {
        return $this->logClient->deleteGeocacheLogImage($referenceCode, $imageGuid, $headers);
    }

    // UserClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserPrivacySettings(string $referenceCode, array $headers = [])
    {
        return $this->userClient->getUserPrivacySettings($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUser(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userClient->getUser($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getOptedOutUsers(array $query, array $headers = [])
    {
        return $this->userClient->getOptedOutUsers($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserImages(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userClient->getUserImages($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserSouvenirs(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userClient->getUserSouvenirs($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUsers(array $query = [], array $headers = [])
    {
        return $this->userClient->getUsers($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserLists(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userClient->getUserLists($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userClient->getUserGeocacheLogs($referenceCode, $query, $headers);
    }

    // ListClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteList(string $referenceCode, array $headers = [])
    {
        return $this->listClient->deleteList($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getList(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->listClient->getList($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateList(string $referenceCode, array $list, array $query = [], array $headers = [])
    {
        return $this->listClient->updateList($referenceCode, $list, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $headers = [])
    {
        return $this->listClient->getZippedPocketQuery($referenceCode, $dirname, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheList(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->listClient->getGeocacheList($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $headers = [])
    {
        return $this->listClient->setGeocacheList($referenceCode, $geocache, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setList(array $list, array $query = [], array $headers = [])
    {
        return $this->listClient->setList($list, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setBulkGeocachesList(string $referenceCode, array $body, array $headers = [])
    {
        return $this->listClient->setBulkGeocachesList($referenceCode, $body, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $headers = [])
    {
        return $this->listClient->deleteGeocacheList($referenceCode, $geocacheCode, $headers);
    }

    // TrackableClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteTrackableLog(string $referenceCode, array $headers = [])
    {
        return $this->trackableClient->deleteTrackableLog($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableLog(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackableLog($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $headers = [])
    {
        return $this->trackableClient->updateTrackableLog($referenceCode, $trackableLog, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserTrackableLog(array $query = [], array $headers = [])
    {
        return $this->trackableClient->getUserTrackableLog($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableLogImages(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackableLogImages($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = [])
    {
        return $this->trackableClient->setTrackableLogImages($referenceCode, $imageToUpload, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $headers = [])
    {
        return $this->trackableClient->deleteTrackableLogImage($referenceCode, $imageGuid, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setTrackableLog(array $trackableLog, array $query = [], array $headers = [])
    {
        return $this->trackableClient->setTrackableLog($trackableLog, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackable(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackable($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserTrackables(array $query = [], array $headers = [])
    {
        return $this->trackableClient->getUserTrackables($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableJourneys(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackableJourneys($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocoinTypes(array $query = [], array $headers = [])
    {
        return $this->trackableClient->getGeocoinTypes($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableImages(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackableImages($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableLogs(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->trackableClient->getTrackableLogs($referenceCode, $query, $headers);
    }

    // AdventureClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getAdventure(string $adventureId, array $headers = [])
    {
        return $this->adventureClient->getAdventure($adventureId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getStartLocationAdventure(string $adventureId, array $headers = [])
    {
        return $this->adventureClient->getStartLocationAdventure($adventureId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function searchAdventures(array $query = [], array $headers = [])
    {
        return $this->adventureClient->searchAdventures($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function searchAdventuresStages(array $stageSearchModel, array $headers = [])
    {
        return $this->adventureClient->searchAdventuresStages($stageSearchModel, $headers);
    }

    // FriendClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getFriendRequests(array $query = [], array $headers = [])
    {
        return $this->friendClient->getFriendRequests($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function sendFriendRequest(array $friendRequest, array $query = [], array $headers = [])
    {
        return $this->friendClient->sendFriendRequest($friendRequest, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getFriends(array $query = [], array $headers = [])
    {
        return $this->friendClient->getFriends($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->friendClient->getFriendsGeocacheLogsByGeocache($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function acceptFriendRequest(string $requestId, array $headers = [])
    {
        return $this->friendClient->acceptFriendRequest($requestId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteFriend(string $referenceCode, array $headers = [])
    {
        return $this->friendClient->deleteFriend($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteFriendRequest(string $requestId, array $headers = [])
    {
        return $this->friendClient->deleteFriendRequest($requestId, $headers);
    }

    // LogdraftClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteLogdraft(string $referenceCode, array $headers = [])
    {
        return $this->logdraftClient->deleteLogdraft($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getLogdraft(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->logdraftClient->getLogdraft($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $headers = [])
    {
        return $this->logdraftClient->updateLogdraft($referenceCode, $logDraft, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getLogdrafts(array $query = [], array $headers = [])
    {
        return $this->logdraftClient->getLogdrafts($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setLogdraft(array $logDraft, array $query = [], array $headers = [])
    {
        return $this->logdraftClient->setLogdraft($logDraft, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function promoteLogdraft(string $referenceCode, array $logDraft, array $headers = [])
    {
        return $this->logdraftClient->promoteLogdraft($referenceCode, $logDraft, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $headers = [])
    {
        return $this->logdraftClient->setLogdraftImage($referenceCode, $postImage, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteImageFromLogdraft(string $referenceCode, string $guid, array $headers = [])
    {
        return $this->logdraftClient->deleteImageFromLogdraft($referenceCode, $guid, $headers);
    }

    // ReferenceDataClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getReferenceCodeFromId(array $query, array $headers = [])
    {
        return $this->referenceDataClient->getReferenceCodeFromId($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getCountries(array $headers = [])
    {
        return $this->referenceDataClient->getCountries($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getStates(array $headers = [])
    {
        return $this->referenceDataClient->getStates($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getStatesByCountry(int $countryId, array $headers = [])
    {
        return $this->referenceDataClient->getStatesByCountry($countryId, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getMembershipLevels(array $headers = [])
    {
        return $this->referenceDataClient->getMembershipLevels($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheTypes(array $headers = [])
    {
        return $this->referenceDataClient->getGeocacheTypes($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getAttributes(array $headers = [])
    {
        return $this->referenceDataClient->getAttributes($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheSizes(array $headers = [])
    {
        return $this->referenceDataClient->getGeocacheSizes($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheStatuses(array $headers = [])
    {
        return $this->referenceDataClient->getGeocacheStatuses($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheLogTypes(array $headers = [])
    {
        return $this->referenceDataClient->getGeocacheLogTypes($headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getTrackableLogTypes(array $headers = [])
    {
        return $this->referenceDataClient->getTrackableLogTypes($headers);
    }

    // UserWaypointClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getUserWaypoints(array $query = [], array $headers = [])
    {
        return $this->userWaypointClient->getUserWaypoints($query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function setGeocacheUserWaypoint(string $referenceCode, array $body, array $headers = [])
    {
        return $this->userWaypointClient->setGeocacheUserWaypoint($referenceCode, $body, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $headers = [])
    {
        return $this->userWaypointClient->getGeocacheUserWaypoints($referenceCode, $query, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteUserWaypoint(string $referenceCode, array $headers = [])
    {
        return $this->userWaypointClient->deleteUserWaypoint($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $headers = [])
    {
        return $this->userWaypointClient->updateCorrectedCoordinates($referenceCode, $coordinates, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function deleteCorrectedCoordinates(string $referenceCode, array $headers = [])
    {
        return $this->userWaypointClient->deleteCorrectedCoordinates($referenceCode, $headers);
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function updateUserWaypoint(string $referenceCode, array $query, array $headers = [])
    {
        return $this->userWaypointClient->updateUserWaypoint($referenceCode, $query, $headers);
    }

    // StatusClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function ping()
    {
        return $this->statusClient->ping();
    }
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function status()
    {
        return $this->statusClient->status();
    }

    // WherigoClient proxies
    /** @codeCoverageIgnore */
    /** @deprecated Since version 4.0 */
    public function getWherigoCartridge(string $guid, array $query = [], array $headers = [])
    {
        return $this->wherigoClient->getWherigoCartridge($guid, $query, $headers);
    }
}
