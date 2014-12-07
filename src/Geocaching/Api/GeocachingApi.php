<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @license http://opensource.org/licenses/eclipse-2.0.php
 * @package Geocaching_Api
 */

namespace Geocaching\Api;

/**
 * List of methods from Groundspeak API
 *
 * @link    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @link    https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help API Documentation by Groundspeak
 */
class GeocachingApi extends AbstractGeocachingApi
{
    /**
     * Add Favorite Point To a Cache
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/AddFavoritePointToCache Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function addFavoritePointToCache(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params = array('cacheCode' => $params['cacheCode']);

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Add Geocaches To Bookmark List
     *
     * - required params: BookmarkListGuid, CacheCodes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/AddGeocachesToBookmarkList Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function addGeocachesToBookmarkList(array $params)
    {
        if(!array_key_exists('BookmarkListGuid', $params))
            throw new \Exception('BookmarkListGuid is missing.');
        if(!array_key_exists('CacheCodes', $params))
            throw new \Exception('CacheCodes is missing.');
        if(!is_array($params['CacheCodes']))
            throw new \Exception('CacheCodes must be an array.');

        $post_params['BookmarkListGuid'] = $params['BookmarkListGuid'];
        $post_params['CacheCodes'] = $params['CacheCodes'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Create Field Note And Publish
     *
     * - required params: CacheCode, WptLogTypeId, UTCDateLogged, Note
     * - optional params: PromoteToLog, FavoriteThisCache, EncryptLogText, UpdatedLatitude, UpdatedLongitude, base64ImageData, FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/CreateFieldNoteAndPublish Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function createFieldNoteAndPublish(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');
        if(!array_key_exists('WptLogTypeId', $params))
            throw new \Exception('WptLogTypeId is missing.');
        if(!array_key_exists('UTCDateLogged', $params))
            throw new \Exception('UTCDateLogged is missing.');
        if(!array_key_exists('Note', $params))
            throw new \Exception('Note is missing.');

        $post_params['CacheCode'] = $params['CacheCode'];
        $post_params['WptLogTypeId'] = $params['WptLogTypeId'];
        $post_params['UTCDateLogged'] = '/Date('.((int) $params['UTCDateLogged'] * 1000).')/'; //UTCDateLogged is a timestamp
        $post_params['Note'] = $params['Note'];

        if(array_key_exists('PromoteToLog', $params))
            $post_params['PromoteToLog'] = (boolean) $params['PromoteToLog'];
        if(array_key_exists('FavoriteThisCache', $params))
            $post_params['FavoriteThisCache'] = (boolean) $params['FavoriteThisCache'];
        if(array_key_exists('EncryptLogText', $params))
            $post_params['EncryptLogText'] = (boolean) $params['EncryptLogText'];
        if(array_key_exists('UpdatedLatitude', $params))
            $post_params['UpdatedLatitude'] = (float) $params['UpdatedLatitude'];
        if(array_key_exists('UpdatedLongitude', $params))
            $post_params['UpdatedLongitude'] = (float) $params['UpdatedLongitude'];

        if (array_key_exists('base64ImageData', $params)) {
            $post_params['ImageData']['base64ImageData'] = base64_encode($params['base64ImageData']);
            if(array_key_exists('FileCaption', $params))
                $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
            if(array_key_exists('FileDescription', $params))
                $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
            if(array_key_exists('FileName', $params))
                $post_params['ImageData']['FileName'] = $params['FileName'];
        }

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Create Trackable Log
     *
     * - required params: TrackingNumber, UTCDateLogged, Note, LogType
     * - optional params: CacheCode, TravelBugCode, base64ImageData, FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/CreateTrackableLog Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function createTrackableLog(array $params)
    {
        if(!array_key_exists('TrackingNumber', $params))
            throw new \Exception('TrackingNumber is missing.');
        if(!array_key_exists('UTCDateLogged', $params))
            throw new \Exception('UTCDateLogged is missing.');
        if(!array_key_exists('Note', $params))
            throw new \Exception('Note is missing.');
        if(!array_key_exists('LogType', $params))
            throw new \Exception('LogType is missing.');

        $post_params['TrackingNumber'] = $params['TrackingNumber'];
        $post_params['UTCDateLogged'] = '/Date('.((int) $params['UTCDateLogged'] * 1000).')/'; //UTCDateLogged is a timestamp
        $post_params['Note'] = $params['Note'];
        $post_params['LogType'] = (int) $params['LogType'];

        if (array_key_exists('base64ImageData', $params)) {
            $post_params['ImageData']['base64ImageData'] = base64_encode($params['base64ImageData']);
            if(array_key_exists('FileCaption', $params))
                $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
            if(array_key_exists('FileDescription', $params))
                $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
            if(array_key_exists('FileName', $params))
                $post_params['ImageData']['FileName'] = $params['FileName'];
        }

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Delete Cache Note
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/DeleteCacheNote Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function deleteCacheNote(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params = array('cacheCode' => $params['cacheCode']);

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Delete User Waypoint
     *
     * - required param: waypointID
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/DeleteUserWaypoint Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function deleteUserWaypoint(array $params)
    {
        if(!array_key_exists('waypointID', $params))
            throw new \Exception('waypointID is missing.');

        $get_params = array('waypointID' => (int) $params['waypointID']);

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Geocode String
     *
     * - required param: GeocodeString
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GeocodeString Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function geocodeString(array $params)
    {
        if(!array_key_exists('GeocodeString', $params))
            throw new \Exception('GeocodeString is missing.');

        $post_params['GeocodeString'] = $params['GeocodeString'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Another Users Profile
     *
     * - required param: UserID
     * - optional params: ChallengesData, FavoritePointsData, GeocacheData, PublicProfileData, SouvenirData, TrackableData
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAnotherUsersProfile Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getAnotherUsersProfile(array $params)
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * Get API Limits
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAPILimits Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getAPILimits()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Attribute Types Data
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetAttributeTypesData Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getAttributeTypesData()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Bookmark List By Guid
     *
     * - required param: BookmarkListGuid
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListByGuid Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getBookmarkListByGuid(array $params)
    {
        if(!array_key_exists('BookmarkListGuid', $params))
            throw new \Exception('BookmarkListGuid is missing.');

        $post_params['BookmarkListGuid'] = $params['BookmarkListGuid'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Bookmark Lists By User ID
     *
     * - required param: userID
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListsByUserID Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getBookmarkListsByUserID(array $params)
    {
        if(!array_key_exists('userID', $params))
            throw new \Exception('userID is missing.');

        $get_params = array('userID' => (int) $params['userID']);

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Bookmark Lists For User
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetBookmarkListsForUser Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getBookmarkListsForUser()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Cache Ids Favorited By User
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetCacheIdsFavoritedByUser Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getCacheIdsFavoritedByUser()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Caches Favorited By User
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetCachesFavoritedByUser Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getCachesFavoritedByUser()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Full Pocket Query Data
     *
     * Returns a complete Geocache object without those full caches counting against user's cache limit.
     *
     * - required params: pocketQueryGuid, maxItems
     * - optional param: startItem
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetFullPocketQueryData Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getFullPocketQueryData(array $params)
    {
        if(!array_key_exists('pocketQueryGuid', $params))
            throw new \Exception('pocketQueryGuid is missing.');
        if(!array_key_exists('maxItems', $params))
            throw new \Exception('maxItems is missing.');

        $get_params['pocketQueryGuid'] = $params['pocketQueryGuid'];
        $get_params['maxItems'] = (int) $params['maxItems'];
        if(array_key_exists('startItem', $params))
            $get_params['startItem'] = (int) $params['startItem'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }
    /**
     * Get Geocache Data Types
     *
     * - optional params: geocacheTypes, logTypes, attributeTypes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheDataTypes Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getGeocacheDataTypes(array $params)
    {
        $get_params = array();
        if(array_key_exists('geocacheTypes', $params))
            $get_params['geocacheTypes'] = (boolean) $params['geocacheTypes'] ? 'true' : 'false';
        if(array_key_exists('logTypes', $params))
            $get_params['logTypes'] = (boolean) $params['logTypes'] ? 'true' : 'false';
        if(array_key_exists('attributeTypes', $params))
            $get_params['attributeTypes'] = (boolean) $params['attributeTypes'] ? 'true' : 'false';

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Geocache Logs By Cache Code
     *
     * - required params: cacheCode, maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheLogsByCacheCode Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getGeocacheLogsByCacheCode(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');
        if(!array_key_exists('maxPerPage', $params))
            throw new \Exception('maxPerPage is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];
        $get_params['maxPerPage'] = (int) $params['maxPerPage'];
        if(array_key_exists('startIndex', $params))
            $get_params['startIndex'] = (int) $params['startIndex'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Geocache Status
     *
     * - required param: CacheCodes
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheStatus Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getGeocacheStatus(array $params)
    {
        if(!array_key_exists('CacheCodes', $params))
            throw new \Exception('CacheCodes is missing.');

        $post_params['CacheCodes'] = $params['CacheCodes'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Geocache Types
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetGeocacheTypes Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getGeocacheTypes()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Images For Geocache
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetImagesForGeocache Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getImagesForGeocache(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Membership Types
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetMembershipTypes Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getMembershipTypes()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get More Geocaches
     *
     * - required params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetMoreGeocaches Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getMoreGeocaches(array $params)
    {
        if(!array_key_exists('IsLite', $params))
            throw new \Exception('IsLite is missing.');
        if(!array_key_exists('StartIndex', $params))
            throw new \Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');
        if(!array_key_exists('GeocacheLogCount', $params))
            throw new \Exception('GeocacheLogCount is missing.');
        if(!array_key_exists('TrackableLogCount', $params))
            throw new \Exception('TrackableLogCount is missing.');

        $post_params['IsLite']  = (boolean) $params['IsLite'];
        $post_params['StartIndex']  = (int) $params['StartIndex'];
        $post_params['MaxPerPage']  = (int) $params['MaxPerPage'];
        $post_params['GeocacheLogCount']  = (int) $params['GeocacheLogCount'];
        $post_params['TrackableLogCount']  = (int) $params['TrackableLogCount'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Owned Trackables
     *
     * - required params: StartIndex, MaxPerPage
     * - optional params: TrackableLogsCount, CollectionOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetOwnedTrackables Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getOwnedTrackables(array $params)
    {
        if(!array_key_exists('StartIndex', $params))
            throw new \Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $post_params['StartIndex'] = (int) $params['StartIndex'];
        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('TrackableLogsCount', $params))
            $post_params['TrackableLogsCount'] = (int) (boolean) $params['TrackableLogsCount'];
        if(array_key_exists('CollectionOnly', $params))
            $post_params['CollectionOnly'] = (boolean) $params['CollectionOnly'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Pocket Query Data
     *
     * - required params: pocketQueryGuid, maxItems
     * - optional params: startItem, gcListOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryData Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getPocketQueryData(array $params)
    {
        if(!array_key_exists('pocketQueryGuid', $params))
            throw new \Exception('pocketQueryGuid is missing.');
        if(!array_key_exists('maxItems', $params))
            throw new \Exception('maxItems is missing.');

        $get_params['pocketQueryGuid'] = $params['pocketQueryGuid'];
        $get_params['maxItems'] = (int) $params['maxItems'];
        if(array_key_exists('startItem', $params))
            $get_params['startItem'] = (int) $params['startItem'];
        if(array_key_exists('gcListOnly', $params))
            $get_params['gcListOnly'] = (boolean) $params['gcListOnly'] ? 'true' : 'false';

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Pocket Query List
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryList Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getPocketQueryList()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Pocket Query Zipped File
     *
     * - required param: pocketQueryGuid
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetPocketQueryZippedFile Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getPocketQueryZippedFile(array $params)
    {
        if(!array_key_exists('pocketQueryGuid', $params))
            throw new \Exception('pocketQueryGuid is missing.');

        $get_params['pocketQueryGuid'] = $params['pocketQueryGuid'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Site Stats
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetSiteStats Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getSiteStats()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Status Messages
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetStatusMessages Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getStatusMessages()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Trackable Logs By TB Code
     *
     * - required params: tbCode, maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackableLogsByTBCode Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getTrackableLogsByTBCode(array $params)
    {
        if(!array_key_exists('tbCode', $params))
            throw new \Exception('tbCode is missing.');
        if(!array_key_exists('maxPerPage', $params))
            throw new \Exception('maxPerPage is missing.');

        $get_params['tbCode'] = $params['tbCode'];
        $get_params['maxPerPage'] = (int) $params['maxPerPage'];
        if(array_key_exists('startIndex', $params))
            $get_params['startIndex'] = (int) $params['startIndex'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables By TB Code
     *
     * - required param: tbCode
     * - optional param: trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesByTBCode Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getTrackablesByTBCode(array $params)
    {
        if(!array_key_exists('tbCode', $params))
            throw new \Exception('tbCode is missing.');

        $get_params['tbCode'] = $params['tbCode'];
        if(array_key_exists('trackableLogCount', $params))
            $get_params['trackableLogCount'] = (int) (boolean) $params['trackableLogCount'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables By Tracking Number
     *
     * - required param: trackingNumber
     * - optional param: trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesByTrackingNumber Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getTrackablesByTrackingNumber(array $params)
    {
        if(!array_key_exists('trackingNumber', $params))
            throw new \Exception('trackingNumber is missing.');

        $get_params['trackingNumber'] = $params['trackingNumber'];
        if(array_key_exists('trackableLogCount', $params))
            $get_params['trackableLogCount'] = (int) (boolean) $params['trackableLogCount'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables In Cache
     *
     * - required params: cacheCode, maxPerPage
     * - optional params: startIndex, trackableLogCount
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackablesInCache Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getTrackablesInCache(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');
        if(!array_key_exists('maxPerPage', $params))
            throw new \Exception('maxPerPage is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];
        $get_params['maxPerPage'] = (int) $params['maxPerPage'];
        if(array_key_exists('startIndex', $params))
            $get_params['startIndex'] = (int) $params['startIndex'];
        if(array_key_exists('trackableLogCount', $params))
            $get_params['trackableLogCount'] = (int) (boolean) $params['trackableLogCount'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackable Travel List
     *
     * - required param: tbCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetTrackableTravelList Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getTrackableTravelList(array $params)
    {
        if(!array_key_exists('tbCode', $params))
            throw new \Exception('tbCode is missing.');

        $get_params['tbCode'] = $params['tbCode'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get User Gallery
     *
     * - required params: Username, StartIndex, MaxPerPage
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUserGallery Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUserGallery(array $params)
    {
        if(!array_key_exists('Username', $params))
            throw new \Exception('Username is missing.');
        if(!array_key_exists('StartIndex', $params))
            throw new \Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $post_params['Username'] = $params['Username'];
        $post_params['StartIndex'] = (int) $params['StartIndex'];
        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Cache Counts
     *
     * - required param: Usernames
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersCacheCounts Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUsersCacheCounts(array $params)
    {
        if(!array_key_exists('Usernames', $params))
            throw new \Exception('Usernames is missing.');
        if(!is_array($params['Usernames']))
            throw new \Exception('Usernames must be an array.');

        $post_params['Usernames'] = $params['Usernames'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Cache Notes
     *
     * - required param: maxPerPage
     * - optional param: startIndex
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersCacheNotes Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUsersCacheNotes(array $params)
    {
        if(!array_key_exists('maxPerPage', $params))
            throw new \Exception('maxPerPage is missing.');

        $get_params['maxPerPage'] = (int) $params['maxPerPage'];
        if(array_key_exists('startIndex', $params))
            $get_params['startIndex'] = (int) $params['startIndex'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Users Favorite Points
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersFavoritePoints Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getUsersFavoritePoints()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Users Geocache Logs
     *
     * - required params: Username, LogTypes, MaxPerPage
     * - optional params: StartIndex, EndDate, StartDate, ExcludeArchived
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersGeocacheLogs Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUsersGeocacheLogs(array $params)
    {
        if(!array_key_exists('Username', $params))
            throw new \Exception('Username is missing.');
        if(!array_key_exists('LogTypes', $params))
            throw new \Exception('LogTypes is missing.');
        if(!is_array($params['LogTypes']))
            throw new \Exception('LogTypes must be an array.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $post_params['StartIndex'] = (int) $params['StartIndex'];
        $post_params['Username'] = $params['Username'];
        $post_params['LogTypes'] = $params['LogTypes'];

        if(array_key_exists('EndDate', $params))
            $post_params['Range']['EndDate'] = '/Date('.((int) $params['EndDate'] * 1000).')/'; //EndDate is a timestamp
        if(array_key_exists('StartDate', $params))
            $post_params['Range']['StartDate'] = '/Date('.((int) $params['StartDate'] * 1000).')/'; //StartDate is a timestamp
        if(array_key_exists('ExcludeArchived', $params))
            $post_params['ExcludeArchived'] = (boolean) $params['ExcludeArchived'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Trackables
     *
     * - required param: MaxPerPage
     * - optional params: StartIndex, TrackableLogsCount, CollectionOnly
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersTrackables Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUsersTrackables(array $params)
    {
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $post_params['StartIndex'] = (int) $params['StartIndex'];
        if(array_key_exists('TrackableLogsCount', $params))
            $post_params['TrackableLogsCount'] = (int) (boolean) $params['TrackableLogsCount'];
        if(array_key_exists('CollectionOnly', $params))
            $post_params['CollectionOnly'] = (boolean) $params['CollectionOnly'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Who Favorited Cache
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUsersWhoFavoritedCache Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUsersWhoFavoritedCache(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get User Waypoints
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetUserWaypoints Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getUserWaypoints(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Get Wpt Log Types
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetWptLogTypes Documentation by Groundspeak
     * @access public
     * @return object
     */
    public function getWptLogTypes()
    {
        return $this->getRequest(__FUNCTION__);
    }

    /**
     * Get Your User Profile
     *
     * - optional params: ChallengesData, FavoritePointsData, GeocacheData, PublicProfileData, SouvenirData, TrackableData, EmailData,
     * ApplicationCurrentMemoryUsage, ApplicationPeakMemoryUsage, ApplicationSoftwareVersion DeviceManufacturer, DeviceName, DeviceOperatingSystem,
     * DeviceTotalMemoryInMB, DeviceUniqueId, MobileHardwareVersion, WebBrowserVersion
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/GetYourUserProfile Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function getYourUserProfile($params = array())
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * Remove Favorite Point From Cache
     *
     * - required param: cacheCode
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/RemoveFavoritePointFromCache Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function removeFavoritePointFromCache(array $params)
    {
        if(!array_key_exists('cacheCode', $params))
            throw new \Exception('cacheCode is missing.');

        $get_params['cacheCode'] = $params['cacheCode'];

        return $this->getRequest(__FUNCTION__, $get_params);
    }

    /**
     * Save User Waypoint
     *
     * - required params: CacheCode, Latitude, Longitude
     * - optional param: Description, ID, IsCorrectedCoordinate, AssociatedAdditionalWaypoint, IsUserCompleted
     * *Note* The ID field in the request should only be set with an ID returned from the service (when you are updating a waypoint)
     * Otherwise this field should be left null. 
     * Possible status codes: 
     *     GetStatusOk - 0, 
     *     GetFailStatus - 1, 
     *     GetNotAuthorizedStatus - 2, 
     *     GetGeocacheCodeIsNotValid - 12, 
     *     GetInvalidInputsStatus - 100, 
     *     GetCorrectedCoordinatesNotSupportedWithoutCacheId - 154, 
     *     GetCannotSupportMoreThanOneCorrectedCoordinatesPerGeocache - 155
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SaveUserWaypoint Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function saveUserWaypoint(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');
        if(!array_key_exists('Latitude', $params))
            throw new \Exception('Latitude is missing.');
        if(!array_key_exists('Longitude', $params))
            throw new \Exception('Longitude is missing.');

        $post_params['CacheCode'] = $params['CacheCode'];
        $post_params['Latitude']  = (float) $params['Latitude'];
        $post_params['Longitude'] = (float) $params['Longitude'];

        if(array_key_exists('Description', $params))
            $post_params['Description'] = $params['Description'];
        if(array_key_exists('ID', $params))
            $post_params['ID'] = (int) $params['ID'];

        if(array_key_exists('IsCorrectedCoordinate', $params))
            $post_params['IsCorrectedCoordinate'] = (boolean) $params['IsCorrectedCoordinate'];

        if(array_key_exists('AssociatedAdditionalWaypoint', $params))
            $post_params['AssociatedAdditionalWaypoint'] = $params['AssociatedAdditionalWaypoint'];

        if(array_key_exists('IsUserCompleted', $params))
            $post_params['IsUserCompleted'] = (boolean) $params['IsUserCompleted'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Search For Geocaches
     *
     * - required params: DistanceInMeters && PointRadiusLatitude && PointRadiusLongitude OR CacheCode, MaxPerPage
     * - optional params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount, NotFoundByUsers, MinTerrain,
     * MaxTerrain, GeocacheName, MinDifficulty, MaxDifficulty, CacheCodes, GeocacheTypeIds, GeocacheContainerSizeIds,
     * Archived, Available, Premium, MinFavoritePoints, MaxFavoritePoints, HiddenByUsers, NotHiddenByUsers, BottomRightLatitude,
     * BottomRightLongitude, TopLeftLatitude, TopLeftLongitude, BookmarkListIDs, ExcludeIgnoreList, MinTrackables, MaxTrackables,
     * UserNameFieldNotesFinds, StartDateRange, EndDateRange, StateIds
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SearchForGeocaches Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function searchForGeocaches(array $params)
    {
        if(array_key_exists('IsLite', $params))
            $post_params['IsLite'] = (boolean) $params['IsLite'];

        if(array_key_exists('MaxPerPage', $params))
            $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];

        if(array_key_exists('GeocacheLogCount', $params))
            $post_params['GeocacheLogCount'] = (int) $params['GeocacheLogCount'];

        if(array_key_exists('TrackableLogCount', $params))
            $post_params['TrackableLogCount'] = (int) $params['TrackableLogCount'];

        if(array_key_exists('DistanceInMeters', $params))
            $post_params['PointRadius']['DistanceInMeters'] = (int) $params['DistanceInMeters'];
        if(array_key_exists('PointRadiusLatitude', $params))
            $post_params['PointRadius']['Point']['Latitude'] = (float) $params['PointRadiusLatitude'];
        if(array_key_exists('PointRadiusLongitude', $params))
            $post_params['PointRadius']['Point']['Longitude'] = (float) $params['PointRadiusLongitude'];

        if(array_key_exists('NotFoundByUsers', $params) && is_array($params['NotFoundByUsers']))
            $post_params['NotFoundByUsers']['UserNames'] = $params['NotFoundByUsers'];

        if(array_key_exists('MinTerrain', $params))
            $post_params['Terrain']['MinTerrain'] = (float) $params['MinTerrain'];
        if(array_key_exists('MaxTerrain', $params))
            $post_params['Terrain']['MaxTerrain'] = (float) $params['MaxTerrain'];

        if(array_key_exists('GeocacheName', $params))
            $post_params['GeocacheName']['GeocacheName'] = $params['GeocacheName'];

        if(array_key_exists('MinDifficulty', $params))
            $post_params['Difficulty']['MinDifficulty'] = (float) $params['MinDifficulty'];
        if(array_key_exists('MaxDifficulty', $params))
            $post_params['Difficulty']['MaxDifficulty'] = (float) $params['MaxDifficulty'];

        if(array_key_exists('CacheCodes', $params) && is_array($params['CacheCodes']))
            $post_params['CacheCode']['CacheCodes'] = $params['CacheCodes'];

        if(array_key_exists('GeocacheTypeIds', $params) && is_array($params['GeocacheTypeIds']))
            $post_params['GeocacheType']['GeocacheTypeIds'] = $params['GeocacheTypeIds'];

        if(array_key_exists('GeocacheContainerSizeIds', $params) && is_array($params['GeocacheContainerSizeIds']))
            $post_params['GeocacheContainerSize']['GeocacheContainerSizeIds'] = $params['GeocacheContainerSizeIds'];

        if(array_key_exists('Archived', $params))
            $post_params['GeocacheExclusions']['Archived'] = (boolean) $params['Archived'];
        if(array_key_exists('Available', $params))
            $post_params['GeocacheExclusions']['Available'] = (boolean) $params['Available'];
        if(array_key_exists('Premium', $params))
            $post_params['GeocacheExclusions']['Premium'] = (boolean) $params['Premium'];

        if(array_key_exists('MinFavoritePoints', $params))
            $post_params['FavoritePoints']['MinFavoritePoints'] = (int) $params['MinFavoritePoints'];
        if(array_key_exists('MaxFavoritePoints', $params))
            $post_params['FavoritePoints']['MaxFavoritePoints'] = (int) $params['MaxFavoritePoints'];

        if(array_key_exists('HiddenByUsers', $params) && is_array($params['HiddenByUsers']))
            $post_params['HiddenByUsers']['UserNames'] = $params['HiddenByUsers'];

        if(array_key_exists('NotHiddenByUsers', $params) && is_array($params['NotHiddenByUsers']))
            $post_params['NotHiddenByUsers']['UserNames'] = $params['NotHiddenByUsers'];

        if(array_key_exists('BottomRightLatitude', $params))
            $post_params['Viewport']['BottomRight']['Latitude'] = (float) $params['BottomRightLatitude'];
        if(array_key_exists('BottomRightLongitude', $params))
            $post_params['Viewport']['BottomRight']['Longitude'] = (float) $params['BottomRightLongitude'];
        if(array_key_exists('TopLeftLatitude', $params))
            $post_params['Viewport']['TopLeft']['Latitude'] = (float) $params['TopLeftLatitude'];
        if(array_key_exists('TopLeftLongitude', $params))
            $post_params['Viewport']['TopLeft']['Longitude'] = (float) $params['TopLeftLongitude'];

        if(array_key_exists('BookmarkListIDs', $params) && is_array($params['BookmarkListIDs']))
            $post_params['BookmarksExclude']['BookmarkListIDs'] = $params['BookmarkListIDs'];
        if(array_key_exists('ExcludeIgnoreList', $params))
            $post_params['BookmarksExclude']['ExcludeIgnoreList'] = (boolean) $params['ExcludeIgnoreList'];

        if(array_key_exists('MinTrackables', $params))
            $post_params['TrackableCount']['MinTrackables'] = (int) $params['MinTrackables'];
        if(array_key_exists('MaxTrackables', $params))
            $post_params['TrackableCount']['MaxTrackables'] = (int) $params['MaxTrackables'];

        if(array_key_exists('UserNameFieldNotesFinds', $params))
            $post_params['FieldNoteFinds']['UserName'] = $params['UserNameFieldNotesFinds'];

        if(array_key_exists('StartDateRange', $params))
            $post_params['CachePublishedDate']['Range']['StartDate'] = '/Date('.((int) $params['StartDateRange'] * 1000).')/'; //StartDateRange is a timestamp
        if(array_key_exists('EndDateRange', $params))
            $post_params['CachePublishedDate']['Range']['EndDate'] = '/Date('.((int) $params['EndDateRange'] * 1000).')/'; //EndDateRange is a timestamp

        if(array_key_exists('StateIds', $params) && is_array($params['StateIds']))
            $post_params['States']['StateIds'] = $params['StateIds'];

        if(!array_key_exists('PointRadius', $post_params) && !array_key_exists('CacheCode', $post_params))
            throw new \Exception('PointRadius or CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $post_params))
            throw new \Exception('MaxPerPage is missing.');

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Search For Souvenirs By Public Guid
     *
     * - required param: PublicGuid
     * - optional param: ExistingSouvenirIDs
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/SearchForSouvenirsByPublicGuid Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function searchForSouvenirsByPublicGuid(array $params)
    {
        if(!array_key_exists('PublicGuid', $params))
            throw new \Exception('PublicGuid is missing.');

        $post_params['PublicGuid'] = $params['PublicGuid'];
        if(array_key_exists('ExistingSouvenirIDs', $params))
            $post_params['ExistingSouvenirIDs'] = $params['ExistingSouvenirIDs'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Update Cache Note
     *
     * - required params: CacheCode, Note
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UpdateCacheNote Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function updateCacheNote(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');
        if(!array_key_exists('Note', $params))
            throw new \Exception('Note is missing.');

        $post_params['CacheCode'] = $params['CacheCode'];
        $post_params['Note']      = $params['Note'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Upload Image To Geocache Log
     *
     * - required params: LogGuid, base64ImageData
     * - optional params: FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UploadImageToGeocacheLog Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function uploadImageToGeocacheLog(array $params)
    {
        if(!array_key_exists('LogGuid', $params))
            throw new \Exception('LogGuid is missing.');
        if(!array_key_exists('base64ImageData', $params))
            throw new \Exception('base64ImageData is missing.');

        $post_params['LogGuid'] = $params['LogGuid'];
        $post_params['ImageData']['base64ImageData'] = base64_encode($params['base64ImageData']);

        if(array_key_exists('FileCaption', $params))
            $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
        if(array_key_exists('FileDescription', $params))
            $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
        if(array_key_exists('FileName', $params))
            $post_params['ImageData']['FileName'] = $params['FileName'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

    /**
     * Upload Image To Trackable Log
     *
     * - required params: LogGuid, base64ImageData
     * - optional params: FileCaption, FileDescription, FileName
     *
     * @link https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/UploadImageToTrackableLog Documentation by Groundspeak
     * @access public
     * @param  array  $params
     * @return object
     */
    public function uploadImageToTrackableLog(array $params)
    {
        if(!array_key_exists('LogGuid', $params))
            throw new \Exception('LogGuid is missing.');
        if(!array_key_exists('base64ImageData', $params))
            throw new \Exception('base64ImageData is missing.');

        $post_params['LogGuid'] = $params['LogGuid'];
        $post_params['ImageData']['base64ImageData'] = base64_encode($params['base64ImageData']);

        if(array_key_exists('FileCaption', $params))
            $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
        if(array_key_exists('FileDescription', $params))
            $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
        if(array_key_exists('FileName', $params))
            $post_params['ImageData']['FileName'] = $params['FileName'];

        return $this->postRequest(__FUNCTION__, $post_params);
    }

}
