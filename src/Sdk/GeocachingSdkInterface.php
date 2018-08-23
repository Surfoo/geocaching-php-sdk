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

interface GeocachingSdkInterface
{
    /**
     * @see https://api.groundspeak.com/documentation#search
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function searchGeocaches(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocache(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocaches
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocaches(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     *
     * @param string $referenceCode
     * @param array $note
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheNote(string $referenceCode, array $note);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     *
     * @param string $referenceCode
     * @param string $note
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheNote(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLog(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     *
     * @param array $geocacheLog
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLog(array $geocacheLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     *
     * @param string $referenceCode
     * @param array  $geocacheLog
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheLog(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     *
     * @param string $referenceCode
     * @param array  $imageToUpload
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackables(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserTrackables(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocoinTypes(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLog(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     *
     * @param array $trackableLog
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setTrackableLog(array $trackableLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     *
     * @param string $referenceCode
     * @param array  $trackableLog
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteTrackableLog(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getTrackableLogImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @param string $referenceCode
     * @param array  $imageToUpload
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-logdrafts
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheLogdrafts(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getLogdrafts(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-logdraft
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getLogdraft(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft
     *
     * @param array $logDraft
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setLogdraft(array $logDraft, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-logdraft
     *
     * @param string $referenceCode
     * @param array  $logDraft
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteLogdraft(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     *
     * @param string $referenceCode
     * @param array  $logDraft
     *
     * @return GuzzleHttpClient
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft);

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     *
     * @param string $referenceCode
     * @param array  $postImage
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserWaypoints(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     *
     * @param string $referenceCode
     * @param array  $userWaypoint
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     *
     * @param string $referenceCode
     * @param array  $userWaypoint
     *
     * @return GuzzleHttpClient
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteUserWaypoint(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-list
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getList(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-list
     *
     * @param array $list
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function setList(array $list, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-list
     *
     * @param string $referenceCode
     * @param array  $list
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function updateList(string $referenceCode, array $list, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#remove-list
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteList(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getGeocacheList(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     *
     * @param string $referenceCode
     * @param array  $geocache
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function setBulkGeocachesList(string $referenceCode, array $query);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     *
     * @param string $referenceCode
     * @param string $geocacheCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-user
     *
     * @param string $referenceCode
     * @param string $query
     *
     * @return GuzzleHttpClient
     */
    public function getUser(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-users
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getUsers(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-user-logs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-lists
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserLists(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserSouvenirs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-user-images
     *
     * @param string $referenceCode
     * @param array  $query
     *
     * @return GuzzleHttpClient
     */
    public function getUserImages(string $referenceCode, array $query = []);


    /**
     * @see https://api.groundspeak.com/documentation#get-friends
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getFriends(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getFriendRequests(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     *
     * @param array $friendRequest
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function sendFriendRequest(array $friendRequest, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     *
     * @param string $requestId
     *
     * @return GuzzleHttpClient
     */
    public function acceptFriendRequest(string $requestId);

    /**
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     *
     * @param string $requestId
     *
     * @return GuzzleHttpClient
     */
    public function deleteFriendRequest(string $requestId);

    /**
     * @see https://api.groundspeak.com/documentation#delete-friend
     *
     * @param string $referenceCode
     *
     * @return GuzzleHttpClient
     */
    public function deleteFriend(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-reference-code
     *
     * @param array $query
     *
     * @return GuzzleHttpClient
     */
    public function getReferenceCodeFromId(array $query);

    /**
     * @return int
     */
    public function ping();
}
