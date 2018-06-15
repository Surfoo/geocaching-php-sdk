<?php

namespace Geocaching\Api;

interface GeocachingApiInterface
{
    /**
     * @link https://api.groundspeak.com/documentation#search
     *
     * @param array $params
     * @return stdClass
     */
    public function searchGeocaches(array $params);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocache(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocaches
     *
     * @param array $params
     * @return stdClass
     */
    public function getGeocaches(array $params);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheImages(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#upsert-geocachenote
     *
     * @param string $referenceCode
     * @param string $note
     * @return stdClass
     */
    public function setGeocacheNote(string $referenceCode, string $note);

    /**
     * @link https://api.groundspeak.com/documentation#delete-geocachenote
     *
     * @param string $referenceCode
     * @param string $note
     * @return stdClass
     */
    public function deleteGeocacheNote(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogs(string $referenceCode, array $params = []);


    /**
     * @link https://api.groundspeak.com/documentation#get-geocachelog
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLog(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-geocachelog
     *
     * @param array $geocacheLog
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheLog(array $geocacheLog, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#update-geocachelog
     *
     * @param string $referenceCode
     * @param array $geocacheLog
     * @param array $params
     * @return stdClass
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#delete-geocachelog
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteGeocacheLog(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocachelog-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogImages(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-geocachelog-image
     *
     * @param string $referenceCode
     * @param array $imageToUpload
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $params = []);
    
    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-trackables
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheTrackables(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-trackable
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackables(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-users-trackables
     *
     * @param array $params
     * @return stdClass
     */
    public function getUserTrackables(array $params);

    /**
     * @link
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableImages(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-trackable-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLogs(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLog(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-trackablelog
     *
     * @param array $trackableLog
     * @param array $params
     * @return stdClass
     */
    public function setTrackableLog(array $trackableLog, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#update-trackablelog
     *
     * @param string $referenceCode
     * @param array $trackableLog
     * @param array $params
     * @return stdClass
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#delete-trackablelog
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteTrackableLog(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getTrackableLogImages(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array $imageToUpload
     * @param array $params
     * @return stdClass
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-logdrafts
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheLogdrafts(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-logdrafts
     *
     * @param array $params
     * @return stdClass
     */
    public function getLogdrafts(array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-logdraft
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getLogdraft(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-logdraft
     *
     * @param array $logDraft
     * @param array $params
     * @return stdClass
     */
    public function setLogdraft(array $logDraft, array $params = []);
    
    /**
     * @link https://api.groundspeak.com/documentation#update-logdraft
     *
     * @param string $referenceCode
     * @param array $logDraft
     * @param array $params
     * @return stdClass
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#delete-logdraft
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteLogdraft(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#promote-logdraft
     *
     * @param string $referenceCode
     * @param array $logDraft
     * @return stdClass
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft);

    /**
     * @link https://api.groundspeak.com/documentation#create-logdraft-image
     *
     * @param string $referenceCode
     * @param array $postImage
     * @param array $params
     * @return stdClass
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-userwaypoints
     *
     * @param array $params
     * @return stdClass
     */
    public function getUserWaypoints(array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-userwaypoint
     *
     * @param string $referenceCode
     * @param array $userWaypoint
     * @return stdClass
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @link https://api.groundspeak.com/documentation#update-userwaypoint
     *
     * @param string $referenceCode
     * @param array $userWaypoint
     * @return stdClass
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @link https://api.groundspeak.com/documentation#delete-userwaypoint
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteUserWaypoint(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-list
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getList(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-list
     *
     * @param array $list
     * @param array $params
     * @return stdClass
     */
    public function setList(array $list, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#update-list
     *
     * @param string $referenceCode
     * @param array $list
     * @param array $params
     * @return stdClass
     */
    public function updateList(string $referenceCode, array $list, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#remove-list
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteList(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-list-geocaches
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getGeocacheList(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#add-geocache-list
     *
     * @param string $referenceCode
     * @param array $geocache
     * @param array $params
     * @return stdClass
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#add-geocaches-list
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function setBulkGeocachesList(string $referenceCode, array $params);
    
    /**
     * @link https://api.groundspeak.com/documentation#delete-geocache-list
     *
     * @param string $referenceCode
     * @param string $geocacheCode
     * @return stdClass
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-user
     *
     * @param string $referenceCode
     * @param string $params
     * @return stdClass
     */
    public function getUser(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-users
     *
     * @param array $params
     * @return stdClass
     */
    public function getUsers(array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-user-logs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserGeocacheLogs(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-lists
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserLists(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-souvenirs
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserSouvenirs(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-user-images
     *
     * @param string $referenceCode
     * @param array $params
     * @return stdClass
     */
    public function getUserImages(string $referenceCode, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-friends
     *
     * @param array $params
     * @return stdClass
     */
    public function getFriends(array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#get-friendrequests
     *
     * @param array $params
     * @return stdClass
     */
    public function getFriendRequests(array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#create-friendrequest
     *
     * @param array $friendRequest
     * @param array $params
     * @return stdClass
     */
    public function sendFriendRequest(array $friendRequest, array $params = []);

    /**
     * @link https://api.groundspeak.com/documentation#accept-friendrequest
     *
     * @param string $requestId
     * @return stdClass
     */
    public function acceptFriendRequest(string $requestId);

    /**
     * @link https://api.groundspeak.com/documentation#delete-friendrequest
     *
     * @param string $requestId
     * @return stdClass
     */
    public function deleteFriendRequest(string $requestId);

    /**
     * @link https://api.groundspeak.com/documentation#delete-friend
     *
     * @param string $referenceCode
     * @return stdClass
     */
    public function deleteFriend(string $referenceCode);

    /**
     * @link https://api.groundspeak.com/documentation#get-reference-code
     *
     * @param array $params
     * @return stdClass
     */
    public function getReferenceCodeFromId(array $params);

    /**
     * @return bool
     */
    public function ping(): bool;
}
