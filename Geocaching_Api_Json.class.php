<?php

require_once 'Geocaching_Api.class.php';

class Geocaching_Api_Json extends Geocaching_Api {

    /**
     * [__construct description]
     * @param [type] $token [description]
     */
    public function __construct($token)
    {
        if(!isset($token))
            throw new Exception('token is missing.');

        $this->token         = $token;
        $this->output_format = 'json';
        $this->http_headers  = array('Content-Type: application/json');
    }

    /**
     * [checkRequestStatus description]
     * @param  [type] $content [description]
     * @return [type]          [description]
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
     * [addGeocachesToBookmarkList description]
     * @param array $params [description]
     */
    public function addGeocachesToBookmarkList($params = array())
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
     * [createFieldNoteAndPublish description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function createFieldNoteAndPublish($params = array())
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
     * [createTrackableLog description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function createTrackableLog($params = array())
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
     * [getBookmarkListByGuid description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getBookmarkListByGuid($params = array())
    {
        if(!array_key_exists('BookmarkListGuid', $params))
            throw new Exception('BookmarkListGuid is missing.');

        $post_params['BookmarkListGuid'] = $bookmarkListGuid;
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [getGeocacheStatus description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getGeocacheStatus($params = array())
    {
        if(empty($params))
            throw new Exception('cacheCodes is missing.');

        $post_params['CacheCodes'] = $params;
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [getMoreGeocaches description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getMoreGeocaches($params = array())
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
     * [getUserGallery description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUserGallery($params = array())
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
     * [getUsersCacheCounts description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUsersCacheCounts($params = array())
    {
        if(!array_key_exists('Username', $params))
            throw new Exception('Username is missing.');
        if(!is_array($params['Username']))
            throw new Exception('Username must be an array.');

        $post_params['Username'] = $params['Username'];
        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [getOwnedTrackables description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getOwnedTrackables($params = array())
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
     * [getUsersGeocacheLogs description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUsersGeocacheLogs($params = array())
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
            $post_params['Range']['EndDate'] = '/Date('.((int) $params['EndDate'] * 1000).')/'; //EndDate is a timestamp,
        if(array_key_exists('StartDate', $params))
            $post_params['Range']['StartDate'] = '/Date('.((int) $params['StartDate'] * 1000).')/'; //StartDate is a timestamp,
        if(array_key_exists('ExcludeArchived', $params))
            $post_params['ExcludeArchived'] = (boolean) $params['ExcludeArchived'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [getUsersTrackables description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUsersTrackables($params = array())
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
     * [getYourUserProfile description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getYourUserProfile($params = array())
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * [getAnotherUsersProfile description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getAnotherUsersProfile($params = array())
    {
        return $this->getUserProfile(__FUNCTION__, $params);
    }

    /**
     * [saveUserWaypoint description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function saveUserWaypoint($params = array())
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
     * [searchForGeocaches description]
     * @param  array  $params [description]
     * @return object         [description]
     */
    public function searchForGeocaches($params = array())
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
        if(array_key_exists('MinTerrain', $params))
            $post_params['Terrain']['MaxTerrain'] = (float) $params['MaxTerrain'];

        if(array_key_exists('GeocacheName', $params))
            $post_params['GeocacheName']['GeocacheName'] = $params['GeocacheName'];

        if(array_key_exists('MinDifficulty', $params))
            $post_params['Difficulty']['MinDifficulty'] = (float) $params['MinDifficulty'];
        if(array_key_exists('MaxDifficulty', $params))
            $post_params['Difficulty']['MaxTerrain'] = (float) $params['MaxDifficulty'];

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
        if(array_key_exists('MaxFavoritePoints', $params))
            $post_params['TrackableCount']['MaxTrackables'] = (int) $params['MaxTrackables'];

        if(!array_key_exists('PointRadius', $post_params) && !array_key_exists('CacheCode', $post_params))
            throw new Exception('PointRadius or CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $post_params))
            throw new Exception('MaxPerPage is missing.');

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [searchForSouvenirsByPublicGuid description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function searchForSouvenirsByPublicGuid($params = array())
    {
        if(!array_key_exists('PublicGuid', $params))
            throw new Exception('PublicGuid is missing.');

        $post_params['PublicGuid'] = $params['PublicGuid'];
        if(array_key_exists('ExistingSouvenirIDs', $params))
            $post_params['ExistingSouvenirIDs'] = $params['ExistingSouvenirIDs'];

        return $this->post_request(__FUNCTION__, $post_params);
    }

    /**
     * [updateCacheNote description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function updateCacheNote($params = array())
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
     * [uploadImageToGeocacheLog description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function uploadImageToGeocacheLog($params = array())
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
     * [registerUsersMobileDevice description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function registerUsersMobileDevice($params = array())
    {
        
    }

    /**
     * [registerWP7DeviceTile description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function registerWP7DeviceTile($params = array())
    {
        
    }

    /**
     * [unregisterUsersMobileDevice description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function unregisterUsersMobileDevice($params = array())
    {
        
    }

    /**
     * [windowsPhoneTileSearch description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function windowsPhoneTileSearch($params = array())
    {
        
    }

    /**
     * [getUserProfile description]
     * @param  [type] $function [description]
     * @param  [type] $params   [description]
     * @return [type]           [description]
     */
    protected function getUserProfile($function, $params)
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
