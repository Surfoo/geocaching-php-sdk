<?php

require_once 'Geocaching_Api.class.php';

class Geocaching_Api_Xml extends Geocaching_Api {

    private $xmlns_geocaching = 'http://www.geocaching.com/Geocaching.Live/data';
    private $xmlns_schema     = 'http://schemas.datacontract.org/2004/07/Tucson.Geocaching.WCF.API.Geocaching.Types';

    /**
     * [__construct description]
     * @param [type] $token [description]
     */
    public function __construct($token)
    {
        if(!isset($token))
            throw new Exception('token is missing.');

        $this->token         = $token;
        $this->output_format = 'xml';
        $this->http_headers  = array('Content-Type: application/xml');
    }

    protected function checkRequestStatus($content) {}

    /**
     * [prependXml description]
     * @param  [type] $method [description]
     * @return [type]         [description]
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
        $text = $dom->createTextNode(utf8_encode($this->token));
        $eAccessToken->appendChild($text);
        return $dom;
    }

    /**
     * List of POST methods from Geocaching API
     */
    public function addGeocachesToBookmarkList($params = array()) {}

    public function createFieldNoteAndPublish($params = array()) {}

    public function createTrackableLog($params = array()) {}

    public function getAnotherUsersProfile($params = array()) {}

    public function getBookmarkListByGuid($params = array()) {}

    public function getGeocacheStatus($params = array()) {}

    public function getMoreGeocaches($params = array()) {}

    /**
     * [getYourUserProfile description]
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function getYourUserProfile($params = array())
    {
        $dom = $this->prependXml('GetYourUserProfileRequest');
        $eProfileOptions = $dom->createElement('ProfileOptions');
        $method = $dom->getElementsByTagName('GetYourUserProfileRequest')->item(0);
        $method->appendChild($eProfileOptions);
        foreach($params as $option => $value)
        {
            $eOption = $dom->createElement($option);
            $eProfileOptions->appendChild($eOption);
            $text = $dom->createTextNode(utf8_encode($value ? 'true':'false'));
            $eOption->appendChild($text);
            $eOption->setAttribute("xmlns", $this->xmlns_schema);
        }
        return $this->post_request(__FUNCTION__, $dom->saveXML());
    }

    public function saveUserWaypoint($params = array()) {}

    public function searchForGeocaches($params = array()) {}

    public function searchForSouvenirsByPublicGuid($params = array()) {}

    public function updateCacheNote($params = array()) {}

    public function uploadImageToGeocacheLog($params = array()) {}

}
