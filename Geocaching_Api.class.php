<?php

abstract class Geocaching_Api {

    const JSON_FORMAT = 0;
    const XML_FORMAT  = 1;

    protected $_staging_api_url = 'https://staging.api.groundspeak.com/Live/V6Beta/geocaching.svc/%s';
    protected $_live_api_url    = 'https://staging.api.groundspeak.com/Live/V6Beta/geocaching.svc/%s';// FIXME with the right URL

    protected $token = null;
    protected $output_format = null;

    abstract public function __construct($token);
    abstract protected function checkRequestStatus($content);

    abstract public function addGeocachesToBookmarkList($params = array());
    abstract public function createFieldNoteAndPublish($params = array());
    abstract public function createTrackableLog($params = array());
    abstract public function getAnotherUsersProfile($params = array());
    abstract public function getBookmarkListByGuid($params = array());
    abstract public function getGeocacheStatus($params = array());
    abstract public function getMoreGeocaches($params = array());
    abstract public function getOwnedTrackables($params = array());
    abstract public function getUserGallery($params = array()); //new
    abstract public function getUsersCacheCounts($params = array()); //new
    abstract public function getUsersGeocacheLogs($params = array()); //new
    abstract public function getUsersTrackables($params = array()); //new
    abstract public function getYourUserProfile($params = array());
    abstract public function saveUserWaypoint($params = array());
    abstract public function searchForGeocaches($params = array());
    abstract public function searchForSouvenirsByPublicGuid($params = array());
    abstract public function updateCacheNote($params = array());
    abstract public function uploadImageToGeocacheLog($params = array());
    abstract public function registerUsersMobileDevice($params = array()); //new
    abstract public function registerWP7DeviceTile($params = array()); //new
    abstract public function unregisterUsersMobileDevice($params = array()); //new
    abstract public function windowsPhoneTileSearch($params = array()); //new

    /**
     * [get_request description]
     * @param  [type] $request [description]
     * @param  array  $params  [description]
     * @return [type]          [description]
     */
    protected function get_request($request, $params = array())
    {
        $params = array_merge(array('format' => $this->output_format, 'AccessToken' => $this->token), $params);
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->_staging_api_url, $request) . $query_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
		//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		//curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if($status['http_code'] != 200) {
            throw new Exception('HTTP error : ' . $status['http_code']);
        }
        if($this->output_format == self::JSON_FORMAT)
            $output = json_decode($output);
        $this->checkRequestStatus($output);

        return $output;
    }

    /**
     * [post_request description]
     * @param  [type] $request [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    protected function post_request($request, $data)
    {
        $params = array('format' => $this->output_format);
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->_staging_api_url, $request) . $query_string;
        if($this->output_format == self::JSON_FORMAT) {
            $data = array_merge(array('AccessToken' => $this->token), $data);
            //print_r($data);
            if (version_compare(phpversion(), '5.4', '>=')) {
                $data = json_encode($data, JSON_UNESCAPED_SLASHES);
            }
            else {
                $data = json_encode($data);
            }
            //print_r($data);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if($status['http_code'] != 200) {
            throw new Exception('HTTP error : ' . $status['http_code']);
        }
        if($this->output_format == self::JSON_FORMAT)
            $output = json_decode($output);

        $this->checkRequestStatus($output);
        return $output;
    }

    /**
     * List of GET methods from Geocaching API
     */
    public function addFavoritePointToCache($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [deleteCacheNote description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function deleteCacheNote($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [deleteUserWaypoint description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function deleteUserWaypoint($params = array())
    {
        if(!array_key_exists('WaypointID', $params))
            throw new Exception('WaypointID is missing.');

        $get_params = array('WaypointID' => (int) $params['WaypointID']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getAPILimits description]
     * @return [type] [description]
     */
    public function getAPILimits()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getAttributeTypesData description]
     * @return [type] [description]
     */
    public function getAttributeTypesData()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getBookmarkListsByUserID description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getBookmarkListsByUserID($params = array())
    {
        if(!array_key_exists('UserID', $params))
            throw new Exception('UserID is missing.');

        $get_params = array('UserID' => (int) $params['UserID']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getBookmarkListsForUser description]
     * @return [type] [description]
     */
    public function getBookmarkListsForUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [GetCacheByTileGuid description]
     * @param array $params [description]
     */
    public function GetCacheByTileGuid($params = array())
    {
        if(!array_key_exists('tileGuid', $params))
            throw new Exception('tileGuid is missing.');

        $get_params = array('tileGuid' => $params['tileGuid']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getCacheIdsFavoritedByUser description]
     * @return [type] [description]
     */
    public function getCacheIdsFavoritedByUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getCachesFavoritedByUser description]
     * @return [type] [description]
     */
    public function getCachesFavoritedByUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getGeocacheDataTypes description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getGeocacheDataTypes($params = array())
    {
        $get_params = array();
        if(array_key_exists('GeocacheTypes', $params))
            $get_params['GeocacheTypes'] = (boolean) $params['GeocacheTypes'] ? 'true' : 'false';
        if(array_key_exists('LogTypes', $params))
            $get_params['LogTypes'] = (boolean) $params['LogTypes'] ? 'true' : 'false';
        if(array_key_exists('AttributeTypes', $params))
            $get_params['AttributeTypes'] = (boolean) $params['AttributeTypes'] ? 'true' : 'false';

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getGeocacheLogsByCacheCode description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getGeocacheLogsByCacheCode($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getGeocacheTypes description]
     * @return [type] [description]
     */
    public function getGeocacheTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getImagesForGeocache description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getImagesForGeocache($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getMembershipTypes description]
     * @return [type] [description]
     */
    public function getMembershipTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getPocketQueryData description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getPocketQueryData($params = array())
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new Exception('PocketQueryGuid is missing.');
        if(!array_key_exists('MaxItems', $params))
            throw new Exception('MaxItems is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];
        $get_params['MaxItems'] = (int) $params['MaxItems'];
        if(array_key_exists('StartItem', $params))
            $get_params['StartItem'] = (int) $params['StartItem'];
        if(array_key_exists('GCListOnly', $params))
            $get_params['GCListOnly'] = (boolean) $params['GCListOnly'] ? 'true' : 'false';

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getPocketQueryList description]
     * @return [type] [description]
     */
    public function getPocketQueryList()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getPocketQueryUrls description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getPocketQueryUrls($params = array())
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new Exception('PocketQueryGuid is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getPocketQueryZippedFile description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getPocketQueryZippedFile($params = array())
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new Exception('PocketQueryGuid is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getServerDetails description]
     * @return [type] [description]
     */
    public function getServerDetails()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getSiteStats description]
     * @return [type] [description]
     */
    public function getSiteStats()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getStatusMessages description]
     * @return [type] [description]
     */
    public function getStatusMessages()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [getTrackableLogsByTBCode description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getTrackableLogsByTBCode($params = array())
    {
        if(!array_key_exists('TBCode', $params))
            throw new Exception('TBCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getTrackablesByTBCode description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getTrackablesByTBCode($params = array())
    {
        if(!array_key_exists('TBCode', $params))
            throw new Exception('TBCode is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getTrackablesByTrackingNumber description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getTrackablesByTrackingNumber($params = array())
    {
        if(!array_key_exists('TrackingNumber', $params))
            throw new Exception('TrackingNumber is missing.');

        $get_params['TrackingNumber'] = $params['TrackingNumber'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getTrackablesInCache description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getTrackablesInCache($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $params);
    }

    /**
     * [getTrackableTravelList description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getTrackableTravelList($params = array())
    {
        if(!array_key_exists('TBCode', $params))
            throw new Exception('TBCode is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getUsersFavoritePoints description]
     * @return [type] [description]
     */
    public function getUsersFavoritePoints()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [GetUsersCacheNotes description]
     */
    public function GetUsersCacheNotes()
    {
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $params);
    }

    /**
     * [getUsersWhoFavoritedCache description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUsersWhoFavoritedCache($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getUserWaypoints description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getUserWaypoints($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * [getWptLogTypes description]
     * @return [type] [description]
     */
    public function getWptLogTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * [removeFavoritePointFromCache description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function removeFavoritePointFromCache($params = array())
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }
}
