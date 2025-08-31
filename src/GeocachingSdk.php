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

use Http\Discovery\Psr18ClientDiscovery;
use Http\Client\Common\PluginClientFactory;
use Http\Client\Common\HttpMethodsClientInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Centralized Geocaching API SDK - All methods in one class.
 *
 * @see https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingSdk
{
    private ClientBuilder $clientBuilder;
    private HttpMethodsClientInterface $httpClient;

    public function __construct(Options $options)
    {
        $this->clientBuilder = $options->getClientBuilder();
        $this->httpClient = $this->clientBuilder->getHttpClient();
    }

    /**
     * Get the underlying HTTP client (PSR-18 compatible).
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Build query string from array parameters.
     */
    private function buildQueryString(array $query): string
    {
        return !empty($query) ? '?' . http_build_query($query) : '';
    }

    /**
     * Encode array data to JSON string.
     */
    private function encodeJson(array $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    // ==========================================
    // ADVENTURES API
    // ==========================================

    /**
     * Get a single adventure.
     * GET /v1/adventures/{adventureId}
     */
    public function getAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/adventures/' . $adventureId, $headers);
    }

    /**
     * Get adventure start location (anonymous endpoint).
     * GET /v1/adventures/anon/{adventureId}
     */
    public function getStartLocationAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/adventures/anon/' . $adventureId, $headers);
    }

    /**
     * Search adventures.
     * GET /v1/adventures/search
     */
    public function searchAdventures(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/adventures/search' . $queryString, $headers);
    }

    /**
     * Search adventure stages.
     * POST /v1/adventures/stages/search
     */
    public function searchAdventuresStages(array $stageSearchModel, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/adventures/stages/search', $headers, $this->encodeJson($stageSearchModel));
    }

    // ==========================================
    // GEOCACHES API
    // ==========================================

    /**
     * Get a single geocache.
     * GET /v1/geocaches/{referenceCode}
     */
    public function getGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Get geocache images.
     * GET /v1/geocaches/{referenceCode}/images
     */
    public function getGeocacheImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . '/images' . $queryString, $headers);
    }

    /**
     * Get users who favorited a geocache.
     * GET /v1/geocaches/{referenceCode}/favoritedby
     */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . '/favoritedby' . $queryString, $headers);
    }

    /**
     * Get multiple geocaches.
     * GET /v1/geocaches
     */
    public function getGeocaches(array $query, array $headers = []): ResponseInterface
    {
        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        return $this->httpClient->get('/geocaches' . $queryString, $headers);
    }

    /**
     * Get trackables in a geocache.
     * GET /v1/geocaches/{referenceCode}/trackables
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . '/trackables' . $queryString, $headers);
    }

    /**
     * Get geocache logs.
     * GET /v1/geocaches/{referenceCode}/geocachelogs
     */
    public function getGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }

    /**
     * Search geocaches.
     * GET /v1/geocaches/search
     */
    public function searchGeocaches(array $query, array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/search' . $queryString, $headers);
    }

    /**
     * Check final coordinates.
     * POST /v1/geocaches/{referenceCode}/finalcoordinates
     */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/geocaches/' . $referenceCode . '/finalcoordinates', $headers, $this->encodeJson($coordinates));
    }

    /**
     * Set bulk trackable logs.
     * POST /v1/geocaches/{referenceCode}/bulktrackablelogs
     */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/geocaches/' . $referenceCode . '/bulktrackablelogs' . $queryString, $headers, $this->encodeJson($logs));
    }

    /**
     * Update geocache note.
     * PUT /v1/geocaches/{referenceCode}/notes
     */
    public function updateGeocacheNote(string $referenceCode, array $notes, array $headers = []): ResponseInterface
    {
        return $this->httpClient->put('/geocaches/' . $referenceCode . '/notes', $headers, $this->encodeJson($notes));
    }

    /**
     * Delete geocache note.
     * DELETE /v1/geocaches/{referenceCode}/notes
     */
    public function deleteGeocacheNote(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/geocaches/' . $referenceCode . '/notes', $headers);
    }

    /**
     * Get user waypoints for a geocache.
     * GET /v1/geocaches/{referenceCode}/userwaypoints
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocaches/' . $referenceCode . '/userwaypoints' . $queryString, $headers);
    }

    /**
     * Update corrected coordinates.
     * PUT /v1/geocaches/{referenceCode}/correctedcoordinates
     */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->httpClient->put('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers, $this->encodeJson($coordinates));
    }

    /**
     * Delete corrected coordinates.
     * DELETE /v1/geocaches/{referenceCode}/correctedcoordinates
     */
    public function deleteCorrectedCoordinates(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers);
    }

    // ==========================================
    // USERS API
    // ==========================================

    /**
     * Get user privacy settings.
     * GET /v1/users/{referenceCode}/privacysettings
     */
    public function getUserPrivacySettings(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/users/' . $referenceCode . '/privacysettings', $headers);
    }

    /**
     * Get a single user.
     * GET /v1/users/{referenceCode}
     */
    public function getUser(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Get opted out users.
     * GET /v1/optedoutusers
     */
    public function getOptedOutUsers(array $query, array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/optedoutusers' . $queryString, $headers);
    }

    /**
     * Get user images.
     * GET /v1/users/{referenceCode}/images
     */
    public function getUserImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users/' . $referenceCode . '/images' . $queryString, $headers);
    }

    /**
     * Get user souvenirs.
     * GET /v1/users/{referenceCode}/souvenirs
     */
    public function getUserSouvenirs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users/' . $referenceCode . '/souvenirs' . $queryString, $headers);
    }

    /**
     * Get multiple users.
     * GET /v1/users
     */
    public function getUsers(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users' . $queryString, $headers);
    }

    /**
     * Get user lists.
     * GET /v1/users/{referenceCode}/lists
     */
    public function getUserLists(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users/' . $referenceCode . '/lists' . $queryString, $headers);
    }

    /**
     * Get user geocache logs.
     * GET /v1/users/{referenceCode}/geocachelogs
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/users/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }

    // ==========================================
    // FRIENDS API
    // ==========================================

    /**
     * Get friend requests.
     * GET /v1/friendrequests
     */
    public function getFriendRequests(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/friendrequests' . $queryString, $headers);
    }

    /**
     * Send friend request.
     * POST /v1/friendrequests
     */
    public function sendFriendRequest(array $friendRequest, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/friendrequests' . $queryString, $headers, $this->encodeJson($friendRequest));
    }

    /**
     * Get friends.
     * GET /v1/friends
     */
    public function getFriends(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/friends' . $queryString, $headers);
    }

    /** 
     * Get friends geocache logs by geocache.
     * GET /v1/friends/geocaches/{referenceCode}/geocachelogs
     */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/friends/geocaches/' . $referenceCode . '/geocachelogs' . $queryString, $headers);
    }

    /**
     * Accept friend request.
     * POST /v1/friendrequests/{requestId}/accept
     */
    public function acceptFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/friendrequests/' . $requestId . '/accept', $headers);
    }

    /**
     * Delete friend.
     * DELETE /v1/friends/{userCode}
     */
    public function deleteFriend(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/friends/' . $referenceCode, $headers);
    }

    /**
     * Delete friend request.
     * DELETE /v1/friendrequests/{requestId}
     */
    public function deleteFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/friendrequests/' . $requestId, $headers);
    }
    // ==========================================
    // GEOCACHE LOGS API
    // ==========================================

    /**
     * Delete geocache log.
     * DELETE /v1/geocachelogs/{referenceCode}
     */
    public function deleteGeocacheLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/geocachelogs/' . $referenceCode, $headers);
    }

    /**
     * Get geocache log.
     * GET /v1/geocachelogs/{referenceCode}
     */
    public function getGeocacheLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocachelogs/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Update geocache log.
     * PUT /v1/geocachelogs/{referenceCode}
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->put('/geocachelogs/' . $referenceCode . $queryString, $headers, $this->encodeJson($geocacheLog));
    }

    /**
     * Get geocache log upvotes.
     * GET /v1/geocachelogs/upvotes
     */
    public function getGeocacheLogUpvotes(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocachelogs/upvotes' . $queryString, $headers);
    }

    /**
     * Get geocache log images.
     * GET /v1/geocachelogs/{referenceCode}/images
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geocachelogs/' . $referenceCode . '/images' . $queryString, $headers);
    }

    /**
     * Set geocache log images.
     * POST /v1/geocachelogs/{referenceCode}/images
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/geocachelogs/' . $referenceCode . '/images' . $queryString, $headers, $this->encodeJson($imageToUpload));
    }

    /**
     * Set geocache log.
     * POST /v1/geocachelogs
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/geocachelogs' . $queryString, $headers, $this->encodeJson($geocacheLog));
    }

    /**
     * Delete geocache log upvotes.
     * DELETE /v1/geocachelogs/{referenceCode}/upvotes/{upvoteTypeId}
     */
    public function deleteGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    /**
     * Set geocache log upvotes.
     * POST /v1/geocachelogs/{referenceCode}/upvotes/{upvoteTypeId}
     */
    public function setGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    /**
     * Delete geocache log image.
     * DELETE /v1/geocachelogs/{referenceCode}/images/{imageGuid}
     */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/geocachelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }
    // ==========================================
    // LISTS API
    // ==========================================

    /**
     * Delete list.
     * DELETE /v1/lists/{referenceCode}
     */
    public function deleteList(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/lists/' . $referenceCode, $headers);
    }

    /**
     * Get list.
     * GET /v1/lists/{referenceCode}
     */
    public function getList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/lists/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Update list.
     * PUT /v1/lists/{referenceCode}
     */
    public function updateList(string $referenceCode, array $list, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->put('/lists/' . $referenceCode . $queryString, $headers, $this->encodeJson($list));
    }

    /**
     * Get zipped pocket query.
     * GET /v1/lists/{referenceCode}/geocaches/zipped
     */
    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $headers = []): ResponseInterface
    {
        $fullAbsolutePath = sprintf('%s/%s.zip', $dirname, $referenceCode);
        $headers = array_merge($headers, ['sink' => $fullAbsolutePath]);
        return $this->httpClient->get('/lists/' . $referenceCode . '/geocaches/zipped', $headers);
    }

    /**
     * Get geocache list.
     * GET /v1/lists/{referenceCode}/geocaches
     */
    public function getGeocacheList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/lists/' . $referenceCode . '/geocaches' . $queryString, $headers);
    }

    /**
     * Set geocache list.
     * POST /v1/lists/{referenceCode}/geocaches
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/lists/' . $referenceCode . '/geocaches' . $queryString, $headers, $this->encodeJson($geocache));
    }

    /**
     * Set list.
     * POST /v1/lists
     */
    public function setList(array $list, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/lists' . $queryString, $headers, $this->encodeJson($list));
    }

    /**
     * Set bulk geocaches list.
     * POST /v1/lists/{referenceCode}/bulkgeocaches
     */
    public function setBulkGeocachesList(string $referenceCode, array $body, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/lists/' . $referenceCode . '/bulkgeocaches', $headers, $this->encodeJson($body));
    }

    /**
     * Delete geocache from list.
     * DELETE /v1/lists/{referenceCode}/geocaches/{geocacheReferenceCode}
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/lists/' . $referenceCode . '/geocaches/' . $geocacheCode, $headers);
    }

    // ==========================================
    // TRACKABLES API
    // ==========================================

    /**
     * Delete trackable log.
     * DELETE /v1/trackablelogs/{referenceCode}
     */
    public function deleteTrackableLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/trackablelogs/' . $referenceCode, $headers);
    }

    /**
     * Get trackable log.
     * GET /v1/trackablelogs/{referenceCode}
     */
    public function getTrackableLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackablelogs/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Update trackable log.
     * PUT /v1/trackablelogs/{referenceCode}
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->put('/trackablelogs/' . $referenceCode . $queryString, $headers, $this->encodeJson($trackableLog));
    }

    /**
     * Get user trackable logs.
     * GET /v1/trackablelogs
     */
    public function getUserTrackableLog(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackablelogs' . $queryString, $headers);
    }

    /**
     * Get trackable log images.
     * GET /v1/trackablelogs/{referenceCode}/images
     */
    public function getTrackableLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackablelogs/' . $referenceCode . '/images' . $queryString, $headers);
    }

    /**
     * Set trackable log images.
     * POST /v1/trackablelogs/{referenceCode}/images
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/trackablelogs/' . $referenceCode . '/images' . $queryString, $headers, $this->encodeJson($imageToUpload));
    }

    /**
     * Delete trackable log image.
     * DELETE /v1/trackablelogs/{referenceCode}/images/{imageGuid}
     */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/trackablelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }

    /**
     * Set trackable log.
     * POST /v1/trackablelogs
     */
    public function setTrackableLog(array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/trackablelogs' . $queryString, $headers, $this->encodeJson($trackableLog));
    }

    /**
     * Get trackable.
     * GET /v1/trackables/{referenceCode}
     */
    public function getTrackable(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Get user trackables.
     * GET /v1/trackables
     */
    public function getUserTrackables(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables' . $queryString, $headers);
    }

    /**
     * Get trackable journeys.
     * GET /v1/trackables/{referenceCode}/journeys
     */
    public function getTrackableJourneys(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables/' . $referenceCode . '/journeys' . $queryString, $headers);
    }

    /**
     * Get geocoin types.
     * GET /v1/trackables/geocointypes
     */
    public function getGeocoinTypes(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables/geocointypes' . $queryString, $headers);
    }

    /**
     * Get trackable images.
     * GET /v1/trackables/{referenceCode}/images
     */
    public function getTrackableImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables/' . $referenceCode . '/images' . $queryString, $headers);
    }

    /**
     * Get trackable logs.
     * GET /v1/trackables/{referenceCode}/trackablelogs
     */
    public function getTrackableLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/trackables/' . $referenceCode . '/trackablelogs' . $queryString, $headers);
    }

    // ==========================================
    // LOG DRAFTS API
    // ==========================================

    /**
     * Delete log draft.
     * DELETE /v1/logdrafts/{referenceCode}
     */
    public function deleteLogdraft(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/logdrafts/' . $referenceCode, $headers);
    }

    /**
     * Get log draft.
     * GET /v1/logdrafts/{referenceCode}
     */
    public function getLogdraft(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/logdrafts/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Update log draft.
     * PUT /v1/logdrafts/{referenceCode}
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->put('/logdrafts/' . $referenceCode . $queryString, $headers, $this->encodeJson($logDraft));
    }

    /**
     * Get log drafts.
     * GET /v1/logdrafts
     */
    public function getLogdrafts(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/logdrafts' . $queryString, $headers);
    }

    /**
     * Set log draft.
     * POST /v1/logdrafts
     */
    public function setLogdraft(array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/logdrafts' . $queryString, $headers, $this->encodeJson($logDraft));
    }

    /**
     * Promote log draft.
     * POST /v1/logdrafts/{referenceCode}/promote
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/logdrafts/' . $referenceCode . '/promote', $headers, $this->encodeJson($logDraft));
    }

    /**
     * Set log draft image.
     * POST /v1/logdrafts/{referenceCode}/images
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->post('/logdrafts/' . $referenceCode . '/images' . $queryString, $headers, $this->encodeJson($postImage));
    }

    /**
     * Delete image from log draft.
     * DELETE /v1/logdrafts/{referenceCode}/images/{guid}
     */
    public function deleteImageFromLogdraft(string $referenceCode, string $guid, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/logdrafts/' . $referenceCode . '/images/' . $guid, $headers);
    }

    // ==========================================
    // USER WAYPOINTS API
    // ==========================================

    /**
     * Get user waypoints.
     * GET /v1/userwaypoints
     */
    public function getUserWaypoints(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/userwaypoints' . $queryString, $headers);
    }

    /**
     * Set geocache user waypoint.
     * POST /v1/userwaypoints
     */
    public function setGeocacheUserWaypoint(array $body, array $headers = []): ResponseInterface
    {
        return $this->httpClient->post('/userwaypoints', $headers, $this->encodeJson($body));
    }

    /**
     * Delete user waypoint.
     * DELETE /v1/userwaypoints/{referenceCode}
     */
    public function deleteUserWaypoint(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->httpClient->delete('/userwaypoints/' . $referenceCode, $headers);
    }

    /**
     * Update user waypoint.
     * PUT /v1/userwaypoints/{referenceCode}
     */
    public function updateUserWaypoint(string $referenceCode, array $waypoint, array $headers = []): ResponseInterface
    {
        return $this->httpClient->put('/userwaypoints/' . $referenceCode, $headers, $this->encodeJson($waypoint));
    }

    // ==========================================
    // REFERENCE DATA API
    // ==========================================

    /**
     * Get reference code from ID.
     * GET /v1/utilities/referencecode
     */
    public function getReferenceCodeFromId(array $query, array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/utilities/referencecode' . $queryString, $headers);
    }

    /**
     * Get countries.
     * GET /v1/countries
     */
    public function getCountries(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/countries', $headers);
    }

    /**
     * Get states.
     * GET /v1/states
     */
    public function getStates(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/states', $headers);
    }

    /**
     * Get states by country.
     * GET /v1/countries/{countryId}/states
     */
    public function getStatesByCountry(int $countryId, array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/countries/' . $countryId . '/states', $headers);
    }

    /**
     * Get membership levels.
     * GET /v1/membershiplevels
     */
    public function getMembershipLevels(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/membershiplevels', $headers);
    }

    /**
     * Get geocache types.
     * GET /v1/geocachetypes
     */
    public function getGeocacheTypes(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/geocachetypes', $headers);
    }

    /**
     * Get attributes.
     * GET /v1/attributes
     */
    public function getAttributes(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/attributes', $headers);
    }

    /**
     * Get geocache sizes.
     * GET /v1/geocachesizes
     */
    public function getGeocacheSizes(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/geocachesizes', $headers);
    }

    /**
     * Get geocache statuses.
     * GET /v1/geocachestatuses
     */
    public function getGeocacheStatuses(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/geocachestatuses', $headers);
    }

    /**
     * Get geocache log types.
     * GET /v1/geocachelogtypes
     */
    public function getGeocacheLogTypes(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/geocachelogtypes', $headers);
    }

    /**
     * Get trackable log types.
     * GET /v1/trackablelogtypes
     */
    public function getTrackableLogTypes(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/trackablelogtypes', $headers);
    }

    // ==========================================
    // STATISTICS API
    // ==========================================

    /**
     * Get difficulty/terrain statistics.
     * GET /v1/statistics/difficultyterrain
     */
    public function getDifficultyTerrainStatistics(array $headers = []): ResponseInterface
    {
        return $this->httpClient->get('/statistics/difficultyterrain', $headers);
    }

    // ==========================================
    // STATUS API
    // ==========================================

    /**
     * Ping status endpoint.
     * GET /status/ping
     */
    public function ping(): ResponseInterface
    {
        // Status endpoint needs special handling - using absolute URL to bypass auth
        $baseUri = $this->clientBuilder->getBaseUri();
        $statusClient = $this->createStatusHttpClient();
        return $statusClient->get($baseUri . '/status/ping');
    }

    /**
     * Get API status.
     * GET /status/ping
     */
    public function status(): ResponseInterface
    {
        return $this->ping();
    }

    /**
     * Create HTTP client for status endpoints with logging but without auth/BaseUri plugins.
     */
    private function createStatusHttpClient(): HttpMethodsClientInterface
    {
        $rawHttpClient = \Http\Discovery\Psr18ClientDiscovery::find();
        $reflection = new \ReflectionClass($this->clientBuilder);
        $pluginsProperty = $reflection->getProperty('plugins');
        $pluginsProperty->setAccessible(true);
        $allPlugins = $pluginsProperty->getValue($this->clientBuilder);
        
        $statusPlugins = [];
        foreach ($allPlugins as $plugin) {
            if (!$plugin instanceof \Http\Client\Common\Plugin\AuthenticationPlugin &&
                !$plugin instanceof \Http\Client\Common\Plugin\BaseUriPlugin) {
                $statusPlugins[] = $plugin;
            }
        }
        
        $pluginClient = (new \Http\Client\Common\PluginClientFactory())->createClient($rawHttpClient, $statusPlugins);
        
        $requestFactory = $reflection->getProperty('requestFactory');
        $requestFactory->setAccessible(true);
        $streamFactory = $reflection->getProperty('streamFactory');
        $streamFactory->setAccessible(true);
        
        return new \Http\Client\Common\HttpMethodsClient(
            $pluginClient,
            $requestFactory->getValue($this->clientBuilder),
            $streamFactory->getValue($this->clientBuilder)
        );
    }

    // ==========================================
    // WHERIGO API
    // ==========================================

    /**
     * Get Wherigo cartridge.
     * GET /v1/wherigo/{guid}/cartridge
     */
    public function getWherigoCartridge(string $guid, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/wherigo/' . $guid . '/cartridge' . $queryString, $headers);
    }

    // ==========================================
    // GEOTOURS API
    // ==========================================

    /**
     * Get geotours.
     * GET /v1/geotours
     */
    public function getGeotours(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geotours' . $queryString, $headers);
    }

    /**
     * Get geotour.
     * GET /v1/geotours/{referenceCode}
     */
    public function getGeotour(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geotours/' . $referenceCode . $queryString, $headers);
    }

    /**
     * Get geotour geocaches.
     * GET /v1/geotours/{referenceCode}/geocaches
     */
    public function getGeotourGeocaches(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/geotours/' . $referenceCode . '/geocaches' . $queryString, $headers);
    }

    // ==========================================
    // HQ PROMOTIONS API
    // ==========================================

    /**
     * Get HQ promotions metadata.
     * GET /v1/HQPromotions/metadata
     */
    public function getHQPromotionsMetadata(array $query = [], array $headers = []): ResponseInterface
    {
        $queryString = $this->buildQueryString($query);
        return $this->httpClient->get('/HQPromotions/metadata' . $queryString, $headers);
    }
}
