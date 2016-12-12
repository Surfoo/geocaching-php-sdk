<?php

/**
 * Geocaching API with PHP.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

/**
 * OAuth for the Geocaching API.
 */
class OAuth
{
    /**
     * List of OAuth URL.
     *
     * @var array
     */
    protected $list_oauth_url = ['staging'     => 'http://staging.geocaching.com/OAuth/oauth.ashx',
                                 'live'        => 'https://www.geocaching.com/OAuth/oauth.ashx',
                                 'live_mobile' => 'https://www.geocaching.com/OAuth/mobileoauth.ashx',
                                ];

    /**
     * OAuth Signature Method.
     *
     * @var string
     */
    protected $oauth_signature_method = 'HMAC-SHA1';

    /**
     * OAuth version.
     *
     * @var string
     */
    protected $oauth_version = '1.0';

    /**
     * Consumer key.
     *
     * @var string
     */
    private $consumer_key = null;

    /**
     * Consumer secret.
     *
     * @var string
     */
    private $consumer_secret = null;

    /**
     * Callback URL.
     *
     * @var string
     */
    private $callback_url = null;

    /**
     * OAuth URL.
     *
     * @var string
     */
    private $oauth_url = null;

    /**
     * Request parameters.
     *
     * @var array
     */
    private $request_params = [];

    /**
     * Access parameters.
     *
     * @var array
     */
    private $access_params = [];

    /**
     * Guzzle Client.
     *
     * @var GuzzleHttp\Client
     */
    private $client = null;

    /**
     * Constructor.
     *
     * @param Client $client          Http Client
     * @param string $consumer_key    OAuth Key
     * @param string $consumer_secret OAuth Secret
     * @param string $callback_url    Callbak URL
     * @param string $url             Array key from the $list_oauth_url array
     */
    public function __construct(Client $client, $consumer_key, $consumer_secret, $callback_url, $url = 'live')
    {
        if (empty($consumer_key)) {
            throw new GeocachingOAuthException('consumer_key is missing.');
        }
        if (empty($consumer_secret)) {
            throw new GeocachingOAuthException('consumer_secret is missing.');
        }
        if (empty($callback_url)) {
            throw new GeocachingOAuthException('callback_url is missing.');
        }
        if (!in_array($url, array_keys($this->list_oauth_url))) {
            throw new GeocachingOAuthException('OAuth URL is invalid.');
        }

        $this->consumer_key = $consumer_key;

        $this->consumer_secret = $consumer_secret;

        $this->callback_url = $callback_url;

        $this->oauth_url = $this->list_oauth_url[$url];

        $this->client = $client;
    }

    /**
     * Get Request Token.
     *
     * @return array
     */
    public function getRequestToken()
    {
        $this->request_params = [
            'oauth_version'          => $this->oauth_version,
            'oauth_nonce'            => $this->setNonce(),
            'oauth_timestamp'        => time(),
            'oauth_consumer_key'     => $this->consumer_key,
            'oauth_signature_method' => $this->oauth_signature_method,
            'oauth_callback'         => $this->callback_url,
            ];

        $values               = $this->rfc3986Encode(array_values($this->request_params));
        $this->request_params = array_combine(array_keys($this->request_params), $values);
        uksort($this->request_params, 'strcmp');

        $this->request_params['oauth_signature'] = $this->signatureHmacSha1($this->request_params, [$this->consumer_secret]);
        uksort($this->request_params, 'strcmp');

        foreach ($this->request_params as $k => $v) {
            $urlPairs[] = $k . '=' . $v;
        }
        $concatenatedUrlParams = implode('&', $urlPairs);

        try {
            $response = $this->client->get($this->oauth_url . '?' . $concatenatedUrlParams);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }

            return false;
        }

        $authpage = (string) $response->getBody();
        $data     = $this->httpExplodeData($authpage);

        $this->auth_token               = $data['oauth_token'];
        $this->auth_token_secret        = $data['oauth_token_secret'];
        $this->oauth_callback_confirmed = (bool) $data['oauth_callback_confirmed'];

        if (!$this->oauth_callback_confirmed) {
            return [];
        }

        return ['auth_token'             => $this->auth_token,
                'auth_token_secret' => $this->auth_token_secret
            ];
    }

    /**
     * Get Access Token.
     *
     * @param array  $queryData
     * @param string $token
     *
     * @return string
     */
    public function getAccessToken($queryData, $token)
    {
        $this->access_params = [
            'oauth_version'          => $this->oauth_version,
            'oauth_nonce'            => $this->setNonce(),
            'oauth_timestamp'        => time(),
            'oauth_consumer_key'     => $this->consumer_key,
            'oauth_signature_method' => $this->oauth_signature_method,
            'oauth_token'            => $queryData['oauth_token'],
            'oauth_verifier'         => $queryData['oauth_verifier'],
            ];

        $values              = $this->rfc3986Encode(array_values($this->access_params));
        $this->access_params = array_combine(array_keys($this->access_params), $values);
        uksort($this->access_params, 'strcmp');

        $this->access_params['oauth_signature'] = $this->signatureHmacSha1($this->access_params, [$this->consumer_secret, $token['auth_token_secret']]);
        uksort($this->access_params, 'strcmp');

        foreach ($this->access_params as $k => $v) {
            $urlPairs[] = $k . '=' . $v;
        }
        $concatenatedUrlParams = implode('&', $urlPairs);

        try {
            $response = $this->client->get($this->oauth_url . '?' . $concatenatedUrlParams);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }

            return false;
        }

        $url  = (string) $response->getBody();
        $data = $this->httpExplodeData($url);

        return $data;
    }

    /**
     * Signature hmac_sha1.
     *
     * @param array $params
     * @param array $secret
     *
     * @return string
     */
    protected function signatureHmacSha1($params, $secret = [])
    {
        foreach ($params as $k => $v) {
            $pairs[] = $k . '=' . $v;
        }
        $query_string = implode('&', $pairs);

        $base_url = 'GET&' . $this->rfc3986Encode($this->oauth_url) . '&' . $this->rfc3986Encode($query_string);

        $secret_part = implode('&', $this->rfc3986Encode($secret));
        if (count($secret) == 1) {
            $secret_part .= '&';
        }

        return $this->rfc3986Encode(base64_encode(hash_hmac('sha1', $base_url, $secret_part, true)));
    }

    /**
     * Make a redirection to API URL.
     */
    public function redirect()
    {
        $redirecturl = $this->oauth_url . '?oauth_token=' . urlencode($this->auth_token) . '&force_login=true';
        header('Location: ' . $redirecturl);
        exit(0);
    }

    /**
     * Set a nonce.
     *
     * @return string
     */
    protected function setNonce()
    {
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * Explode an http data string (like key1=value1&key2[]=value2 etc.).
     *
     * We need this function because parse_str will delete doublon keys.
     * This function makes it easier to find the sent string exactly as it was sent.
     *
     * @param string $string
     *
     * @return string
     */
    protected function httpExplodeData($string)
    {
        $string = explode('&', $string);
        $out    = [];

        foreach ($string as $line) {
            $parts = explode('=', $line);

            $key   = $this->oauthLoosyDecode($parts[0]);
            $value = isset($parts[1]) ? $this->oauthLoosyDecode($parts[1]) : '';

            $out[$key] = $value;
        }

        return $out;
    }

    /**
     * Return a string encoded according to RFC 3986.
     * In PHP 5.3+ you'll just need to do rawurlencode.
     *
     * @param string $str
     *
     * @return string
     */
    protected function rfc3986Encode($str)
    {
        if (is_array($str)) {
            return array_map([__CLASS__, __FUNCTION__], $str);
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
     * @param string $str
     *
     * @return string
     */
    protected function oauthLoosyDecode($str)
    {
        return rawurldecode(str_replace('+', '%20', $str));
    }

    /**
     * Get Request URI.
     *
     * @return string
     */
    public static function getRequestUri()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_HOST'])) {
            $path = $_SERVER['HTTP_X_REQUESTED_PATH'];
            if (isset($_SERVER['HTTP_X_REQUESTED_QUERY_STRING'])) {
                $tmp_get = [];
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
            $url        = explode('?', $_SERVER['REQUEST_URI']);
            $url        = $url[0];
            $parsed_url = parse_url($url);
            $path       = '';
            if (isset($parsed_url['path'])) {
                $parsed_url['path'] = preg_replace('/^([\/]+)/', '/', $parsed_url['path']);
                $path .= $parsed_url['path'];
            }
            if (!empty($_SERVER['QUERY_STRING'])) {
                $tmp_get = [];
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
