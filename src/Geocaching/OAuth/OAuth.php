<?php
/**
 * Geocaching API with PHP
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license http://opensource.org/licenses/eclipse-2.0.php
 * @package Geocaching_OAuth
 */

namespace Geocaching\OAuth;

use Katzgrau\KLogger\Logger;

/**
 * OAuth for the Geocaching API
 */
class OAuth
{
    /**
     * List of OAuth URL
     * @access protected
     * @var array
     */
    protected $list_oauth_url = array('staging'     => 'http://staging.geocaching.com/OAuth/oauth.ashx',
                                      'live'        => 'https://www.geocaching.com/OAuth/oauth.ashx',
                                      'live_mobile' => 'https://www.geocaching.com/OAuth/mobileoauth.ashx');

    /**
     * Log OAuth requests in a file
     *
     * @access protected
     * @var string $log
     */
    protected $logging = false;

    /**
     * OAuth Signature Method
     *
     * @access protected
     * @var string
     */
    protected $oauth_signature_method = 'HMAC-SHA1';

    /**
     * OAuth version
     *
     * @access protected
     * @var string
     */
    protected $oauth_version          = '1.0';

    /**
     * Consumer key
     *
     * @access private
     * @var string
     */
    private $consumer_key       = null;

    /**
     * Consumer secret
     *
     * @access private
     * @var string
     */
    private $consumer_secret    = null;

    /**
     * Callback URL
     *
     * @access private
     * @var string
     */
    private $callback_url       = null;

    /**
     * Oauth token access
     *
     * @access private
     * @var string
     */
    private $oauth_token_access = null;

    /**
     * OAuth URL
     *
     * @access private
     * @var string
     */
    private $oauth_url            = null;

    /**
     * Request parameters
     *
     * @access private
     * @var array
     */
    private $request_params     = array();

    /**
     * Access parameters
     *
     * @access private
     * @var array
     */
    private $access_params      = array();

    /**
     * Constructor
     *
     * @access public
     * @param string $consumer_key    OAuth Key
     * @param string $consumer_secret OAuth Secret
     * @param string $callback_url    Callbak URL
     * @param string $url             Array key from the $list_oauth_url array
     */
    public function __construct($consumer_key, $consumer_secret, $callback_url, $url = 'staging')
    {
        if (empty($consumer_key)) {
            throw new \Exception("consumer_key is missing");
        }
        if (empty($consumer_secret)) {
            throw new \Exception("consumer_secret is missing");
        }
        if (empty($callback_url)) {
            throw new \Exception("callback_url is missing");
        }
        if (!in_array($url, array_keys($this->list_oauth_url))) {
            throw new \Exception("OAuth URL is invalid");
        }

        $this->consumer_key    = $consumer_key;

        $this->consumer_secret = $consumer_secret;

        $this->callback_url    = $callback_url;

        $this->oauth_url       = $this->list_oauth_url[$url];
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
    protected function log($infos, $obj)
    {
        if (!$this->logging) {
            return false;
        }
        if (!is_array($obj)) {
            $obj = [$obj];
        }
        $this->logger->info('OAUTH: ' . $infos, $obj);
    }
    /**
     * Get Request Token
     *
     * @access public
     * @return array
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
        $this->log(__FUNCTION__ . ' params', $urlPairs);
        $concatenatedUrlParams = implode('&', $urlPairs);

        $authpage = $this->curl_request($this->oauth_url."?".$concatenatedUrlParams);
        $this->log(__FUNCTION__ . ' authpage', $authpage);
        $data = $this->http_explode_data($authpage);
        $this->log(__FUNCTION__ . ' data', $data);
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
     * Get Access Token
     *
     * @access public
     * @param  array  $queryData
     * @param  string $token
     * @return string
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
        $this->log(__FUNCTION__ . ' params', $urlPairs);
        $concatenatedUrlParams = implode('&', $urlPairs);

        $url = $this->curl_request($this->oauth_url."?".$concatenatedUrlParams);
        $this->log(__FUNCTION__ . ' url', $this->oauth_url."?".$concatenatedUrlParams);
        $data = $this->http_explode_data($url);
        $this->log(__FUNCTION__ . ' data', $data);
        $this->oauth_token_access = $data['oauth_token'];

        return $data;
    }

    /**
     * Signature hmac_sha1
     *
     * @access protected
     * @param  array  $params
     * @param  array  $secret
     * @return string
     */
    protected function signature_hmac_sha1($params, $secret = array())
    {
        foreach ($params as $k => $v) {
            $pairs[] = $k.'='.$v;
        }
        $query_string = implode('&', $pairs);

        $base_url = "GET&".$this->rfc3986_encode($this->oauth_url)."&".$this->rfc3986_encode($query_string);

        $secret_part = implode('&', $this->rfc3986_encode($secret));
        if(count($secret) == 1)
            $secret_part .= '&';

        return $this->rfc3986_encode(base64_encode(hash_hmac('sha1', $base_url, $secret_part, true)));
    }

    /**
     * Make a redirection to API URL
     *
     * @access public
     * @return void
     */
    public function redirect()
    {
        $redirecturl = $this->oauth_url . '?oauth_token=' . urlencode($this->auth_token) . '&force_login=true';
        $this->log(__FUNCTION__ , $redirecturl);
        header('Location: ' . $redirecturl);
        exit(0);
    }

    /**
     * Set a nonce
     *
     * @access protected
     * @return string
     */
    protected function setNonce()
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * Make a curl request
     *
     * @access protected
     * @param  string $url
     * @return string
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
        if ($status['http_code'] != 200) {
            throw new \Exception(curl_errno($ch));
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
     * @access protected
     * @param  string $string
     * @return string
     */
    protected function http_explode_data($string)
    {
        $string = explode('&', $string);
        $out = array();
        $i = 0;

        foreach ($string as $line) {
            $parts = explode('=', $line);

            $key = $this->oauth_loosy_decode($parts[0]);
            $value = isset($parts[1]) ? $this->oauth_loosy_decode($parts[1]) : '';

            $out[$key] = $value;
        }

        return $out;
    }

    /**
     * Return a string encoded according to RFC 3986.
     * In PHP 5.3+ you'll just need to do rawurlencode.
     *
     * @access protected
     * @param  string $str
     * @return string
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
     * Return a string decoded according OAuth spec.
     *
     * "While the encoding rules specified in this specification for the
     * purpose of constructing the signature base string exclude the of
     * a "+" character to represent an encoded space character, this pratice
     * is widely used in application/x-www-form-urlencoded encoded values,
     * and MUST be properly decoded"
     *
     * @access protected
     * @param  string $str
     * @return string
     */
    protected function oauth_loosy_decode($str)
    {
        $str = str_replace('+', '%20', $str);

        return rawurldecode($str);
    }

    /**
     * Get Request URI
     *
     * @access public
     * @return string
     */
    public static function getRequestUri()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_HOST'])) {
            $path = $_SERVER['HTTP_X_REQUESTED_PATH'];
            if (isset($_SERVER['HTTP_X_REQUESTED_QUERY_STRING'])) {
                $tmp_get = array();
                parse_str($_SERVER['HTTP_X_REQUESTED_QUERY_STRING'], $tmp_get);

                if (is_array($tmp_get)) {
                    $path .= '?' . http_build_query($tmp_get, '', '&');
                }
                unset($tmp_get);
            }
            $path = preg_replace('/^[\/]+/', '/', $path);

            return $path;
        }
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = explode('?', $_SERVER['REQUEST_URI']);
            $url = $url[0];
            $parsed_url = @parse_url($url);
            $path = '';
            if (isset($parsed_url['path'])) {
                $parsed_url['path'] = preg_replace('/^([\/]+)/', '/', $parsed_url['path']);
                $path .= $parsed_url['path'];
            }
            if (!empty($_SERVER['QUERY_STRING'])) {
                $tmp_get = array();
                parse_str($_SERVER['QUERY_STRING'], $tmp_get);

                if (is_array($tmp_get)) {
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
