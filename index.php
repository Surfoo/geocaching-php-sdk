<?php

error_reporting(E_ALL | E_STRICT);
session_start();

require __DIR__ . '/vendor/autoload.php';

use Geocaching\GeocachingFactory;
use Geocaching\Exception\GeocachingSdkException;
use League\OAuth2\Client\Provider\Geocaching;
use League\OAuth2\Client\Provider\Exception\GeocachingIdentityProviderException;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\HandlerStack;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

$logger = new Logger('api');
$logger->pushHandler(new RotatingFileHandler('logs/geocaching-api.log'));
$guzzleLoggingMiddleware = Middleware::log($logger, new MessageFormatter());
$handlerStack = HandlerStack::create();
$handlerStack->push($guzzleLoggingMiddleware);


if (isset($_POST['reset'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0);
    }
    session_destroy();
    header('Location: index.php');
    exit(0);
}

// if (!array_key_exists('production', $_SESSION) && array_key_exists('url', $_POST)) {
//     switch ($_POST['url']) {
//         case 'production':
//             $_SESSION['production'] = true;
//             $_SESSION['url'] = $_POST['url'];
//             break;
//         case 'staging':
//         default:
//             $_SESSION['production'] = false;
//             $_SESSION['url'] = $_POST['url'];
//     }
// }

if (!isset($_SESSION['ACCESS_TOKEN'])) {

    //$callback_url = 'http://' . $_SERVER['HTTP_HOST'] . OAuth::getRequestUri();
    $_SESSION['callback_url'] = 'http://localhost:8000';

    //First step : Ask a token, go to the Geocaching OAuth URL
    if (isset($_POST['oauth']) && isset($_POST['oauth_key']) && isset($_POST['oauth_secret']) && !isset($_GET['code'])) {
        try {

            $_SESSION['oauth_key']    = $_POST['oauth_key'];
            $_SESSION['oauth_secret'] = $_POST['oauth_secret'];
            $_SESSION['environment']  = $_POST['environment'];
            
            $provider = new Geocaching([
                'clientId'       => $_SESSION['oauth_key'],
                'clientSecret'   => $_SESSION['oauth_secret'],
                'response_type'  => 'code',
                'scope'          => '*',
                'redirectUri'    => $_SESSION['callback_url'],
                'environment'    => $_SESSION['environment']
            ]);

            if (!isset($_GET['code'])) {
                // If we don't have an authorization code then get one
                $authUrl = $provider->getAuthorizationUrl();
                $_SESSION['oauth2state'] = $provider->getState();
                header('Location: ' . $authUrl);
                exit;
            }
        
        } catch(\Exception $e) {
            echo $e->getMessage() . '<br /><pre>' . print_r($e->getTrace(), true) . '</pre>';
            die();
        }

    } else if (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

        if (isset($_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
        }
        //exit('Invalid state');
    } else if(!isset($_SESSION['oauth'])) {
        try {
            $provider = new Geocaching([
                'clientId'       => $_SESSION['oauth_key'],
                'clientSecret'   => $_SESSION['oauth_secret'],
                'response_type'  => 'code',
                'scope'          => '*',
                'redirectUri'    => $_SESSION['callback_url'],
                'environment'    => $_SESSION['environment']
            ]);

            $accessToken = $provider->getAccessToken('authorization_code', ['code' => $_GET['code']]);
            $_SESSION['oauth']['accessToken'] = $accessToken->getToken();
            $_SESSION['oauth']['refreshToken'] = $accessToken->getRefreshToken();
            $_SESSION['oauth']['expirationTimestamp'] = $accessToken->getExpires();

        } catch(GeocachingIdentityProviderException $e) {
            exit($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Demo of Geocaching API with PHP</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <style type="text/css">
        #oauth_key, #oauth_secret {
            width: 330px;
        }
        .container form {
            margin-bottom: 1em;
        }
        footer ul {
            padding: 0;
            font-size: 1.2em;
        }
        footer ul li{
            display: inline;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Demo of Geocaching API with PHP</h1>
            <form action="" method="post" role="form">
                <fieldset>
                    <legend>Geocaching OAuth</legend>
                    <div class="form-group">
                        <label for="oauth_key">Your OAuth Key:</label>
                        <input type="text" name="oauth_key" id="oauth_key" size="36" maxlength="36" class="form-control"
                               <?php if(isset($_SESSION['oauth_key'])) echo 'value="' . $_SESSION['oauth_key'] . '"' ?>
                               <?php if(isset($_SESSION['oauth_key'])) echo 'readonly="readonly"' ?>
                               <?php if(!isset($_SESSION['oauth']['accessToken'])) echo 'required'; ?> />
                    </div>
                    <div class="form-group">
                        <label for="oauth_secret">Your OAuth Secret:</label>
                        <input type="text" name="oauth_secret" id="oauth_secret" size="36" maxlength="36" class="form-control"
                               <?php if(isset($_SESSION['oauth_secret'])) echo 'value="' . $_SESSION['oauth_secret'] . '"' ?>
                               <?php if(isset($_SESSION['oauth_secret'])) echo 'readonly="readonly"' ?>
                               <?php if(!isset($_SESSION['oauth']['accessToken'])) echo 'required'; ?> />
                    </div>
                    <div class="form-group">
                        <label>OAuth environment:</label><br />
                        <label for="staging" class="checkbox-inline">
                            <input type="radio" name="environment" value="staging" id="staging"
                            <?php if (isset($_SESSION['environment']) && $_SESSION['environment'] == "staging") echo 'checked="checked"';
                                  if(isset($_SESSION['oauth']['accessToken'])) echo ' disabled="disabled"';
                            ?> required> Staging</label>
                        <label for="production" class="checkbox-inline">
                            <input type="radio" name="environment" value="production" id="production"
                            <?php if (isset($_SESSION['environment']) && $_SESSION['environment'] == "production") echo 'checked="checked"';
                                  if(isset($_SESSION['oauth']['accessToken'])) echo ' disabled="disabled"';
                            ?>> Production</label>
                    </div>
                    <input type="submit" name="oauth" value="OAuth dance!" class="btn btn-primary" <?php if (isset($_SESSION['oauth']['accessToken'])) echo 'disabled'; ?>/>
                    <input type="submit" name="reset" value="Reset OAuth Token" class="btn btn-warning" <?php if (!isset($_SESSION['oauth']['accessToken'])) echo 'disabled'; ?>/>
                </fieldset>
            </form>
            <?php
            if (isset($_SESSION['oauth']['accessToken'])) {
                echo "<div class=\"alert alert-success\" role=\"alert\">\n";
                echo "  <p><strong>OAuth Information:</strong><br/>\n";
                echo "  <pre>" . print_r($_SESSION['oauth'], true) . "</pre>\n";
                echo "</div>\n";

                // Test methods here
                try {

                    $httpDebug = false;
                    $GeocachingSdk = GeocachingFactory::createSdkExtended($_SESSION['oauth']['accessToken'], 
                                                               $_SESSION['environment'], 
                                                               ['debug' => $httpDebug, 
                                                                'handler' => $handlerStack,
                                                                'timeout' => 10,
                                                                'connect_timeout' => 3,
                                                               ]);

                    ob_start();
                    $response = $GeocachingSdk->getUser('me', ['fields' => 'referenceCode,username,findCount,hideCount,avatarUrl,membershipLevelId,homeCoordinates,geocacheLimits']);

                    $user = $response->getBody();
                    $httpDebugLog = ob_get_clean();
                    echo "<div><strong>Your profile:</strong><br />\n";

                    if ($httpDebug) {
                        echo "<pre>HTTP Debug:\n";
                        print_r($httpDebugLog);
                        echo "</pre>";
                        
                        echo "<pre>";
                        print_r($response->getHeaders());
                        echo "</pre>";
                    }

                    if (!is_null($user)) {
                        echo "<pre>";
                        print_r($user);
                        echo "</pre>";
                        echo "</div>\n";
                    }

                } catch (GeocachingSdkException $e) {
                    $httpDebugLog = ob_get_clean();
                    if ($httpDebug) {
                        echo "<pre>HTTP Debug:\n";
                        print_r($httpDebugLog);
                        echo "</pre>";
                    }
                    echo '<div class="alert alert-danger" role="alert"><strong>GeocachingSdkException:</strong><br />
                    ' . $e->getMessage() . ' (Code: ' . $e->getCode(). ')<br />
                    <pre>' . print_r($e->getTrace(), true) . '</pre>
                    </div>'."\n";
                } catch (\Exception $e) {
                    $httpDebugLog = ob_get_clean();
                    if ($httpDebug) {
                        echo "<pre>HTTP Debug:\n";
                        print_r($httpDebugLog);
                        echo "</pre>";
                    }
                    echo '<div class="alert alert-danger" role="alert"><strong>Exception:</strong><br />
                    ' . $e->getMessage() . ' (Code: ' . $e->getCode(). ')<br />
                    <pre>' . print_r($e->getTrace(), true) . '</pre>
                    </div>'."\n";
                }
            }
            ?>
        <footer>
            <hr />
            <ul>
                <li><a href="https://github.com/Surfoo/geocaching-api">GitHub Project</a></li> &middot;
                <li><a href="docs/">Documentation</a></li> &middot;
                <li><a href="monitoring.php">Monitoring</a></li>
            </ul>
        </footer>

        <a href="https://github.com/surfoo/geocaching-api/">
            <img style="position: absolute; top: 0; right: 0; border: 0;"
                 src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67"
                 alt="Fork me on GitHub"
                 data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png">
        </a>

    </div>
    <script src="//code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
