<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-api
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

use Geocaching\Lib\Adapters\HttpClientInterface;
use Geocaching\Lib\Adapters\GuzzleHttpClient;

/**
 * List of methods from Groundspeak API.
 *
 * @see    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @see    https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see    https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingSdk implements GeocachingSdkInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * swagger: GET /v{api-version}/friends
     * 
     * @see https://api.groundspeak.com/documentation#get-friends
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriends
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getFriends(array $query = [])
    {
        return $this->httpClient->get('friends', $query);
    }

    /**
     * swagger: GET /v{api-version}/friendrequests
     * 
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriendRequests
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getFriendRequests(array $query = [])
    {
        return $this->httpClient->get('friendrequests', $query);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests
     * 
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_CreateFriendRequest
     *
     * @param array $friendRequest
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function sendFriendRequest(array $friendRequest, array $query = [])
    {
        return $this->httpClient->post('friendrequests', $friendRequest, $query);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests/{requestId}/accept
     * 
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_AcceptFriendRequest
     *
     * @param string $requestId
     *
     * @return GuzzleHttpClient
     */
    public function acceptFriendRequest(string $requestId)
    {
        return $this->httpClient->post('friendrequests/' . $requestId . '/accept');
    }

    /**
     * swagger: DELETE /v{api-version}/friends/{userCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-friend
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_RemoveFriend
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteFriend(string $referenceCode)
    {
        return $this->httpClient->delete('friends/' . $referenceCode);
    }

    /**
     * swagger: DELETE /v{api-version}/friendrequests/{requestId}
     * 
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_DeleteFriendRequest
     *
     * @param string $requestId
     *
     * @return GuzzleHttpClient
     */
    public function deleteFriendRequest(string $requestId)
    {
        return $this->httpClient->delete('friendrequests/' . $requestId);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteGeocacheLog
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheLog(string $referenceCode)
    {
        return $this->httpClient->delete('geocachelogs/' . $referenceCode);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetGeocacheLog
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLog(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocachelogs/' . $referenceCode, $query);
    }

    /**
     * swagger: PUT /v{api-version}/geocachelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_Put
     *
     * @param string $referenceCode
     * @param array  $geocacheLog
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [])
    {
        return $this->httpClient->put('geocachelogs/' . $referenceCode, $geocacheLog, $query);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetImages
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocachelogs/' . $referenceCode . '/images', $query);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs/{referenceCode}/images 
     * 
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostImages
     *
     * @param string $referenceCode
     * @param array  $imageToUpload
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [])
    {
        return $this->httpClient->post('geocachelogs/' . $referenceCode . '/images', $imageToUpload, $query);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs
     * 
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostLog
     *
     * @param array $geocacheLog
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [])
    {
        return $this->httpClient->post('geocachelogs', $geocacheLog, $query);
    }

    /**
     * swagger: DELETE /v{api-version}/geocaches/{referenceCode}/notes
     * 
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheNote(string $referenceCode)
    {
        return $this->httpClient->delete('geocaches/' . $referenceCode . '/notes');
    }

    /**
     * swagger: PUT /v{api-version}/geocaches/{referenceCode}/notes
     * 
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_Delete
     *
     * @param string $referenceCode
     * @param array $note
     *
     * @return GuzzleHttpClient
     */
    public function updateGeocacheNote(string $referenceCode, array $note)
    {
        return $this->httpClient->put('geocaches/' . $referenceCode . '/notes', $note);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Get
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocache(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode, $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetImages
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/images', $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/trackables
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_UpsertGeocacheNoteAsync
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/trackables', $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches
     * 
     * @see https://api.groundspeak.com/documentation#get-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetGeocaches
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocaches(array $query)
    {
        return $this->httpClient->get('geocaches', $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/geocachelogs
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetLogs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogs(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/geocachelogs', $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/search
     * 
     * @see https://api.groundspeak.com/documentation#search
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Search
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function searchGeocaches(array $query)
    {
        return $this->httpClient->get('geocaches/search', $query);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#remove-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveGeocache
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteList(string $referenceCode)
    {
        return $this->httpClient->delete('lists/' . $referenceCode);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetList
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getList(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode, $query);
    }

    /**
     * swagger: PUT /v{api-version}/lists/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#update-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_UpdateList
     *
     * @param string $referenceCode
     * @param array  $list
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateList(string $referenceCode, array $list, array $query = [])
    {
        return $this->httpClient->put('lists/' . $referenceCode, $list, $query);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches/zipped
     * 
     * @see https://api.groundspeak.com/documentation#get-pq-zip
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetZippedPocketQuery
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function getZippedPocketQuery(string $referenceCode)
    {
        return $this->httpClient->get('lists/' . $referenceCode . '/geocaches/zipped');
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches
     * 
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetGeocaches
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheList(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode . '/geocaches', $query);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/geocaches
     * 
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocache
     *
     * @param string $referenceCode
     * @param array  $geocache
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [])
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/geocaches', $geocache, $query);
    }

    /**
     * swagger: POST /v{api-version}/lists
     * 
     * @see https://api.groundspeak.com/documentation#create-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_PostList
     *
     * @param array $list
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setList(array $list, array $query = [])
    {
        return $this->httpClient->post('lists', $list, $query);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/bulkgeocaches
     * 
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocaches
     *
     * @param string $referenceCode
     * @param array  $body
     *
     * @return GuzzleHttpClient
     */
    public function setBulkGeocachesList(string $referenceCode, array $body)
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/bulkgeocaches', $body);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}/geocaches/{geocacheReferenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveList
     *
     * @param string $referenceCode
     * @param string $geocacheCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode)
    {
        return $this->httpClient->delete('lists/' . $referenceCode . '/geocaches/' . $geocacheCode);
    }

    /**
     * swagger: DELETE /v{api-version}/logdrafts/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Delete
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteLogdraft(string $referenceCode)
    {
        return $this->httpClient->delete('logdrafts/' . $referenceCode);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Get
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getLogdraft(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('logdrafts/' . $referenceCode, $query);
    }

    /**
     * swagger: PUT /v{api-version}/logdrafts/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#update-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Put
     *
     * @param string $referenceCode
     * @param array  $logDraft
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [])
    {
        return $this->httpClient->put('logdrafts/' . $referenceCode, $logDraft, $query);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts
     * 
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_GetUserDrafts
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getLogdrafts(array $query = [])
    {
        return $this->httpClient->get('logdrafts', $query);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts
     * 
     * @see https://api.groundspeak.com/documentation#create-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post
     *
     * @param array $logDraft
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setLogdraft(array $logDraft, array $query = [])
    {
        return $this->httpClient->post('logdrafts', $logDraft, $query);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/logdrafts
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache-logdrafts
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_GetGeocacheDrafts
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogdrafts(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/logdrafts', $query);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/promote
     * 
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_PromoteToGeocacheLog
     *
     * @param string $referenceCode
     * @param array  $logDraft
     *
     * @return GuzzleHttpClient
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft)
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/promote', $logDraft);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post_0
     *
     * @param string $referenceCode
     * @param array  $postImage
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [])
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/images', $postImage, $query);
    }

    /**
     * swagger: DELETE /v{api-version}/trackablelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_ArchiveTrackableLog
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteTrackableLog(string $referenceCode)
    {
        return $this->httpClient->delete('trackablelogs/' . $referenceCode);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetTrackableLog
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLog(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode, $query);
    }

    /**
     * swagger: PUT /v{api-version}/trackablelogs/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_Put
     *
     * @param string $referenceCode
     * @param array  $trackableLog
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [])
    {
        return $this->httpClient->put('trackablelogs/' . $referenceCode, $trackableLog, $query);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetImages
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLogImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode . '/images', $query);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostImages
     *
     * @param string $referenceCode
     * @param array  $imageToUpload
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [])
    {
        return $this->httpClient->post('trackablelogs/' . $referenceCode . '/images', $imageToUpload, $query);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs
     * 
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostLog
     *
     * @param array $trackableLog
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setTrackableLog(array $trackableLog, array $query = [])
    {
        return $this->httpClient->post('trackablelogs', $trackableLog, $query);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-trackable
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetTrackable
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackable(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode, $query);
    }

    /**
     * swagger: GET /v{api-version}/trackables
     * 
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetUserTrackables
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserTrackables(array $query = [])
    {
        return $this->httpClient->get('trackables', $query);
    }

    /**
     * swagger: GET /v{api-version}/trackables/geocointypes
     * 
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetGeocoinTypes
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocoinTypes(array $query = [])
    {
        return $this->httpClient->get('trackables/geocointypes', $query);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/Images
     * 
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetImages
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/images', $query);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/trackablelogs
     * 
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetLogs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLogs(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/trackablelogs', $query);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#get-user
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUser
     *
     * @param string $referenceCode
     * @param string $query
     *
     * @return GuzzleHttpClient
     */
    public function getUser(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('users/' . $referenceCode, $query);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/images
     * 
     * @see https://api.groundspeak.com/documentation#get-user-images
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetImages
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/images', $query);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/souvenirs
     * 
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetSouvenirs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserSouvenirs(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/souvenirs', $query);
    }

    /**
     * swagger: GET /v{api-version}/users
     * 
     * @see https://api.groundspeak.com/documentation#get-users
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUsers
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUsers(array $query = [])
    {
        return $this->httpClient->get('users', $query);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/lists
     * 
     * @see https://api.groundspeak.com/documentation#get-lists
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetLists
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserLists(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/lists', $query);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/geocachelogs
     * 
     * @see https://api.groundspeak.com/documentation#get-user-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetGeocacheLogs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/geocachelogs', $query);
    }

    /**
     * swagger: POST /v{api-version}/_users/{username}/validate
     * 
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_ValidateUserAsync
     * 
     * @param string $username
     * @param array $body
     * @param array $options
     * 
     * @return GuzzleHttpClient
     */
    public function validateUser(string $username, array $body)
    {
        $options['form_params'] = $body;
        return $this->httpClient->post('_users/' . $username . '/validate', [], [], $options);
    }

    /**
     * swagger: GET /v{api-version}/userwaypoints
     * 
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetUserWaypointsAsync
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserWaypoints(array $query = [])
    {
        return $this->httpClient->get('userwaypoints', $query);
    }

    /**
     * swagger: POST /v{api-version}/userwaypoints
     * 
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Post
     *
     * @param array $body
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $body)
    {
        return $this->httpClient->post('userwaypoints', $body);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/userwaypoints
     * 
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetGeocacheUserWaypointsAsync
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/userwaypoints', $query);
    }

    /**
     * swagger: DELETE /v{api-version}/userwaypoints/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Delete
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteUserWaypoint(string $referenceCode)
    {
        return $this->httpClient->delete('userwaypoints/' . $referenceCode);
    }

    /**
     * swagger: PUT /v{api-version}/userwaypoints/{referenceCode}
     * 
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Put
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateUserWaypoint(string $referenceCode, array $query)
    {
        return $this->httpClient->put('userwaypoints/' . $referenceCode, $query);
    }

    /**
     * swagger: GET /v{api-version}/utilities/referencecode
     * 
     * @see https://api.groundspeak.com/documentation#get-reference-code
     * @see https://api.groundspeak.com/api-docs/index#!/Utilities/Utilities_GetReferenceCode
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getReferenceCodeFromId(array $query)
    {
        return $this->httpClient->get('utilities/referencecode', $query);
    }

    /**
     * swagger: GET /status/ping
     *
     * @see https://api.groundspeak.com/api-docs/index#!/Status/Status_PingAsync
     *
     * @return GuzzleHttpClient
     */
    public function ping()
    {
        return $this->httpClient->get('/ping');
    }

    /**
     * alias of ping()
     *
     * @return GuzzleHttpClient
     */
    public function status()
    {
        return $this->ping();
    }
}
