<?php

error_reporting(E_ALL | E_STRICT);
session_start();

require __DIR__ . '/vendor/autoload.php';

use Geocaching\OAuth\OAuth;
use Geocaching\Api\GeocachingApi;

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

if (!array_key_exists('production', $_SESSION) && array_key_exists('url', $_POST)) {
    switch ($_POST['url']) {
        case 'live_mobile':
        case 'live':
            $_SESSION['production'] = true;
            $_SESSION['url'] = $_POST['url'];
            break;
        case 'staging':
        default:
            $_SESSION['production'] = false;
            $_SESSION['url'] = $_POST['url'];
    }
}

if (!isset($_SESSION['ACCESS_TOKEN'])) {

    $callback_url = 'http://' . $_SERVER['HTTP_HOST'] . OAuth::getRequestUri();

    //First step : Ask a token, go to the Geocaching OAuth URL
    if (isset($_POST['oauth']) && isset($_POST['oauth_key']) && isset($_POST['oauth_secret'])) {
        $consumer = new OAuth($_POST['oauth_key'], $_POST['oauth_secret'], $callback_url, $_SESSION['url']);
        //$consumer->setLogging('/tmp/');

        $token = $consumer->getRequestToken();
        $_SESSION['OAUTH_KEY'] = $_POST['oauth_key'];
        $_SESSION['OAUTH_SECRET'] = $_POST['oauth_secret'];
        $_SESSION['REQUEST_TOKEN'] = serialize($token);
        $consumer->redirect();
    }

    //Second step : Go back from Geocaching OAuth URL, retrieve the token
    if (!empty($_GET) && isset($_SESSION['REQUEST_TOKEN'])) {
        $consumer = new OAuth($_SESSION['OAUTH_KEY'], $_SESSION['OAUTH_SECRET'], $callback_url, $_SESSION['url']);
        //$consumer->setLogging('/tmp/');

        $token = $consumer->getAccessToken($_GET, unserialize($_SESSION['REQUEST_TOKEN']));
        $_SESSION['ACCESS_TOKEN'] = serialize($token);
        header('Location: index.php');
        exit(0);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Demo of Geocaching API with PHP</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
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
                               <?php if(isset($_SESSION['OAUTH_KEY'])) echo 'value="' . $_SESSION['OAUTH_KEY'] . '"' ?>
                               <?php if(isset($_SESSION['OAUTH_SECRET'])) echo 'readonly="readonly"' ?>
                               <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'required'; ?> />
                    </div>
                    <div class="form-group">
                        <label for="oauth_secret">Your OAuth Secret:</label>
                        <input type="text" name="oauth_secret" id="oauth_secret" size="36" maxlength="36" class="form-control"
                               <?php if(isset($_SESSION['OAUTH_SECRET'])) echo 'value="' . $_SESSION['OAUTH_SECRET'] . '"' ?>
                               <?php if(isset($_SESSION['OAUTH_SECRET'])) echo 'readonly="readonly"' ?>
                               <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'required'; ?> />
                    </div>
                    <div class="form-group">
                        <label>OAuth URL:</label><br />
                        <label for="staging" class="checkbox-inline">
                            <input type="radio" name="url" value="staging" id="staging"
                            <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "staging") echo 'checked="checked"';
                                  if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"';
                            ?> required> Staging</label>
                        <label for="live" class="checkbox-inline">
                            <input type="radio" name="url" value="live" id="live"
                            <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "live") echo 'checked="checked"';
                                  if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"';
                            ?>> Live</label>
                        <label for="live_mobile" class="checkbox-inline">
                        <input type="radio" name="url" value="live_mobile" id="live_mobile"
                        <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "live_mobile") echo 'checked="checked"';
                              if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"';
                        ?>> Live Mobile</label>
                    </div>
                    <input type="submit" name="oauth" value="OAuth dance!" class="btn btn-primary" <?php if(isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?>/>
                    <input type="submit" name="reset" value="Reset OAuth Token" class="btn btn-warning" <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?>/>
                </fieldset>
            </form>
            <?php
            if (isset($_SESSION['ACCESS_TOKEN'])) {
                // echo "<pre>";
                // print_r(unserialize($_SESSION['REQUEST_TOKEN']));
                // print_r(unserialize($_SESSION['ACCESS_TOKEN']));
                // echo "</pre>";
                $token = unserialize($_SESSION['ACCESS_TOKEN']);

                try {
                    $api = new GeocachingApi($token['oauth_token'], $_SESSION['production']);
                    //$api->setLogging('/tmp/');
                    $params = array('PublicProfileData' => true);
                    $user = $api->getYourUserProfile($params);

                    echo "<div class=\"alert alert-success\" role=\"alert\">\n";
                    echo "<p><strong>Token:</strong> " . $token['oauth_token']."<br/>\n";
                    echo "<strong>Connected as:</strong> " . $user->Profile->User->UserName . " (Id: " . $user->Profile->User->Id . ")<br/>\n";
                    preg_match('/([0-9]+)/', $user->Profile->PublicProfile->MemberSince, $matches);
                    echo "<strong>Member since:</strong> " . date('Y-m-d H:i:s', floor($matches[0]/1000)) . "</p>\n";
                    echo "</div>\n";
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>'."\n";
                }

                // Test methods here:
                $response = $api->getSiteStats();

                echo "<pre>";
                print_r($response);
                echo "</pre>";
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
