<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

use Geocaching\Lib\Adapters\HttpClientInterface;

/**
 * List of methods from Groundspeak API.
 *
 * @see https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingSdk implements GeocachingSdkInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * swagger: GET /v{api-version}/friendrequests
     *
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriendRequests
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriendRequests(array $query = [], array $options = [])
    {
        return $this->httpClient->get('friendrequests', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests
     *
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_CreateFriendRequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function sendFriendRequest(array $friendRequest, array $query = [], array $options = [])
    {
        return $this->httpClient->post('friendrequests', $friendRequest, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/friends
     *
     * @see https://api.groundspeak.com/documentation#get-friends
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriends
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriends(array $query = [], array $options = [])
    {
        return $this->httpClient->get('friends', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/friends/geocaches/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriendsGeocacheLogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('friends/geocaches/' . $referenceCode . '/geocachelogs', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests/{requestId}/accept
     *
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_AcceptFriendRequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function acceptFriendRequest(string $requestId, array $options = [])
    {
        return $this->httpClient->post('friendrequests/' . $requestId . '/accept', $options);
    }

    /**
     * swagger: DELETE /v{api-version}/friends/{userCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-friend
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_RemoveFriend
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteFriend(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('friends/' . $referenceCode, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/friendrequests/{requestId}
     *
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_DeleteFriendRequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteFriendRequest(string $requestId, array $options = [])
    {
        return $this->httpClient->delete('friendrequests/' . $requestId, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteGeocacheLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheLog(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('geocachelogs/' . $referenceCode, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetGeocacheLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLog(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocachelogs/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: PUT /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_Put
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $options = [])
    {
        return $this->httpClient->put('geocachelogs/' . $referenceCode, $geocacheLog, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocachelogs/' . $referenceCode . '/images', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $options = [])
    {
        return $this->httpClient->post('geocachelogs/' . $referenceCode . '/images', $imageToUpload, $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [], array $options = [])
    {
        return $this->httpClient->post('geocachelogs', $geocacheLog, $query, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}/images/{imageGuid}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteGeocacheLogImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $options = [])
    {
        return $this->httpClient->delete('geocachelogs/' . $referenceCode . '/images/' . $imageGuid, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/geocaches/{referenceCode}/notes
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_DeleteNote
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheNote(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('geocaches/' . $referenceCode . '/notes', $options);
    }

    /**
     * swagger: PUT /v{api-version}/geocaches/{referenceCode}/notes
     *
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_Delete
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateGeocacheNote(string $referenceCode, array $note, array $options = [])
    {
        return $this->httpClient->put('geocaches/' . $referenceCode . '/notes', $note, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geocache
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Get
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocache(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheImages(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/images', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/favoritedby
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-favoritedby
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetFavoritedBy
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/favoritedby', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetGeocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocaches(array $query, array $options = [])
    {
        return $this->httpClient->get('geocaches', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/trackables
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_UpsertNote
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/trackables', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetLogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogs(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/geocachelogs', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/search
     *
     * @see https://api.groundspeak.com/documentation#search
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Search
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function searchGeocaches(array $query, array $options = [])
    {
        return $this->httpClient->get('geocaches/search', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/geocaches/{referenceCode}/finalcoordinates
     *
     * @see https://api.groundspeak.com/documentation#verify-final-coordinates
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_CheckFinalCoordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $options = [])
    {
        return $this->httpClient->post('geocaches/' . $referenceCode . '/finalcoordinates', $coordinates, $options);
    }

    /**
     * swagger: POST /v{api-version}/geocaches/{referenceCode}/bulktrackablelogs
     *
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_BulkCreateTrackableLogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $options = [])
    {
        return $this->httpClient->post('geocaches/' . $referenceCode . '/bulktrackablelogs', $logs, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geotours/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geotour
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeoTour
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeotour(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geotours/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geotours
     *
     * @see https://api.groundspeak.com/documentation#get-geotours
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeoTours
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeotours(array $query = [], array $options = [])
    {
        return $this->httpClient->get('geotours', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/geotours/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-geotour-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeocachesByGeoTour
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocachesGeotour(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geotours/' . $referenceCode . '/geocaches', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/HQPromotions/metadata
     *
     * @see https://api.groundspeak.com/api-docs/index#!/HQPromotions/HQPromotions_Get
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getHQPromotions(array $options = [])
    {
        return $this->httpClient->get('HQPromotions/metadata', $options);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#remove-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveGeocache
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteList(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('lists/' . $referenceCode, $options);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetList
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getList(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: PUT /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_UpdateList
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateList(string $referenceCode, array $list, array $query = [], array $options = [])
    {
        return $this->httpClient->put('lists/' . $referenceCode, $list, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches/zipped
     *
     * @see https://api.groundspeak.com/documentation#get-pq-zip
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetZippedPocketQuery
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $options = [])
    {
        $fullAbsolutePath = sprintf('%s/%s.zip', $dirname, $referenceCode);
        $options          = array_merge($options, ['sink' => $fullAbsolutePath]);

        return $this->httpClient->get('lists/' . $referenceCode . '/geocaches/zipped', [], $options);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetGeocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheList(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode . '/geocaches', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocache
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $options = [])
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/geocaches', $geocache, $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/lists
     *
     * @see https://api.groundspeak.com/documentation#create-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_PostList
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setList(array $list, array $query = [], array $options = [])
    {
        return $this->httpClient->post('lists', $list, $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/bulkgeocaches
     *
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setBulkGeocachesList(string $referenceCode, array $body, array $options = [])
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/bulkgeocaches', $body, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}/geocaches/{geocacheReferenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveList
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $options = [])
    {
        return $this->httpClient->delete('lists/' . $referenceCode . '/geocaches/' . $geocacheCode, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Delete
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteLogdraft(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('logdrafts/' . $referenceCode, $options);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Get
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getLogdraft(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('logdrafts/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: PUT /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Put
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $options = [])
    {
        return $this->httpClient->put('logdrafts/' . $referenceCode, $logDraft, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts
     *
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_GetUserDrafts
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getLogdrafts(array $query = [], array $options = [])
    {
        return $this->httpClient->get('logdrafts', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts
     *
     * @see https://api.groundspeak.com/documentation#create-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setLogdraft(array $logDraft, array $query = [], array $options = [])
    {
        return $this->httpClient->post('logdrafts', $logDraft, $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/promote
     *
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_PromoteToGeocacheLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft, array $options = [])
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/promote', $logDraft, $options);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post_0
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $options = [])
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/images', $postImage, $query, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_ArchiveTrackableLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteTrackableLog(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('trackablelogs/' . $referenceCode, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetTrackableLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLog(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: PUT /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_Put
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $options = [])
    {
        return $this->httpClient->put('trackablelogs/' . $referenceCode, $trackableLog, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogImages(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode . '/images', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $options = [])
    {
        return $this->httpClient->post('trackablelogs/' . $referenceCode . '/images', $imageToUpload, $query, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/trackablelogs/{referenceCode}/images/{imageGuid}
     *
     * @see https://api.groundspeak.com/documentation#delete-trackablelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_DeleteTrackableLogImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $options = [])
    {
        return $this->httpClient->delete('trackablelogs/' . $referenceCode . '/images/' . $imageGuid, $options);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs
     *
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostLog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setTrackableLog(array $trackableLog, array $query = [], array $options = [])
    {
        return $this->httpClient->post('trackablelogs', $trackableLog, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-trackable
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetTrackable
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackable(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables
     *
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetUserTrackables
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserTrackables(array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/journeys 
     *
     * @see https://api.groundspeak.com/documentation#get-trackable-journeys
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetTrackableJourneys
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableJourneys(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/journeys', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables/geocointypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetGeocoinTypes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocoinTypes(array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables/geocointypes', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/Images
     *
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableImages(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/images', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/trackablelogs
     *
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetLogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogs(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/trackablelogs', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-user
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUser
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUser(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('users/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-user-images
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetImages
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserImages(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/images', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/souvenirs
     *
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetSouvenirs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserSouvenirs(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/souvenirs', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users
     *
     * @see https://api.groundspeak.com/documentation#get-users
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUsers
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUsers(array $query = [], array $options = [])
    {
        return $this->httpClient->get('users', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/lists
     *
     * @see https://api.groundspeak.com/documentation#get-lists
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetLists
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserLists(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/lists', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#get-user-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetGeocacheLogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/geocachelogs', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetUserWaypointsAsync
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserWaypoints(array $query = [], array $options = [])
    {
        return $this->httpClient->get('userwaypoints', $query, $options);
    }

    /**
     * swagger: POST /v{api-version}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Post
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $body, array $options = [])
    {
        return $this->httpClient->post('userwaypoints', $body, $options);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetGeocacheUserWaypointsAsync
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $options = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/userwaypoints', $query, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/userwaypoints/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Delete
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteUserWaypoint(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('userwaypoints/' . $referenceCode, $options);
    }

    /**
     * swagger: PUT /v{api-version}/geocaches/{referenceCode}/correctedcoordinates
     *
     * @see https://api.groundspeak.com/documentation#upsert-correctedcoordinates
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_UpsertCorrectedCoordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $options = [])
    {
        return $this->httpClient->put('geocaches/' . $referenceCode . '/correctedcoordinates', $coordinates, $options);
    }

    /**
     * swagger: DELETE /v{api-version}/geocaches/{referenceCode}/correctedcoordinates
     *
     * @see https://api.groundspeak.com/documentation#delete-correctedcoordinates
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_DeleteCorrectedCoordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteCorrectedCoordinates(string $referenceCode, array $options = [])
    {
        return $this->httpClient->delete('geocaches/' . $referenceCode . '/correctedcoordinates', $options);
    }

    /**
     * swagger: PUT /v{api-version}/userwaypoints/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Put
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateUserWaypoint(string $referenceCode, array $query, array $options = [])
    {
        return $this->httpClient->put('userwaypoints/' . $referenceCode, $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/utilities/referencecode
     *
     * @see https://api.groundspeak.com/documentation#get-reference-code
     * @see https://api.groundspeak.com/api-docs/index#!/Utilities/Utilities_GetReferenceCode
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getReferenceCodeFromId(array $query, array $options = [])
    {
        return $this->httpClient->get('utilities/referencecode', $query, $options);
    }

    /**
     * swagger: GET /v{api-version}/countries
     *
     * @see https://api.groundspeak.com/documentation#get-countries
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetCountries
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getCountries(array $options = [])
    {
        return $this->httpClient->get('countries', $options);
    }

    /**
     * swagger: GET /v{api-version}/states
     *
     * @see https://api.groundspeak.com/documentation#get-states
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetStates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getStates(array $options = [])
    {
        return $this->httpClient->get('states', $options);
    }

    /**
     * swagger: GET /v{api-version}/countries/{countryId}/states
     *
     * @see https://api.groundspeak.com/documentation#get-country-states
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetStatesByCountry
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getStatesByCountry(int $countryId, array $options = [])
    {
        return $this->httpClient->get('countries/' . $countryId . '/states', $options);
    }

    /**
     * swagger: GET /v{api-version}/membershiplevels
     *
     * @see https://api.groundspeak.com/documentation#get-membership-levels
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetMembershipLevels
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getMembershipLevels(array $options = [])
    {
        return $this->httpClient->get('membershiplevels', $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachetypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheTypes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheTypes(array $options = [])
    {
        return $this->httpClient->get('geocachetypes', $options);
    }

    /**
     * swagger: GET /v{api-version}/attributes
     *
     * @see https://api.groundspeak.com/documentation#get-attributes
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetAttributes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getAttributes(array $options = [])
    {
        return $this->httpClient->get('attributes', $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachesizes 
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-sizes
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheSizes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheSizes(array $options = [])
    {
        return $this->httpClient->get('geocachesizes', $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachestatuses 
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-statuses
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheStatuses
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheStatuses(array $options = [])
    {
        return $this->httpClient->get('geocachestatuses', $options);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogtypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheLogTypes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogTypes(array $options = [])
    {
        return $this->httpClient->get('geocachelogtypes', $options);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogtypes
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetTrackableLogTypes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogTypes(array $options = [])
    {
        return $this->httpClient->get('trackablelogtypes', $options);
    }

    /**
     * swagger: GET /v{api-version}/optedoutusers
     *
     * @see https://api.groundspeak.com/documentation#get-opted-out-users
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetOptedOutUsers
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getOptedOutUsers(array $query, array $options = [])
    {
        return $this->httpClient->get('optedoutusers', $query, $options);
    }

    /**
     * swagger: GET /status/ping
     *
     * @see https://api.groundspeak.com/api-docs/index#!/Status/Status_PingAsync
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function ping()
    {
        return $this->httpClient->get('ping');
    }

    /**
     * alias of ping()
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function status()
    {
        return $this->ping();
    }
}
