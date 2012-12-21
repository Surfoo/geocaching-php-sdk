<?php

class Geocaching_OAuth {

    public $geocaching_staging_url = 'http://staging.geocaching.com/OAuth/oauth.ashx';
    public $geocaching_live_url    = 'http://staging.geocaching.com/OAuth/oauth.ashx';// FIXME with the right URL
    public $oauth_signature_method = 'HMAC-SHA1';
    public $oauth_version          = '1.0';

    private $consumer_key       = null;
    private $consumer_secret    = null;
    private $callback_url       = null;
    private $oauth_token_access = null;
    private $api_url            = null;
    private $request_params     = array();
    private $access_params      = array();

    /**
     * [__construct description]
     * @param [type]  $consumer_key    [description]
     * @param [type]  $consumer_secret [description]
     * @param [type]  $callback_url    [description]
     * @param boolean $live            [description]
     */
    public function __construct($consumer_key, $consumer_secret, $callback_url, $live = false)
    {
        if(empty($consumer_key))
        {
            throw new Exception("consumer_key is missing.");
        }
        if(empty($consumer_secret))
        {
            throw new Exception("consumer_secret is missing");
        }
        if(empty($callback_url))
        {
            throw new Exception("callback_url is missing");
        }
        $this->consumer_key    = $consumer_key;

        $this->consumer_secret = $consumer_secret;

        $this->callback_url    = $callback_url;


        if($live) {
            $this->api_url = $this->geocaching_live_url;
        }
        else {
            $this->api_url = $this->geocaching_staging_url;
        }
    }

    /**
     * [getRequestToken description]
     * @return [type] [description]
     */
    public function getRequestToken()
    {
        $this->request_params = array(
            "oauth_version"          => $this->oauth_version,
            "oauth_nonce"            => $this->setNonce(),
            "oauth_timestamp"        => time(),
            "oauth_consumer_key"     => $this->consumer_key,
            "oauth_signature_method" => $this->oauth_signature_method,
            "oauth_callback"         => $this->callback_url
            );

        $values = $this->rfc3986_encode(array_values($this->request_params));
        $this->request_params = array_combine(array_keys($this->request_params), $values);
        uksort($this->request_params, 'strcmp');
        
        $this->request_params['oauth_signature'] = $this->signature_hmac_sha1($this->request_params, array($this->consumer_secret));
        uksort($this->request_params, 'strcmp');

        foreach ($this->request_params as $k => $v) {
            $urlPairs[] = $k."=".$v;
        }
        $concatenatedUrlParams = implode('&', $urlPairs);

        $authpage = $this->curl_request($this->api_url."?".$concatenatedUrlParams);
        $data = $this->http_explode_data($authpage);
        $this->auth_token = $data['oauth_token'];
        $this->auth_token_secret = $data['oauth_token_secret'];
        $this->oauth_callback_confirmed = (bool) $data['oauth_callback_confirmed'];

        if (!$this->oauth_callback_confirmed) {
            return array();
        }
        return array('auth_token' => $this->auth_token,
                     'auth_token_secret' => $this->auth_token_secret);
    }

    /**
     * [getAccessToken description]
     * @param  [type] $queryData [description]
     * @param  [type] $token     [description]
     * @return [type]            [description]
     */
    public function getAccessToken($queryData, $token)
    {
        $this->access_params = array(
            "oauth_version" => $this->oauth_version,
            "oauth_nonce" => $this->setNonce(),
            "oauth_timestamp" => time(),
            "oauth_consumer_key" => $this->consumer_key,
            "oauth_signature_method" => $this->oauth_signature_method,
            "oauth_token" => $queryData['oauth_token'],
            "oauth_verifier" => $queryData['oauth_verifier']
            );

        $values = $this->rfc3986_encode(array_values($this->access_params));
        $this->access_params = array_combine(array_keys($this->access_params), $values);
        uksort($this->access_params, 'strcmp');

        $this->access_params['oauth_signature'] = $this->signature_hmac_sha1($this->access_params, array($this->consumer_secret, $token['auth_token_secret']));
        uksort($this->access_params, 'strcmp');

        foreach ($this->access_params as $k => $v) {
            $urlPairs[] = $k."=".$v;
        }
        $concatenatedUrlParams = implode('&', $urlPairs);

        $url = $this->curl_request($this->api_url."?".$concatenatedUrlParams);
        $data = $this->http_explode_data($url);

        $this->oauth_token_access = $data['oauth_token'];

        return $data;
    }

    /**
     * [signature_hmac_sha1 description]
     * @param  [type] $params [description]
     * @param  array  $secret [description]
     * @return [type]         [description]
     */
    protected function signature_hmac_sha1($params, $secret = array())
    {
        foreach ($params as $k => $v) {
            $pairs[] = $k.'='.$v;
        }
        $query_string = implode('&', $pairs);
        
        $base_url = "GET&".$this->rfc3986_encode($this->api_url)."&".$this->rfc3986_encode($query_string);
        
        $secret_part = implode('&', $this->rfc3986_encode($secret));
        if(count($secret) == 1)
            $secret_part .= '&';
            
        return $this->rfc3986_encode(base64_encode(hash_hmac('sha1', $base_url, $secret_part, true)));
    }

    /**
     * [redirect description]
     * @return [type] [description]
     */
    public function redirect()
    {
        $redirecturl = $this->api_url . '?oauth_token=' . urlencode($this->auth_token) . '&force_login=true';
        header('Location: ' . $redirecturl);
        exit(0);
    }

    /**
     * [setNonce description]
     */
    protected function setNonce()
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * [curl_request description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    protected function curl_request($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        
        $response = curl_exec($ch);
        $status = curl_getinfo($ch);
        if($status['http_code'] != 200)
        {
            throw new Exception(curl_errno($ch));
        }
        curl_close($ch);

        return $response;
    }
    
    /**
     * Explode an http data string (like key1=value1&key2[]=value2 etc.)
     *
     * We need this function because parse_str will delete doublon keys.
     * This function makes it easier to find the sent string exactly as it was sent.
     *
     * @param string $string
     * @returns string
     */
    protected function http_explode_data($string)
    {
        $string = explode('&', $string);
        $out = array();
        $i = 0;
        
        foreach ($string as $line)
        {
            $parts = explode('=', $line);
            
            $key = $this->oauth_loosy_decode($parts[0]);
            $value = isset($parts[1]) ? $this->oauth_loosy_decode($parts[1]) : '';
            
            $out[$key] = $value;
        }
        
        return $out;
    }
    
    /**
     * Returns a string encoded according to RFC 3986.
     * In PHP 5.3+ you'll just need to do rawurlencode.
     *
     * @param string $str
     * @returns string
     */
    protected function rfc3986_encode($str)
    {
        if (is_array($str)) {
            return array_map(array(__CLASS__, __FUNCTION__), $str);
        }
        
        if (version_compare(phpversion(), '5.3', '>=')) {
            return rawurlencode($str);
        }
        return str_replace('%7E', '~', rawurlencode($str));
    }
    
    /**
     * Returns a string decoded according OAuth spec.
     *
     * "While the encoding rules specified in this specification for the 
     * purpose of constructing the signature base string exclude the of 
     * a "+" character to represent an encoded space character, this pratice
     * is widely used in application/x-www-form-urlencoded encoded values,
     * and MUST be properly decoded"
     *
     * @param string $str
     * @returns string
     */
    protected function oauth_loosy_decode($str)
    {
        $str = str_replace('+', '%20', $str);
        return rawurldecode($str);
    }

    /**
     * [getRequestUri description]
     * @return [type] [description]
     */
    public static function getRequestUri()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_HOST']))
        {
            $path = $_SERVER['HTTP_X_REQUESTED_PATH'];
            if (isset($_SERVER['HTTP_X_REQUESTED_QUERY_STRING']))
            {
                $tmp_get = array();
                parse_str($_SERVER['HTTP_X_REQUESTED_QUERY_STRING'], $tmp_get);

                if (is_array($tmp_get))
                {
                    $path .= '?' . http_build_query($tmp_get, '', '&');
                }
                unset($tmp_get);
            }
            $path = preg_replace('/^[\/]+/', '/', $path);
            return $path;
        }
        if (isset($_SERVER['REQUEST_URI']))
        {
            $url = explode('?', $_SERVER['REQUEST_URI']);
            $url = $url[0];
            $parsed_url = @parse_url($url);
            $path = '';
            if (isset($parsed_url['path']))
            {
                $parsed_url['path'] = preg_replace('/^([\/]+)/', '/', $parsed_url['path']);
                $path .= $parsed_url['path'];
            }
            if (!empty($_SERVER['QUERY_STRING']))
            {
                $tmp_get = array();
                parse_str($_SERVER['QUERY_STRING'], $tmp_get);

                if (is_array($tmp_get))
                {
                    $path .= '?' . http_build_query($tmp_get, '', '&');
                }
                unset($tmp_get);
            }
            $path = preg_replace('/^[\/]+/', '/', $path);
            return $path;
        }
        return '';
    }
}
