<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 *
 * @see    https://github.com/Surfoo/geocaching-api
 *
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

use Geocaching\Lib\Adapters\HttpClientInterface;

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
     * Constructor.
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @see https://api.groundspeak.com/documentation#search
     *
     * @param array $query
     *
     * @return Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function searchGeocaches(array $query)
    {
        return $this->httpClient->get('geocaches/search', $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache
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
     * @see https://api.groundspeak.com/documentation#get-geocaches
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
     * @see https://api.groundspeak.com/documentation#get-geocache-images
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
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     *
     * @param string $referenceCode
     * @param string $note
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheNote(string $referenceCode, string $note)
    {
        return $this->httpClient->put('geocaches/' . $referenceCode . '/notes', [$note]);
    }

    /**
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
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
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
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLog(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode, $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     *
     * @param array $geocacheLog
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [])
    {
        return $this->httpClient->post('geocacheslogs', $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     *
     * @param string $referenceCode
     * @param array  $geocacheLog
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [])
    {
        return $this->httpClient->put('geocacheslogs/' . $referenceCode, $geocacheLog, $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheLog(string $referenceCode)
    {
        return $this->httpClient->delete('geocacheslogs/' . $referenceCode);
    }

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode . '/images', $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     *
     * @param string $referenceCode
     * @param array  $imageToUpload
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [])
    {
        return $this->httpClient->post('geocacheslogs/' . $referenceCode . '/images', $imageToUpload, $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode . '/trackables', $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackables(string $referenceCode, array $query = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode, $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#get-users-trackables
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
     * @see https://api.groundspeak.com/documentation#get-users-trackables
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
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
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
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
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
     * @see https://api.groundspeak.com/documentation#get-trackablelog
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
     * @see https://api.groundspeak.com/documentation#create-trackablelog
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
     * @see https://api.groundspeak.com/documentation#update-trackablelog
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
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
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
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
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
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
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
     * @see https://api.groundspeak.com/documentation#get-geocache-logdrafts
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
     * @see https://api.groundspeak.com/documentation#get-logdrafts
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
     * @see https://api.groundspeak.com/documentation#get-logdraft
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
     * @see https://api.groundspeak.com/documentation#create-logdraft
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
     * @see https://api.groundspeak.com/documentation#update-logdraft
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
     * @see https://api.groundspeak.com/documentation#delete-logdraft
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
     * @see https://api.groundspeak.com/documentation#promote-logdraft
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
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
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
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
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
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
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
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     *
     * @param string $referenceCode
     * @param array  $userWaypoint
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint)
    {
        return $this->httpClient->post('geocaches/' . $referenceCode . '/userwaypoints', $userWaypoint);
    }

    /**
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     *
     * @param string $referenceCode
     * @param array  $userWaypoint
     *
     * @return GuzzleHttpClient
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint)
    {
        return $this->httpClient->put('userwaypoints/' . $referenceCode, $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
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
     * @see https://api.groundspeak.com/documentation#get-list
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
     * @see https://api.groundspeak.com/documentation#create-list
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
     * @see https://api.groundspeak.com/documentation#update-list
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
     * @see https://api.groundspeak.com/documentation#remove-list
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
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
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
     * @see https://api.groundspeak.com/documentation#add-geocache-list
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
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setBulkGeocachesList(string $referenceCode, array $query)
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/bulkgeocaches', [], $query);
    }

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
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
     * @see https://api.groundspeak.com/documentation#get-user
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
     * @see https://api.groundspeak.com/documentation#get-users
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
     * @see https://api.groundspeak.com/documentation#get-user-logs
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
     * @see https://api.groundspeak.com/documentation#get-lists
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
     * @see https://api.groundspeak.com/documentation#get-souvenirs
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
     * @see https://api.groundspeak.com/documentation#get-user-images
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
     * @see https://api.groundspeak.com/documentation#get-friends
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
     * @see https://api.groundspeak.com/documentation#get-friendrequests
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
     * @see https://api.groundspeak.com/documentation#create-friendrequest
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
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
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
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
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
     * @see https://api.groundspeak.com/documentation#delete-friend
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
     * @see https://api.groundspeak.com/documentation#get-reference-code
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
     * @return bool
     */
    public function ping(): bool
    {
        $this->httpClient->get('/ping');

        return true;
    }
}
