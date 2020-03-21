<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

interface GeocachingSdkInterface
{
    /**
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriendRequests(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function sendFriendRequest(array $friendRequest, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-friends
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriends(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-friend-logs-geocache
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function acceptFriendRequest(string $requestId);

    /**
     * @see https://api.groundspeak.com/documentation#delete-friend
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteFriend(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteFriendRequest(string $requestId);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheLog(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLog(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheLog(array $geocacheLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-image
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheNote(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateGeocacheNote(string $referenceCode, array $note);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocache(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-favoritedby
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocaches(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#search
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function searchGeocaches(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#verify-final-coordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates);

    /**
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geotour
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeotour(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geotours
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeotours(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geotour-geocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocachesGeotour(string $referenceCode, array $query = []);

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getHQPromotions();

    /**
     * @see https://api.groundspeak.com/documentation#remove-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteList(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getList(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateList(string $referenceCode, array $list, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-pq-zip
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getZippedPocketQuery(string $referenceCode, string $dirname);

    /**
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheList(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setList(array $list, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setBulkGeocachesList(string $referenceCode, array $query);

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode);

    /**
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteLogdraft(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-logdraft
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getLogdraft(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-logdraft
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getLogdrafts(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setLogdraft(array $logDraft, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft);

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteTrackableLog(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLog(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-trackablelog-image
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-trackablelog-image
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid);

    /**
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setTrackableLog(array $trackableLog, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackable(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserTrackables(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocoinTypes(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-images
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-user
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUser(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-user-images
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserImages(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserSouvenirs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-users
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUsers(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-lists
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserLists(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-user-logs
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getUserWaypoints(array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = []);

    /**
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteUserWaypoint(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#upsert-correctedcoordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates);

    /**
     * @see https://api.groundspeak.com/documentation#delete-correctedcoordinates
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function deleteCorrectedCoordinates(string $referenceCode);

    /**
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint);

    /**
     * @see https://api.groundspeak.com/documentation#get-reference-code
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getReferenceCodeFromId(array $query);

    /**
     * @see https://api.groundspeak.com/documentation#get-countries
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getCountries();

    /**
     * @see https://api.groundspeak.com/documentation#get-states
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getStates();

    /**
     * @see https://api.groundspeak.com/documentation#get-country-states
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getStatesByCountry(int $countryId);

    /**
     * @see https://api.groundspeak.com/documentation#get-membership-levels
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getMembershipLevels();

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-types
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheTypes();

    /**
     * @see https://api.groundspeak.com/documentation#get-attributes
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getAttributes();

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-types
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getGeocacheLogTypes();

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-types
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function getTrackableLogTypes();

    /**
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
     */
    public function ping();
}
