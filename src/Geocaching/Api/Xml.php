<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-1.0.php
 * @package Geocaching\Api
 */

namespace Geocaching\Api;

/**
 * Geocaching API for XML format
 *
 * @package Geocaching\Api
 */
class Xml extends Api
{
    /**
     * Geocaching XML Namespace
     *
     * @var string
     * @access private
     */
    private $xmlns_geocaching = 'http://www.geocaching.com/Geocaching.Live/data';

    /**
     * Geocaching XML namespace schema
     *
     * @var string
     * @access private
     */
    private $xmlns_schema     = 'http://schemas.datacontract.org/2004/07/Tucson.Geocaching.WCF.API.Geocaching.Types';

    /**
     * Constructor
     *
     * @access public
     * @param  string  $oauth_token OAuth token provided by the application
     * @param  boolean $live        production = true, staging = false
     * @return void
     */
    public function __construct($oauth_token, $live = false)
    {
        if(!isset($oauth_token))
            throw new Exception('oauth_token is missing.');

        $this->oauth_token   = $oauth_token;
        $this->output_format = 'xml';
        $this->http_headers  = array('Content-Type: application/xml');
        if ($live) {
            $this->api_url = $this->live_api_url;
        } else {
            $this->api_url = $this->staging_api_url;
        }
    }

    /**
     * Check the status of the POST or GET request in XML
     *
     * @access protected
     * @param  object $content
     * @return void
     */
    protected function checkRequestStatus($content) {}

    /**
     * [prependXml description]
     *
     * @access protected
     * @param  [type] $method [description]
     * @return object Dom Document
     */
    protected function prependXml($method)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement($method);
        $node = $dom->appendChild($root);
        $node->setAttribute("xmlns", $this->xmlns_geocaching);

        $eAccessToken = $dom->createElement('AccessToken');
        $root->appendChild($eAccessToken);
        $text = $dom->createTextNode(utf8_encode($this->oauth_token));
        $eAccessToken->appendChild($text);

        return $dom;
    }

    /**
     * List of POST methods from Geocaching API
     */

    /**
     * [addGeocachesToBookmarkList description]
     *
     * @access public
     * @param array $params [description]
     */
    public function addGeocachesToBookmarkList(array $params) {}

    /**
     * [createFieldNoteAndPublish description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function createFieldNoteAndPublish(array $params) {}

    /**
     * [createTrackableLog description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function createTrackableLog(array $params) {}

    /**
     * [getAnotherUsersProfile description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function getAnotherUsersProfile(array $params) {}

    /**
     * [getBookmarkListByGuid description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function getBookmarkListByGuid(array $params) {}

    /**
     * [getGeocacheStatus description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function getGeocacheStatus(array $params) {}

    /**
     * [getMoreGeocaches description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function getMoreGeocaches(array $params) {}

    /**
     * [getYourUserProfile description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function getYourUserProfile(array $params)
    {
        $dom = $this->prependXml('GetYourUserProfileRequest');
        $eProfileOptions = $dom->createElement('ProfileOptions');
        $method = $dom->getElementsByTagName('GetYourUserProfileRequest')->item(0);
        $method->appendChild($eProfileOptions);
        foreach ($params as $option => $value) {
            $eOption = $dom->createElement($option);
            $eProfileOptions->appendChild($eOption);
            $text = $dom->createTextNode(utf8_encode($value ? 'true':'false'));
            $eOption->appendChild($text);
            $eOption->setAttribute("xmlns", $this->xmlns_schema);
        }

        return $this->post_request(__FUNCTION__, $dom->saveXML());
    }

    /**
     * [saveUserWaypoint description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function saveUserWaypoint(array $params) {}

    /**
     * [searchForGeocaches description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function searchForGeocaches(array $params) {}

    /**
     * [searchForSouvenirsByPublicGuid description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function searchForSouvenirsByPublicGuid(array $params) {}

    /**
     * [updateCacheNote description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function updateCacheNote(array $params) {}

    /**
     * [uploadImageToGeocacheLog description]
     *
     * @access public
     * @param  array  $params [description]
     * @return [type] [description]
     */
    public function uploadImageToGeocacheLog(array $params) {}

}
