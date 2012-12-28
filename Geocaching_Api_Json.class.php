<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-1.0.php
 * @package Geocaching_Api
 */

require_once 'Geocaching_Api.class.php';

/**
 * Geocaching API for JSON format
 *
 * @category Geocaching
 * @package Geocaching_Api
 */
class Geocaching_Api_Json extends Geocaching_Api {

    /**
     * Constructor
     *
     * @access public
     * @param string $oauth_token OAuth token provided by the application
     * @return void
     */
    public function __construct($oauth_token)
    {
        if(!isset($oauth_token))
            throw new Exception('oauth_token is missing.');

        $this->oauth_token   = $oauth_token;
        $this->output_format = 'json';
        $this->http_headers  = array('Content-Type: application/json');
    }

    /**
     * Check the status of the POST or GET request in JSON
     *
     * @access protected
     * @param  object $content
     * @return void
     */
    protected function checkRequestStatus($content)
    {
        if(!empty($content->Status->StatusCode)) {
            throw new Exception($content->Status->StatusMessage . ' (StatusCode: ' . $content->Status->StatusCode . ')');
        }
    }

    /**
    * List of POST methods from Geocaching API
    */

    /**
     * Add Geocaches To Bookmark List
     *
     * Required params: BookmarkListGuid, CacheCodes
     *
     * @access public
     * @param array $params
     * @return object
     */
    public function addGeocachesToBookmarkList(array $params)
    {
        if(!array_key_exists('BookmarkListGuid', $params))
            throw new Exception('BookmarkListGuid is missing.');
        if(!array_key_exists('CacheCodes', $params))
            throw new Exception('CacheCodes is missing.');
        if(!is_array($params['cacheCodes']))
            throw new Exception('cacheCodes must be an array.');

        $post_params['BookmarkListGuid'] = $bookmarkListGuid;
        $post_params['CacheCodes'] = $cacheCodes;

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Create Field Note And Publish
     *
     * Required params: CacheCode, WptLogTypeId, UTCDateLogged, Note<br>
     * Optional params: PromoteToLog, FavoriteThisCache, EncryptLogText, UpdatedLatitude, UpdatedLongitude, base64ImageData, FileCaption, FileDescription, FileName
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function createFieldNoteAndPublish(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');
        if(!array_key_exists('WptLogTypeId', $params))
            throw new Exception('WptLogTypeId is missing.');
        if(!array_key_exists('UTCDateLogged', $params))
            throw new Exception('UTCDateLogged is missing.');
        if(!array_key_exists('Note', $params))
            throw new Exception('Note is missing.');

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

        if(array_key_exists('base64ImageData', $params)) {
            $post_params['ImageData']['base64ImageData'] = $params['base64ImageData'];
            if(array_key_exists('FileCaption', $params))
                $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
            if(array_key_exists('FileDescription', $params))
                $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
            if(array_key_exists('FileName', $params))
                $post_params['ImageData']['FileName'] = $params['FileName'];
        }

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Create Trackable Log
     *
     * Required params: TrackingNumber, UTCDateLogged, Note, LogType
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function createTrackableLog(array $params)
    {
        if(!array_key_exists('TrackingNumber', $params))
            throw new Exception('TrackingNumber is missing.');
        if(!array_key_exists('UTCDateLogged', $params))
            throw new Exception('UTCDateLogged is missing.');
        if(!array_key_exists('Note', $params))
            throw new Exception('Note is missing.');
        if(!array_key_exists('LogType', $params))
            throw new Exception('LogType is missing.');

        $post_params['TrackingNumber'] = $params['TrackingNumber'];
        $post_params['UTCDateLogged'] = '/Date('.((int) $params['UTCDateLogged'] * 1000).')/'; //UTCDateLogged is a timestamp
        $post_params['Note'] = $params['Note'];
        $post_params['LogType'] = (int) $params['LogType'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Bookmark List By Guid
     *
     * required param: BookmarkListGuid
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getBookmarkListByGuid(array $params)
    {
        if(!array_key_exists('BookmarkListGuid', $params))
            throw new Exception('BookmarkListGuid is missing.');

        $post_params['BookmarkListGuid'] = $bookmarkListGuid;
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Geocache Status
     *
     * required param: CacheCodes
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getGeocacheStatus(array $params)
    {
        if(!array_key_exists('CacheCodes', $params))
            throw new Exception('CacheCodes is missing.');

        $post_params['CacheCodes'] = $params;
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get More Geocaches
     *
     * required params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getMoreGeocaches(array $params)
    {
        if(!array_key_exists('IsLite', $params))
            throw new Exception('IsLite is missing.');
        if(!array_key_exists('StartIndex', $params))
            throw new Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');
        if(!array_key_exists('GeocacheLogCount', $params))
            throw new Exception('GeocacheLogCount is missing.');
        if(!array_key_exists('TrackableLogCount', $params))
            throw new Exception('TrackableLogCount is missing.');

        $post_params['IsLite']  = (boolean) $params['IsLite'];
        $post_params['StartIndex']  = (int) $params['StartIndex'];
        $post_params['MaxPerPage']  = (int) $params['MaxPerPage'];
        $post_params['GeocacheLogCount']  = (int) $params['GeocacheLogCount'];
        $post_params['TrackableLogCount']  = (int) $params['TrackableLogCount'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get User Gallery
     *
     * required params: Username, StartIndex, MaxPerPage
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getUserGallery(array $params)
    {
        if(!array_key_exists('Username', $params))
            throw new Exception('Username is missing.');
        if(!array_key_exists('StartIndex', $params))
            throw new Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $post_params['Username'] = $params['Username'];
        $post_params['StartIndex'] = (int) $params['StartIndex'];
        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
    }

    /**
     * Get Users Cache Counts
     *
     * required param: Username
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getUsersCacheCounts(array $params)
    {
        if(!array_key_exists('Username', $params))
            throw new Exception('Username is missing.');
        if(!is_array($params['Username']))
            throw new Exception('Username must be an array.');

        $post_params['Username'] = $params['Username'];
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Owned Trackables
     *
     * required params: StartIndex, MaxPerPage<br>
     * optional params: TrackableLogCount, CollectionOnly
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getOwnedTrackables(array $params)
    {
        if(!array_key_exists('StartIndex', $params))
            throw new Exception('StartIndex is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $post_params['StartIndex'] = (int) $params['StartIndex'];
        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('TrackableLogCount', $params))
            $post_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];
        if(array_key_exists('CollectionOnly', $params))
            $post_params['CollectionOnly'] = (boolean) $params['CollectionOnly'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Geocache Logs
     *
     * required params: Username, LogTypes, MaxPerPage<br>
     * optional params: StartIndex, EndDate, StartDate, ExcludeArchived
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getUsersGeocacheLogs(array $params)
    {
        if(!array_key_exists('Username', $params))
            throw new Exception('Username is missing.');
        if(!array_key_exists('LogTypes', $params))
            throw new Exception('LogTypes is missing.');
        if(!is_array($params['LogTypes']))
            throw new Exception('Username must be an array.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

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

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Users Trackables
     *
     * required param: MaxPerPage<br>
     * optional params: StartIndex, TrackableLogCount, CollectionOnly
     * @access public
     * @param  array $params
     * @return object
     */
    public function getUsersTrackables(array $params)
    {
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $post_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $post_params['StartIndex'] = (int) $params['StartIndex'];
        if(array_key_exists('TrackableLogCount', $params))
            $post_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];
        if(array_key_exists('CollectionOnly', $params))
            $post_params['CollectionOnly'] = (boolean) $params['CollectionOnly'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get Your User Profile
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getYourUserProfile(array $params)
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * Get Another Users Profile
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function getAnotherUsersProfile(array $params)
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * Save User Waypoint
     *
     * required params: CacheCode, Latitude, Longitude
     * optional param: Description
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function saveUserWaypoint(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');
        if(!array_key_exists('Latitude', $params))
            throw new Exception('Latitude is missing.');
        if(!array_key_exists('Longitude', $params))
            throw new Exception('Longitude is missing.');

        /*if(!array_key_exists('ID', $params)) // ID is autoincrement, WTF ?
            throw new Exception('ID is missing.');*/

        $post_params['CacheCode']   = $params['CacheCode'];
        $post_params['Latitude']    = (float) $params['Latitude'];
        $post_params['Longitude']   = (float) $params['Longitude'];
        if(array_key_exists('Description', $params))
            $post_params['Description'] = $params['Description'];
        //$post_params['ID']          = (int) $params['ID'];*/

        return $this->post_request(__FUNCTION__, $params);
    }

    /**
     * Search For Geocaches
     *
     * required params: PointRadius or CacheCode, MaxPerPage<br>
     * optional params: IsLite, StartIndex, MaxPerPage, GeocacheLogCount, TrackableLogCount, DistanceInMeters, PointRadiusLatitude
     * PointRadiusLongitude, NotFoundByUsers, MinTerrain, MaxTerrain, GeocacheName, MinDifficulty, MaxDifficulty, CacheCodes, GeocacheTypeIds
     * GeocacheContainerSizeIds, Archived, Available, Premium, MinFavoritePoints, MaxFavoritePoints, HiddenByUsers, NotHiddenByUsers,
     * BottomRightLatitude, BottomRightLongitude, TopLeftLatitude, TopLeftLongitude, BookmarkListIDs, MinTrackables, MaxTrackables
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function searchForGeocaches(array $params)
    {
        if(array_key_exists('IsLite', $params))
            $post_params['IsLite'] = (boolean) $params['IsLite'];
        if(array_key_exists('StartIndex', $params))
            $post_params['StartIndex'] = (int) $params['StartIndex'];
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

        if(array_key_exists('MinTrackables', $params))
            $post_params['TrackableCount']['MinTrackables'] = (int) $params['MinTrackables'];
        if(array_key_exists('MaxTrackables', $params))
            $post_params['TrackableCount']['MaxTrackables'] = (int) $params['MaxTrackables'];

        if(!array_key_exists('PointRadius', $post_params) && !array_key_exists('CacheCode', $post_params))
            throw new Exception('PointRadius or CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $post_params))
            throw new Exception('MaxPerPage is missing.');

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Search For Souvenirs By Public Guid
     *
     * required param: PublicGuid<br>
     * optional param: ExistingSouvenirIDs
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function searchForSouvenirsByPublicGuid(array $params)
    {
        if(!array_key_exists('PublicGuid', $params))
            throw new Exception('PublicGuid is missing.');

        $post_params['PublicGuid'] = $params['PublicGuid'];
        if(array_key_exists('ExistingSouvenirIDs', $params))
            $post_params['ExistingSouvenirIDs'] = $params['ExistingSouvenirIDs'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Update Cache Note
     *
     * required params: CacheCode, Note
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function updateCacheNote(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');
        if(!array_key_exists('Note', $params))
            throw new Exception('Note is missing.');

        $post_params['CacheCode'] = $params['CacheCode'];
        $post_params['Note']      = $params['Note'];
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Upload Image To Geocache Log
     *
     * required params: LogGuid, base64ImageData<br>
     * optional params: FileCaption, FileDescription, FileName
     *
     * @access public
     * @param  array $params
     * @return object
     */
    public function uploadImageToGeocacheLog(array $params)
    {
        if(!array_key_exists('LogGuid', $params))
            throw new Exception('LogGuid is missing.');
        if(!array_key_exists('base64ImageData', $params))
            throw new Exception('base64ImageData is missing.');

        $post_params['LogGuid'] = $params['LogGuid'];

        if(array_key_exists('FileCaption', $params))
            $post_params['ImageData']['FileCaption'] = $params['FileCaption'];
        if(array_key_exists('FileDescription', $params))
            $post_params['ImageData']['FileDescription'] = $params['FileDescription'];
        if(array_key_exists('FileName', $params))
            $post_params['ImageData']['FileName'] = $params['FileName'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * Get User Profile
     *
     * Internal method for getYourUserProfile or getAnotherUsersProfile<br>
     * optional params: UserID, FavoritePointsData, GeocacheData, PublicProfileData, ProfileOptions, SouvenirData, ProfileOptions<br>
     * if the method is getYourUserProfile, there are some required params (DeviceInfo) but are useful only for mobile application
     *
     * @access protected
     * @param  string $function
     * @param  array $params
     * @return object
     */
    protected function getUserProfile($function, array $params)
    {
        $post_params = array();
        if(array_key_exists('UserID', $params))
            $post_params['UserID'] = $userID;
        if(array_key_exists('FavoritePointsData', $params))
            $post_params['ProfileOptions']['FavoritePointsData'] = (boolean) $params['FavoritePointsData'];
        if(array_key_exists('GeocacheData', $params))
            $post_params['ProfileOptions']['GeocacheData'] = (boolean) $params['GeocacheData'];
        if(array_key_exists('PublicProfileData', $params))
            $post_params['ProfileOptions']['PublicProfileData'] = (boolean) $params['PublicProfileData'];
        if(array_key_exists('SouvenirData', $params))
            $post_params['ProfileOptions']['SouvenirData'] = (boolean) $params['SouvenirData'];
        if(array_key_exists('TrackableData', $params))
            $post_params['ProfileOptions']['TrackableData'] = (boolean) $params['TrackableData'];
        if($function == 'getYourUserProfile')
        {
            $post_params['DeviceInfo']['ApplicationCurrentMemoryUsage'] = 2048*1024;
            $post_params['DeviceInfo']['ApplicationPeakMemoryUsage']    = 2048*1024;
            $post_params['DeviceInfo']['ApplicationSoftwareVersion']    = 'blabla';
            $post_params['DeviceInfo']['DeviceManufacturer']            = 'blabla';
            $post_params['DeviceInfo']['DeviceName']                    = 'blabla';
            $post_params['DeviceInfo']['DeviceOperatingSystem']         = 'blabla';
            $post_params['DeviceInfo']['DeviceTotalMemoryInMB']         = 2048*1024;
            $post_params['DeviceInfo']['DeviceUniqueId']                = 'blabla';
            $post_params['DeviceInfo']['MobileHardwareVersion']         = 'blabla';
            $post_params['DeviceInfo']['WebBrowserVersion']             = 'blabla';
        }
        return $this->post_request($function, $post_params);
    }
}
