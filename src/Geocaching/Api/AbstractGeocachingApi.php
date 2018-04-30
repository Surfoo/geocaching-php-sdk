<?php

/**
 * Geocaching API with PHP.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

/**
 * Abstract methods from Groundspeak API.
 *
 * @link    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @link    https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help API Documentation by Groundspeak
 * @abstract
 */
abstract class AbstractGeocachingApi
{
    /**
     * Staging URL of Groundspeak API.
     *
     * @var string
     */
    const STAGING_API_URL = 'https://staging.api.groundspeak.com/Live/V6Beta/geocaching.svc/%s';

    /**
     * Production URL of Groundspeak API.
     *
     * @var string
     */
    const LIVE_API_URL = 'https://api.groundspeak.com/LiveV6/geocaching.svc/%s';

    /**
     * API URL.
     *
     * @var string
     */
    protected $api_url = null;

    /**
     * OAuth token sent by the client.
     *
     * @var string
     */
    protected $oauth_token = null;

    /**
     * @var GuzzleHttp\Client client
     */
    protected $client = null;

    /**
     * Constructor.
     *
     * @param Guzzle\Client $client
     * @param string $oauth_token OAuth token provided by the application
     * @param bool   $live        production = true, staging = false
     */
    public function __construct(Client $client, $oauth_token, $live = true)
    {
        if (empty($oauth_token)) {
            throw new GeocachingApiException('oauth_token is missing.');
        }

        $this->oauth_token  = $oauth_token;
        $this->client       = $client;
        $this->api_url      = $live ? self::LIVE_API_URL : self::STAGING_API_URL;
    }

    /**
     * Add Favorite Point To a Cache.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/AddFavoritePointToCache Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function addFavoritePointToCache(array $params);

    /**
     * Add Geocaches to a bookmark list.
     *
     * - required params: BookmarkListGuid, CacheCodes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/AddGeocachesToBookmarkList Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function addGeocachesToBookmarkList(array $params);

    /**
     * Create Field Note And Publish.
     *
     * - required params: CacheCode, WptLogTypeId, UTCDateLogged, Note
     * - optional params: PromoteToLog, FavoriteThisCache, EncryptLogText, UpdatedLatitude, UpdatedLongitude, base64ImageData, FileCaption, FileDescription, FileName, Guid
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/CreateFieldNoteAndPublish Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function createFieldNoteAndPublish(array $params);

    /**
     * Create Trackable Log.
     *
     * - required params: TrackingNumber, UTCDateLogged, Note, LogType
     * - optional params: CacheCode, TravelBugCode, base64ImageData, FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/CreateTrackableLog Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function createTrackableLog(array $params);

    /**
     * Delete Cache Note.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/DeleteCacheNote Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function deleteCacheNote(array $params);

    /**
     * Delete User Waypoint.
     *
     * - required param: waypointID
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/DeleteUserWaypoint Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function deleteUserWaypoint(array $params);

    /**
     * Geocode String.
     *
     * - required param: GeocodeString
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GeocodeString Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function geocodeString(array $params);

    /**
     * Get Another Users Profile.
     *
     * - required param: UserID
     * - optional params: ChallengesData, FavoritePointsData, GeocacheData, PublicProfileData, SouvenirData, TrackableData
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAnotherUsersProfile Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getAnotherUsersProfile(array $params);

    /**
     * Get API Limits.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAPILimits Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getAPILimits();

    /**
     * Get Attribute Types Data.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAttributeTypesData Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getAttributeTypesData();

    /**
     * Get Bookmark List By Guid.
     *
     * - required param: BookmarkListGuid
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListByGuid Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getBookmarkListByGuid(array $params);

    /**
     * Get Bookmark Lists By User ID.
     *
     * - required param: userID
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListsByUserID Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getBookmarkListsByUserID(array $params);

    /**
     * Get Bookmark Lists For User.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListsForUser Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getBookmarkListsForUser();

    /**
     * Get Cache Ids Favorited By User.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetCacheIdsFavoritedByUser Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getCacheIdsFavoritedByUser();

    /**
     * Get Caches Favorited By User.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetCachesFavoritedByUser Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getCachesFavoritedByUser();

    /**
     * Get Full Pocket Query Data.
     *
     * Returns a complete Geocache object without those full caches counting against user's cache limit.
     *
     * - required params: pocketQueryGuid, maxItems
     * - optional param: startItem
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetFullPocketQueryData Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getFullPocketQueryData(array $params);

    /**
     * Get Geocache Data Types.
     *
     * - optional params: geocacheTypes, logTypes, attributeTypes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheDataTypes Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getGeocacheDataTypes(array $params);

    /**
     * Get Geocache Logs By Cache Code.
     *
     * - required params: cacheCode, maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheLogsByCacheCode Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getGeocacheLogsByCacheCode(array $params);

    /**
     * Get Geocache Status.
     *
     * - required param: CacheCodes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheStatus Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getGeocacheStatus(array $params);

    /**
     * Get Geocache Types.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheTypes Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getGeocacheTypes();

    /**
     * Get Images For Geocache.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetImagesForGeocache Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getImagesForGeocache(array $params);

    /**
     * Get Membership Types.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetMembershipTypes Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getMembershipTypes();

    /**
     * Get More Geocaches.
     *
     * - required params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount
     * - optional param: IsSummaryOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetMoreGeocaches Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getMoreGeocaches(array $params);

    /**
     * Get Owned Trackables.
     *
     * - required params: StartIndex, MaxPerPage
     * - optional params: TrackableLogsCount, CollectionOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetOwnedTrackables Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getOwnedTrackables(array $params);

    /**
     * Get Pocket Query Data.
     *
     * - required params: pocketQueryGuid, maxItems
     * - optional params: startItem, gcListOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryData Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getPocketQueryData(array $params);

    /**
     * Get Pocket Query List.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryList Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getPocketQueryList();

    /**
     * Get Pocket Query Zipped File.
     *
     * - required param: pocketQueryGuid
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryZippedFile Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getPocketQueryZippedFile(array $params);

    /**
     * Get Site Stats.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetSiteStats Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getSiteStats();

    /**
     * Get Status Messages.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetStatusMessages Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getStatusMessages();

    /**
     * Get Trackable Logs By TB Code.
     *
     * - required params: tbCode, maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackableLogsByTBCode Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getTrackableLogsByTBCode(array $params);

    /**
     * Get Trackables By TB Code.
     *
     * - required param: tbCode
     * - optional param: trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesByTBCode Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getTrackablesByTBCode(array $params);

    /**
     * Get Trackables By Tracking Number.
     *
     * - required param: trackingNumber
     * - optional param: trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesByTrackingNumber Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getTrackablesByTrackingNumber(array $params);

    /**
     * Get Trackables In Cache.
     *
     * - required params: cacheCode, maxPerPage
     * - optional params: startIndex, trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesInCache Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getTrackablesInCache(array $params);

    /**
     * Get Trackable Travel List.
     *
     * - required param: tbCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackableTravelList Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getTrackableTravelList(array $params);

    /**
     * Get User Gallery.
     *
     * - required params: Username, StartIndex, MaxPerPage
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUserGallery Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUserGallery(array $params); //new

    /**
     * Get Users Cache Counts.
     *
     * - required param: Usernames
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersCacheCounts Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUsersCacheCounts(array $params);

    /**
     * Get Users Cache Notes.
     *
     * - required param: maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersCacheNotes Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUsersCacheNotes(array $params);

    /**
     * Get Users Favorite Points.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersFavoritePoints Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getUsersFavoritePoints();

    /**
     * Get Users Geocache Logs.
     *
     * - required params: Username, LogTypes, MaxPerPage
     * - optional params: StartIndex, EndDate, StartDate, ExcludeArchived
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersGeocacheLogs Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUsersGeocacheLogs(array $params);

    /**
     * get Users Trackables.
     *
     * - required param: MaxPerPage
     * - optional params: StartIndex, TrackableLogsCount, CollectionOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersTrackables Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUsersTrackables(array $params);

    /**
     * Get Users Who Favorited Cache.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersWhoFavoritedCache Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUsersWhoFavoritedCache(array $params);

    /**
     * Get User Waypoints.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUserWaypoints Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getUserWaypoints(array $params);

    /**
     * Get Wpt Log Types.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetWptLogTypes Documentation by Groundspeak
     * @abstract
     *
     * @return object
     */
    abstract public function getWptLogTypes();

    /**
     * Get Your User Profile.
     *
     * - optional params: ChallengesData, FavoritePointsData, GeocacheData, PublicProfileData, SouvenirData, TrackableData, EmailData,
     * ApplicationCurrentMemoryUsage, ApplicationPeakMemoryUsage, ApplicationSoftwareVersion DeviceManufacturer, DeviceName, DeviceOperatingSystem,
     * DeviceTotalMemoryInMB, DeviceUniqueId, MobileHardwareVersion, WebBrowserVersion
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetYourUserProfile Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function getYourUserProfile($params = []);

    /**
     * Remove Favorite Point From Cache.
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/RemoveFavoritePointFromCache Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function removeFavoritePointFromCache(array $params);

    /**
     * Save User Waypoint.
     *
     * - required params: CacheCode, Latitude, Longitude
     * - optional param: Description, ID, IsCorrectedCoordinate, AssociatedAdditionalWaypoint, IsUserCompleted
     * Note: The ID field in the request should only be set with an ID returned from the service
     * (when you are updating a waypoint) Otherwise this field should be left null.
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SaveUserWaypoint Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function saveUserWaypoint(array $params);

    /**
     * Search For Geocaches.
     *
     * - required params: DistanceInMeters && PointRadiusLatitude && PointRadiusLongitude OR CacheCode, MaxPerPage
     * - optional params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount, NotFoundByUsers, MinTerrain,
     * MaxTerrain, GeocacheName, MinDifficulty, MaxDifficulty, CacheCodes, GeocacheTypeIds, GeocacheContainerSizeIds,
     * Archived, Available, Premium, Published, MinFavoritePoints, MaxFavoritePoints, HiddenByUsers, NotHiddenByUsers, BottomRightLatitude,
     * BottomRightLongitude, TopLeftLatitude, TopLeftLongitude, BookmarkListIDs, ExcludeIgnoreList, MinTrackables, MaxTrackables,
     * UserNameFieldNotesFinds, StartDatePublished, EndDatePublished, StateIds, CountryIds, RecommendedOriginLatitude, RecommendedOriginLongitude,
     * StartDateEvent, EndDateEvent, AscendingOrder, SortFilterId, IsSummaryOnly, SortPointLatitude, SortPointLongitude
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SearchForGeocaches Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function searchForGeocaches(array $params);

    /**
     * Search For Souvenirs By Public Guid.
     *
     * - required param: PublicGuid
     * - optional param: ExistingSouvenirIDs
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SearchForSouvenirsByPublicGuid Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function searchForSouvenirsByPublicGuid(array $params);

    /**
     * Update Cache Note.
     *
     * - required params: CacheCode, Note
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UpdateCacheNote Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function updateCacheNote(array $params);

    /**
     * Upload Image To Geocache Log.
     *
     * - required params: LogGuid, base64ImageData
     * - optional params: FileCaption, FileDescription, FileName, ReferenceCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UploadImageToGeocacheLog Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function uploadImageToGeocacheLog(array $params);

    /**
     * Upload Image To Trackable Log.
     *
     * - required params: LogGuid, base64ImageData
     * - optional params: FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UploadImageToTrackableLog Documentation by Groundspeak
     * @abstract
     *
     * @param array $params
     *
     * @return object
     */
    abstract public function uploadImageToTrackableLog(array $params);

    /**
     * Get User Profile.
     *
     * Internal method for getYourUserProfile or getAnotherUsersProfile
     * - optional params: UserID, FavoritePointsData, GeocacheData, PublicProfileData, ProfileOptions, SouvenirData, ProfileOptions
     *
     * If the method is getYourUserProfile, there are some required params (DeviceInfo) but are useful only for mobile application
     *
     * @param string $function
     * @param array  $params
     *
     * @return object
     */
    protected function getUserProfile($function, $params = [])
    {
        $post_params = [];
        if (array_key_exists('UserID', $params)) {
            $post_params['UserID'] = (int) $params['UserID'];
        }
        if (array_key_exists('FavoritePointsData', $params)) {
            $post_params['ProfileOptions']['FavoritePointsData'] = (boolean) $params['FavoritePointsData'];
        }
        if (array_key_exists('GeocacheData', $params)) {
            $post_params['ProfileOptions']['GeocacheData'] = (boolean) $params['GeocacheData'];
        }
        if (array_key_exists('PublicProfileData', $params)) {
            $post_params['ProfileOptions']['PublicProfileData'] = (boolean) $params['PublicProfileData'];
        }
        if (array_key_exists('SouvenirData', $params)) {
            $post_params['ProfileOptions']['SouvenirData'] = (boolean) $params['SouvenirData'];
        }
        if (array_key_exists('TrackableData', $params)) {
            $post_params['ProfileOptions']['TrackableData'] = (boolean) $params['TrackableData'];
        }
        if (array_key_exists('EmailData', $params)) {
            $post_params['ProfileOptions']['EmailData'] = (boolean) $params['EmailData'];
        }
        if ($function == 'getYourUserProfile') {
            $post_params['DeviceInfo']['ApplicationCurrentMemoryUsage'] = 2048 * 1024;
            $post_params['DeviceInfo']['ApplicationPeakMemoryUsage']    = 2048 * 1024;
            $post_params['DeviceInfo']['ApplicationSoftwareVersion']    = 'blabla';
            $post_params['DeviceInfo']['DeviceManufacturer']            = 'blabla';
            $post_params['DeviceInfo']['DeviceName']                    = 'blabla';
            $post_params['DeviceInfo']['DeviceOperatingSystem']         = 'blabla';
            $post_params['DeviceInfo']['DeviceTotalMemoryInMB']         = 2048 * 1024;
            $post_params['DeviceInfo']['DeviceUniqueId']                = 'blabla';
            $post_params['DeviceInfo']['MobileHardwareVersion']         = 'blabla';
            $post_params['DeviceInfo']['WebBrowserVersion']             = 'blabla';
        }

        return $this->postRequest($function, $post_params);
    }

    /**
     * Check the status of the POST or GET request in JSON.
     *
     * @param object $content
     */
    protected function checkRequestStatus(\stdClass $content)
    {
        if (!empty($content->Status->StatusCode)) {
            throw new GeocachingApiException($content->Status->StatusMessage, $content->Status->StatusCode);
        }
    }

    /**
     * Make a GET request.
     *
     * @param string $request
     * @param array  $params
     *
     * @return object
     */
    protected function getRequest($request, $params = [])
    {
        $params       = array_merge(['format' => 'json', 'AccessToken' => $this->oauth_token], $params);
        $query_string = '?' . http_build_query($params, '', '&');
        $url          = sprintf($this->api_url, ucfirst($request)) . $query_string;

        try {
            $response = $this->client->get($url);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }

            return false;
        }

        $output = json_decode((string) $response->getBody());

        try {
            $this->checkRequestStatus($output);
        } catch(GeocachingApiException $e) {
            return $e->getMessage();
        }
        return $output;
    }

    /**
     * Make a POST request.
     *
     * @param string $request
     * @param array  $data
     *
     * @return object
     */
    protected function postRequest($request, array $data)
    {
        $params       = ['format' => 'json'];
        $query_string = '?' . http_build_query($params, '', '&');
        $url          = sprintf($this->api_url, ucfirst($request)) . $query_string;
        $data         = array_merge(['AccessToken' => $this->oauth_token], $data);

        try {
            $response = $this->client->post($url, ['json' => $data]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }

            return false;
        }

        $output = json_decode((string) $response->getBody());

        try {
            $this->checkRequestStatus($output);
        } catch(GeocachingApiException $e) {
            return $e->getMessage();
        }
        return $output;
    }
}
