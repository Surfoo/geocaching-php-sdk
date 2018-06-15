<?php

/**
 * Geocaching API with PHP.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Api;

use Geocaching\Lib\Adapters\HttpClientInterface;
use Geocaching\Lib\Response\Response;
use Geocaching\Api\GeocachingApiInterface;

/**
 * List of methods from Groundspeak API.
 *
 * @link    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @link    https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @link    https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingApi implements GeocachingApiInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    
    /**
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @link https://api.groundspeak.com/documentation#search
     *
     * @param array $params
     * @return stdClass
     */
    public function searchGeocaches(array $params)
    {
        return $this->httpClient->get('geocaches/search', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocache(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode, $params);
    }


    /**
     * @link https://api.groundspeak.com/documentation#get-geocaches
     *
     * @param array $params
     * @return stdClass
     */
    public function getGeocaches(array $params)
    {
        return $this->httpClient->get('geocaches', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheImages(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/images', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#upsert-geocachenote
     *
     * @param string $referenceCode
     * @param string $note
     * @return stdClass
     */
    public function setGeocacheNote(string $referenceCode, string $note)
    {
        return $this->httpClient->put('geocaches/' . $referenceCode . '/notes', [$note]);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-geocachenote
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteGeocacheNote(string $referenceCode)
    {
        return $this->httpClient->delete('geocaches/' . $referenceCode . '/notes');
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogs(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/geocachelogs', $params);
    }


    /**
     * @link https://api.groundspeak.com/documentation#get-geocachelog
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLog(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-geocachelog
     *
     * @param array $geocacheLog
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheLog(array $geocacheLog, array $params = [])
    {
        return $this->httpClient->post('geocacheslogs', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#update-geocachelog
     *
     * @param string $referenceCode
     * @param array $geocacheLog
     * @param array $params
     * @return stdClass
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $params = [])
    {
        return $this->httpClient->put('geocacheslogs/' . $referenceCode, $geocacheLog, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-geocachelog
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteGeocacheLog(string $referenceCode)
    {
        return $this->httpClient->delete('geocacheslogs/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocachelog-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogImages(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode . '/images', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-geocachelog-image
     *
     * @param string $referenceCode
     * @param array $imageToUpload
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $params = [])
    {
        return $this->httpClient->post('geocacheslogs/' . $referenceCode . '/images', $imageToUpload, $params);
    }
    
    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-trackables
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheTrackables(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocacheslogs/' . $referenceCode . '/trackables', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-trackable
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackables(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-users-trackables
     *
     * @param array $params
     * @return stdClass
     */
    public function getUserTrackables(array $params = [])
    {
        return $this->httpClient->get('trackables', $params);
    }

    /**
     * @link
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableImages(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/images', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-trackable-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLogs(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('trackables/' . $referenceCode . '/trackablelogs', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLog(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-trackablelog
     *
     * @param array $trackableLog
     * @param array $params
     * @return stdClass
     */
    public function setTrackableLog(array $trackableLog, array $params = [])
    {
        return $this->httpClient->post('trackablelogs', $trackableLog, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#update-trackablelog
     *
     * @param string $referenceCode
     * @param array $trackableLog
     * @param array $params
     * @return stdClass
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $params = [])
    {
        return $this->httpClient->put('trackablelogs/' . $referenceCode, $trackableLog, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-trackablelog
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteTrackableLog(string $referenceCode)
    {
        return $this->httpClient->delete('trackablelogs/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLogImages(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('trackablelogs/' . $referenceCode . '/images', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array $imageToUpload
     * @param array $params
     * @return stdClass
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $params = [])
    {
        return $this->httpClient->post('trackablelogs/' . $referenceCode . '/images', $imageToUpload, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-logdrafts
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogdrafts(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/logdrafts', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-logdrafts
     *
     * @param array $params
     * @return stdClass
     */
    public function getLogdrafts(array $params = [])
    {
        return $this->httpClient->get('logdrafts', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-logdraft
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getLogdraft(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('logdrafts/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-logdraft
     *
     * @param array $logDraft
     * @param array $params
     * @return stdClass
     */
    public function setLogdraft(array $logDraft, array $params = [])
    {
        return $this->httpClient->post('logdrafts', $logDraft, $params);
    }
    
    /**
     * @link https://api.groundspeak.com/documentation#update-logdraft
     *
     * @param string $referenceCode
     * @param array $logDraft
     * @param array $params
     * @return stdClass
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $params = [])
    {
        return $this->httpClient->put('logdrafts/' . $referenceCode, $logDraft, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-logdraft
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteLogdraft(string $referenceCode)
    {
        return $this->httpClient->delete('logdrafts/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#promote-logdraft
     *
     * @param string $referenceCode
     * @param array $logDraft
     * @return stdClass
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft)
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/promote', $logDraft);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-logdraft-image
     *
     * @param string $referenceCode
     * @param array $postImage
     * @param array $params
     * @return stdClass
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $params = [])
    {
        return $this->httpClient->post('logdrafts/' . $referenceCode . '/images', $postImage, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('geocaches/' . $referenceCode . '/userwaypoints', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-userwaypoints
     *
     * @param array $params
     * @return stdClass
     */
    public function getUserWaypoints(array $params = [])
    {
        return $this->httpClient->get('userwaypoints', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-userwaypoint
     *
     * @param string $referenceCode
     * @param array $userWaypoint
     * @return stdClass
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint)
    {
        return $this->httpClient->post('geocaches/' . $referenceCode . '/userwaypoints', $userWaypoint);
    }

    /**
     * @link https://api.groundspeak.com/documentation#update-userwaypoint
     *
     * @param string $referenceCode
     * @param array $userWaypoint
     * @return stdClass
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint)
    {
        return $this->httpClient->put('userwaypoints/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-userwaypoint
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteUserWaypoint(string $referenceCode)
    {
        return $this->httpClient->delete('userwaypoints/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-list
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getList(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-list
     *
     * @param array $list
     * @param array $params
     * @return stdClass
     */
    public function setList(array $list, array $params = [])
    {
        return $this->httpClient->post('lists', $list, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#update-list
     *
     * @param string $referenceCode
     * @param array $list
     * @param array $params
     * @return stdClass
     */
    public function updateList(string $referenceCode, array $list, array $params = [])
    {
        return $this->httpClient->put('lists/' . $referenceCode, $list, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#remove-list
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteList(string $referenceCode)
    {
        return $this->httpClient->delete('lists/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-list-geocaches
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheList(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('lists/' . $referenceCode . '/geocaches', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#add-geocache-list
     *
     * @param string $referenceCode
     * @param array $geocache
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $params = [])
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/geocaches', $geocache, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#add-geocaches-list
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function setBulkGeocachesList(string $referenceCode, array $params)
    {
        return $this->httpClient->post('lists/' . $referenceCode . '/bulkgeocaches', [], $params);
    }
    
    /**
     * @link https://api.groundspeak.com/documentation#delete-geocache-list
     *
     * @param string $referenceCode
     * @param string $geocacheCode
     * @return stdClass
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode)
    {
        return $this->httpClient->delete('lists/' . $referenceCode . '/geocaches/' . $geocacheCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-user
     *
     * @param string $referenceCode
     * @param string $params
     * @return stdClass
     */
    public function getUser(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('users/' . $referenceCode, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-users
     *
     * @param array $params
     * @return stdClass
     */
    public function getUsers(array $params = [])
    {
        return $this->httpClient->get('users', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-user-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserGeocacheLogs(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/geocachelogs', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-lists
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserLists(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/lists', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-souvenirs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserSouvenirs(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/souvenirs', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-user-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserImages(string $referenceCode, array $params = [])
    {
        return $this->httpClient->get('users/' . $referenceCode . '/images', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-friends
     *
     * @param array $params
     * @return stdClass
     */
    public function getFriends(array $params = [])
    {
        return $this->httpClient->get('friends', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-friendrequests
     *
     * @param array $params
     * @return stdClass
     */
    public function getFriendRequests(array $params = [])
    {
        return $this->httpClient->get('friendrequests', $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#create-friendrequest
     *
     * @param array $friendRequest
     * @param array $params
     * @return stdClass
     */
    public function sendFriendRequest(array $friendRequest, array $params = [])
    {
        return $this->httpClient->post('friendrequests', $friendRequest, $params);
    }

    /**
     * @link https://api.groundspeak.com/documentation#accept-friendrequest
     *
     * @param string $requestId
     * @return stdClass
     */
    public function acceptFriendRequest(string $requestId)
    {
        return $this->httpClient->post('friendrequests/' . $requestId . '/accept');
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-friendrequest
     *
     * @param string $requestId
     * @return stdClass
     */
    public function deleteFriendRequest(string $requestId)
    {
        return $this->httpClient->delete('friendrequests/' . $requestId);
    }

    /**
     * @link https://api.groundspeak.com/documentation#delete-friend
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteFriend(string $referenceCode)
    {
        return $this->httpClient->delete('friends/' . $referenceCode);
    }

    /**
     * @link https://api.groundspeak.com/documentation#get-reference-code
     *
     * @param array $params
     * @return stdClass
     */
    public function getReferenceCodeFromId(array $params)
    {
        return $this->httpClient->get('utilities/referencecode', $params);
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
