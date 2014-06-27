<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-2.0.php
 * @package Geocaching\Api
 */

namespace Geocaching\Api;

use Katzgrau\KLogger\Logger;

/**
 * Abstract class for Geocaching API
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-2.0.php
 * @package Geocaching\Api
 * @abstract
 */
abstract class AbstractGeocachingApi
{
    /**
     * Staging URL of Groundspeak API
     *
     * @access protected
     * @var string $staging_api_url
     */
    protected $staging_api_url = 'https://staging.api.groundspeak.com/Live/V6Beta/geocaching.svc/%s';

    /**
     * Production URL of Groundspeak API
     *
     * @access protected
     * @var string $live_api_url
     */
    protected $live_api_url    = 'https://api.groundspeak.com/LiveV6/geocaching.svc/%s';

    /**
     * API URL
     *
     * @access protected
     * @var string $api_url
     */
    protected $api_url = null;

    /**
     * OAuth token sent by the client
     *
     * @access protected
     * @var string $oauth_token
     */
    protected $oauth_token = null;

    /**
     * Log API requests in a file
     *
     * @access protected
     * @var string $log
     */
    protected $logging = false;

    /**
     * Constructor
     *
     * @abstract
     * @param string  $oauth_token
     * @param boolean $live
     */
    abstract public function __construct($oauth_token, $live);

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
     * @param  array $params
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
    abstract public function getAnotherUsersProfile($params = array());

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
    abstract public function getYourUserProfile($params = array());

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
     * @param  string        $request
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    protected function get_request($request, $params = array())
    {
        $this->log($request, $params);

        $params = array_merge(array('format' => 'json', 'AccessToken' => $this->oauth_token), $params);
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->api_url, ucfirst($request)) . $query_string;

        $this->log('curl_params', $params);
        $this->log('curl_url', $url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        $this->log('curl_exec', $output);

        $status = curl_getinfo($ch);
        $this->log('curl_getinfo', $status);

        curl_close($ch);

        if($status['http_code'] != 200)
            throw new \Exception('HTTP error : ' . $status['http_code']);

        $output = json_decode($output);

        $this->checkRequestStatus($output);

        return $output;
    }

    /**
     * Make a POST request
     *
     * @access protected
     * @param  string        $request
     * @param  array         $data
     * @return object|string JSON : Object, XML : String
     */
    protected function post_request($request, array $data)
    {
        $this->log($request);

        $params = array('format' => 'json');
        $query_string = '?' . urldecode(http_build_query($params, '', '&'));
        $url = sprintf($this->api_url, ucfirst($request)) . $query_string;
        $data = array_merge(array('AccessToken' => $this->oauth_token), $data);
        $data = json_encode($data);

        $this->log('curl_params', $params);
        $this->log('curl_url', $url);
        $this->log('curl_data', $data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        $this->log('curl_exec', $output);

        $status = curl_getinfo($ch);
        $this->log('curl_getinfo', $status);

        curl_close($ch);

        if($status['http_code'] != 200)
            throw new \Exception('HTTP error : ' . $status['http_code']);

        $output = json_decode($output);

        $this->checkRequestStatus($output);

        return $output;
    }

    /**
     * Enable or disable log messages
     *
     * @param  string $directory
     * @return void
     */
    public function setLogging($directory)
    {
        if ($directory) {
            $this->logger = new Logger($directory);
            $this->logging = true;
        }
        if ($this->logging && !$directory) {
            unset($this->logger);
            $this->logging = false;
        }
    }

    /**
     * Log informations into the log file
     * @param  string $infos
     * @param  array  $obj
     * @return void
     */
    protected function log($infos, $obj = false)
    {
        if (!$this->logging) {
            return false;
        }
        if (!is_array($obj)) {
            $obj = [$obj];
        }
        $this->logger->debug('API: ' . $infos, $obj);
    }

    /**
     * List of GET methods from Geocaching API
     */

    /**
     * Add Favorite Point To a Cache
     *
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function addFavoritePointToCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Delete Cache Note
     *
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function deleteCacheNote(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

        $get_params = array('CacheCode' => $params['CacheCode']);

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Delete User Waypoint
     *
     * required param: WaypointID
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function deleteUserWaypoint(array $params)
    {
        if(!array_key_exists('WaypointID', $params))
            throw new \Exception('WaypointID is missing.');

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
     * required param: UserID
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getBookmarkListsByUserID(array $params)
    {
        if(!array_key_exists('UserID', $params))
            throw new \Exception('UserID is missing.');

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
     * required param: tileGuid
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getCacheByTileGuid(array $params)
    {
        if(!array_key_exists('tileGuid', $params))
            throw new \Exception('tileGuid is missing.');

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
     * optional params: GeocacheTypes, LogTypes, AttributeTypes
     *
     * @access public
     * @param  array         $params
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
     * required params: CacheCode, MaxPerPage<br>
     * optional param: StartIndex
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getGeocacheLogsByCacheCode(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

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
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getImagesForGeocache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

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
     * required params: PocketQueryGuid, MaxItems<br>
     * optional params: StartItem, GCListOnly
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryData(array $params)
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new \Exception('PocketQueryGuid is missing.');
        if(!array_key_exists('MaxItems', $params))
            throw new \Exception('MaxItems is missing.');

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
     * required param: PocketQueryGuid
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryUrls(array $params)
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new \Exception('PocketQueryGuid is missing.');

        $get_params['PocketQueryGuid'] = $params['PocketQueryGuid'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Pocket Query Zipped File
     *
     * required param: PocketQueryGuid
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getPocketQueryZippedFile(array $params)
    {
        if(!array_key_exists('PocketQueryGuid', $params))
            throw new \Exception('PocketQueryGuid is missing.');

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
     * required params: TBCode, MaxPerPage<br>
     * optional param: StartIndex
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackableLogsByTBCode(array $params)
    {
        if(!array_key_exists('TBCode', $params))
            throw new \Exception('TBCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables By TB Code
     *
     * required param: TBCode
     * optional param: TrackableLogCount
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesByTBCode(array $params)
    {
        if(!array_key_exists('TBCode', $params))
            throw new \Exception('TBCode is missing.');

        $get_params['TBCode'] = $params['TBCode'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables By Tracking Number
     *
     * required param: TrackingNumber<br>
     * optional param: TrackableLogCount
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesByTrackingNumber(array $params)
    {
        if(!array_key_exists('TrackingNumber', $params))
            throw new \Exception('TrackingNumber is missing.');

        $get_params['TrackingNumber'] = $params['TrackingNumber'];
        if(array_key_exists('TrackableLogCount', $params))
            $get_params['TrackableLogCount'] = (int) (boolean) $params['TrackableLogCount'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get Trackables In Cache
     *
     * required params: CacheCode, MaxPerPage<br>
     * optional params: StartIndex, TrackableLogCount
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackablesInCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

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
     * required param: TBCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getTrackableTravelList(array $params)
    {
        if(!array_key_exists('TBCode', $params))
            throw new \Exception('TBCode is missing.');

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
     * required param: MaxPerPage<br>
     * optional param: StartIndex
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUsersCacheNotes(array $params)
    {
        if(!array_key_exists('MaxPerPage', $params))
            throw new \Exception('MaxPerPage is missing.');

        $get_params['MaxPerPage'] = (int) $params['MaxPerPage'];
        if(array_key_exists('StartIndex', $params))
            $get_params['StartIndex'] = (int) $params['StartIndex'];

        return $this->get_request(__FUNCTION__, $params);
    }

    /**
     * Get Users Who Favorited Cache
     *
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUsersWhoFavoritedCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];

        return $this->get_request(__FUNCTION__, $get_params);
    }

    /**
     * Get User Waypoints
     *
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function getUserWaypoints(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

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
     * required param: CacheCode
     *
     * @access public
     * @param  array         $params
     * @return object|string JSON : Object, XML : String
     */
    public function removeFavoritePointFromCache(array $params)
    {
        if(!array_key_exists('CacheCode', $params))
            throw new \Exception('CacheCode is missing.');

        $get_params['CacheCode'] = $params['CacheCode'];

        return $this->get_request(__FUNCTION__, $get_params);
    }
}
