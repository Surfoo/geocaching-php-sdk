<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching;

use Psr\Http\Message\ResponseInterface;

interface GeocachingSdkInterface
{
    /**
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Get
     */
    public function getAdventure(string $adventureId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_GetStartLocation
     */
    public function getStartLocationAdventure(string $adventureId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Search
     */
    public function searchAdventures(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     */
    public function getFriendRequests(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     */
    public function sendFriendRequest(array $friendRequest, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-friends
     */
    public function getFriends(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-friend-logs-geocache
     */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     */
    public function acceptFriendRequest(string $requestId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-friend
     */
    public function deleteFriend(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     */
    public function deleteFriendRequest(string $requestId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     */
    public function deleteGeocacheLog(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     */
    public function getGeocacheLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-upvotes
     */
    public function getGeocacheLogUpvotes(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-upvote
     */
    public function deleteGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#add-geocachelog-upvote
     */
    public function setGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-image
     */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     */
    public function deleteGeocacheNote(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     */
    public function updateGeocacheNote(string $referenceCode, array $note, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache
     */
    public function getGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     */
    public function getGeocacheImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-favoritedby
     */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocaches
     */
    public function getGeocaches(array $query, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     */
    public function getGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#search
     */
    public function searchGeocaches(array $query, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#verify-final-coordinates
     */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geotour
     */
    public function getGeotour(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geotours
     */
    public function getGeotours(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geotour-geocaches
     */
    public function getGeocachesGeotour(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     */
    public function getHQPromotions(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#remove-list
     */
    public function deleteList(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-list
     */
    public function getList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#update-list
     */
    public function updateList(string $referenceCode, array $list, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-pq-zip
     */
    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     */
    public function getGeocacheList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-list
     */
    public function setList(array $list, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     */
    public function setBulkGeocachesList(string $referenceCode, array $query, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     */
    public function deleteLogdraft(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-logdraft
     */
    public function getLogdraft(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#update-logdraft
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     */
    public function getLogdrafts(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft
     */
    public function setLogdraft(array $logDraft, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     */
    public function deleteTrackableLog(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     */
    public function getTrackableLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-user-trackablelog
     */
    public function getUserTrackableLog(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     */
    public function getTrackableLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-trackablelog-image
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-trackablelog-image
     */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     */
    public function setTrackableLog(array $trackableLog, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable
     */
    public function getTrackable(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     */
    public function getUserTrackables(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-journeys
     */
    public function getTrackableJourneys(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     */
    public function getGeocoinTypes(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-images
     */
    public function getTrackableImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     */
    public function getTrackableLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-user-privacy-settings
     */
    public function getUserPrivacySettings(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-user
     */
    public function getUser(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-opted-out-users
     */
    public function getOptedOutUsers(array $query, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-user-images
     */
    public function getUserImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     */
    public function getUserSouvenirs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-users
     */
    public function getUsers(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-lists
     */
    public function getUserLists(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-user-logs
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     */
    public function getUserWaypoints(array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $userWaypoint, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     */
    public function deleteUserWaypoint(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#upsert-correctedcoordinates
     */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#delete-correctedcoordinates
     */
    public function deleteCorrectedCoordinates(string $referenceCode, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     */
    public function updateUserWaypoint(string $referenceCode, array $userWaypoint, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-reference-code
     */
    public function getReferenceCodeFromId(array $query, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-countries
     */
    public function getCountries(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-states
     */
    public function getStates(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-country-states
     */
    public function getStatesByCountry(int $countryId, array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-membership-levels
     */
    public function getMembershipLevels(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-types
     */
    public function getGeocacheTypes(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-attributes
     */
    public function getAttributes(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-sizes
     */
    public function getGeocacheSizes(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocache-statuses
     */
    public function getGeocacheStatuses(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-geocachelog-types
     */
    public function getGeocacheLogTypes(array $headers = []): ResponseInterface;

    /**
     * @see https://api.groundspeak.com/documentation#get-trackablelog-types
     */
    public function getTrackableLogTypes(array $headers = []): ResponseInterface;

    /**
     */
    public function getWherigoCartridge(string $guid, array $query = [], array $headers = []): ResponseInterface;

    /**
     */
    public function ping(): ResponseInterface;
}
