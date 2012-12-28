<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-1.0.php
 * @package Geocaching_Api
 */

/**
 * Geocaching API
 *
 * @category Geocaching
 * @package Geocaching_Api
 * @abstract
 */
abstract class Geocaching_Api {

    /**
     * JSON Format
     */
    const JSON_FORMAT = 0;

    /**
     * XML Format
     */
    const XML_FORMAT  = 1;

    /**
     * Staging URL of Groundspeak API
     *
     * @var string $_staging_api_url
     * @access protected
     */
    protected $_staging_api_url = 'https://staging.api.groundspeak.com/Live/V6Beta/geocaching.svc/%s';

    /**
     * Production URL of Groundspeak API
     *
     * @var string $_live_api_url
     * @access protected
     */
    protected $_live_api_url    = 'https://api.groundspeak.com/LiveV6/geocaching.svc/%s';

    /**
     * OAuth token sent by the client
     *
     * @var string $oauth_token
     * @access protected
     */
    protected $oauth_token = null;

    /**
     * Type of output expected format, JSON or XML
     *
     * @var string $output_format
     * @access protected
     */
    protected $output_format = null;

    /**
     * Constructor
     *
     * @abstract
     * @param string $oauth_token
     */
    abstract public function __construct($oauth_token);

    /**
     * Check the status of the POST or GET request
     *
     * @abstract
     * @param  string $content
     * @return void
     */
    abstract protected function checkRequestStatus($content);

    /**
     * Add Geocaches to a bookmark list
     *
     * @abstract
     * @param array $params
     * @return void
     */
    abstract public function addGeocachesToBookmarkList(array $params);

    /**
     * Create Field Note And Publish
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function createFieldNoteAndPublish(array $params);

    /**
     * Create Trackable Log
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function createTrackableLog(array $params);

    /**
     * Get Another Users Profile
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getAnotherUsersProfile(array $params);

    /**
     * Get Bookmark List By Guid
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getBookmarkListByGuid(array $params);

    /**
     * Get Geocache Status
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getGeocacheStatus(array $params);

    /**
     * Get More Geocaches
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getMoreGeocaches(array $params);

    /**
     * Get Owned Trackables
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getOwnedTrackables(array $params);

    /**
     * Get User Gallery
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getUserGallery(array $params); //new

    /**
     * Get Users Cache Counts
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getUsersCacheCounts(array $params);

    /**
     * Get Users Geocache Logs
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getUsersGeocacheLogs(array $params);

    /**
     * get Users Trackables
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getUsersTrackables(array $params);

    /**
     * Get Your User Profile
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function getYourUserProfile(array $params);

    /**
     * Save User Waypoint
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function saveUserWaypoint(array $params);

    /**
     * Search For Geocaches
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function searchForGeocaches(array $params);

    /**
     * Search For Souvenirs By Public Guid
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function searchForSouvenirsByPublicGuid(array $params);

    /**
     * Update Cache Note
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function updateCacheNote(array $params);

    /**
     * Upload Image To Geocache Log
     *
     * @abstract
     * @param  array $params
     * @return void
     */
    abstract public function uploadImageToGeocacheLog(array $params);

    /**
     * Make a GET request
     *
     * @access protected
     * @param  string $request
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    protected function get_request($request, $params = array())
    {
        $params = array_merge(array('format' => $this->output_format, 'AccessToken' => $this->oauth_token), $params);
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->_staging_api_url, ucfirst($request)) . $query_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HEADER, true);
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
     * Make a POST request
     *
     * @access protected
     * @param  string $request
     * @param  array $data
     * @return object|string JSON : Object, XML : String
     */
    protected function post_request($request, array $data)
    {
        $params = array('format' => $this->output_format);
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->_staging_api_url, ucfirst($request)) . $query_string;
        if($this->output_format == self::JSON_FORMAT) {
            $data = array_merge(array('AccessToken' => $this->oauth_token), $data);
            if (version_compare(phpversion(), '5.4', '>=')) {
                $data = json_encode($data, JSON_UNESCAPED_SLASHES);
            }
            else {
                $data = json_encode($data);
            }
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
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

    /**
     * Add Favorite Point To a Cache
     *
     * @access public
     * @param array $params
     * @return object|string JSON : Object, XML : String
     */
    public function addFavoritePointToCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Delete Cache Note
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function deleteCacheNote(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Delete User Waypoint
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function deleteUserWaypoint(array $params)
    {
        if(!array_key_exists('WaypointID', $params))
            throw new Exception('WaypointID is missing.');

        $get_params = array('WaypointID' => (int) $params['WaypointID']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get API Limits
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getAPILimits()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Attribute Types Data
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getAttributeTypesData()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Bookmark Lists By User ID
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getBookmarkListsByUserID(array $params)
    {
        if(!array_key_exists('UserID', $params))
            throw new Exception('UserID is missing.');

        $get_params = array('UserID' => (int) $params['UserID']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Bookmark Lists For User
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getBookmarkListsForUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Cache By Tile Guid
     *
     * @access public
     * @param array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getCacheByTileGuid(array $params)
    {
        if(!array_key_exists('tileGuid', $params))
            throw new Exception('tileGuid is missing.');

        $get_params = array('tileGuid' => $params['tileGuid']);
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Cache Ids Favorited By User
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getCacheIdsFavoritedByUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Caches Favorited By User
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getCachesFavoritedByUser()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Geocache Data Types
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getGeocacheDataTypes(array $params)
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
     * Get Geocache Logs By Cache Code
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getGeocacheLogsByCacheCode(array $params)
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
     * Get Geocache Types
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getGeocacheTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Images For Geocache
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getImagesForGeocache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Membership Types
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getMembershipTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Pocket Query Data
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryData(array $params)
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
     * Get Pocket Query List
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryList()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Pocket Query Urls
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryUrls(array $params)
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new Exception('PocketQueryGuid is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Pocket Query Zipped File
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryZippedFile(array $params)
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new Exception('PocketQueryGuid is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Server Details
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getServerDetails()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Site Stats
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getSiteStats()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Status Messages
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getStatusMessages()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Trackable Logs By TB Code
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackableLogsByTBCode(array $params)
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
     * Get Trackables By TB Code
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesByTBCode(array $params)
    {
        if(!array_key_exists('TBCode', $params))
            throw new Exception('TBCode is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables By Tracking Number
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesByTrackingNumber(array $params)
    {
        if(!array_key_exists('TrackingNumber', $params))
            throw new Exception('TrackingNumber is missing.');

        $get_params['TrackingNumber'] = $params['TrackingNumber'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables In Cache
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesInCache(array $params)
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
     * Get Trackable Travel List
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackableTravelList(array $params)
    {
        if(!array_key_exists('TBCode', $params))
            throw new Exception('TBCode is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Users Favorite Points
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getUsersFavoritePoints()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Get Users Cache Notes
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUsersCacheNotes(array $params)
    {
        if(!array_key_exists('MaxPerPage', $params))
            throw new Exception('MaxPerPage is missing.');

        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $params);
    }

    /**
     * Get Users Who Favorited Cache
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUsersWhoFavoritedCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get User Waypoints
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUserWaypoints(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Wpt Log Types
     *
     * @access public
     * @return object|string JSON : Object, XML : String
     */
    public function getWptLogTypes()
    {
        return $this->get_request(__FUNCTION__);
    }

    /**
     * Remove Favorite Point From Cache
     *
     * @access public
     * @param  array $params
     * @return object|string JSON : Object, XML : String
     */
    public function removeFavoritePointFromCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];
        return $this->get_request(__FUNCTION__, $get_params);
    }
}
