<?php

error_reporting(E_ALL | E_STRICT);
session_start();

require __DIR__ . '/vendor/autoload.php';

use Geocaching\OAuth\OAuth as OAuth,
    Geocaching\Api\Json as Json;

if(isset($_POST['reset'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0);
    }
    session_destroy();
    header('Location: index.php');
    exit(0);
}

if(!array_key_exists('production', $_SESSION) && array_key_exists('url', $_POST)) {
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
    if(isset($_POST['oauth']) && isset($_POST['oauth_key']) && isset($_POST['oauth_secret'])) {
        $consumer = new OAuth($_POST['oauth_key'], $_POST['oauth_secret'], $callback_url, $_SESSION['url']);
        $consumer->setLogging('/tmp/');

        $token = $consumer->getRequestToken();
        $_SESSION['OAUTH_KEY'] = $_POST['oauth_key'];
        $_SESSION['OAUTH_SECRET'] = $_POST['oauth_secret'];
        $_SESSION['REQUEST_TOKEN'] = serialize($token);
        $consumer->redirect();
    }

    //Second step : Go back from Geocaching OAuth URL, retrieve the token
    if(!empty($_GET) && isset($_SESSION['REQUEST_TOKEN'])) {
        $consumer = new OAuth($_SESSION['OAUTH_KEY'], $_SESSION['OAUTH_SECRET'], $callback_url, $_SESSION['url']);
        $consumer->setLogging('/tmp/');
        $token = $consumer->getAccessToken($_GET, unserialize($_SESSION['REQUEST_TOKEN']));
        $_SESSION['ACCESS_TOKEN'] = serialize($token);
        header('Location: index.php');
        exit(0);
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Demo of Geocaching API with PHP</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <style type="text/css">
        #oauth_key, #oauth_secret {
            width: 330px;
        }
        .container form {
            margin-bottom: 1em;
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
                        <label for="staging" class="checkbox-inline"><input type="radio" name="url" value="staging" id="staging" <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "staging") echo 'checked="checked"'; if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"'; ?> required> Staging</label>
                        <label for="live" class="checkbox-inline"><input type="radio" name="url" value="live" id="live" <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "live") echo 'checked="checked"'; if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"'; ?>> Live</label>
                        <label for="live_mobile" class="checkbox-inline"><input type="radio" name="url" value="live_mobile" id="live_mobile" <?php if (isset($_SESSION['url']) && $_SESSION['url'] == "live_mobile") echo 'checked="checked"'; if(isset($_SESSION['ACCESS_TOKEN'])) echo ' disabled="disabled"'; ?>> Live Mobile</label>
                    </div>
                    <input type="submit" name="oauth" value="OAuth dance!"  class="btn btn-primary" <?php if(isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?>/>
                    <input type="submit" name="reset" value="Reset OAuth Token"  class="btn btn-warning" <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?>/>
                </fieldset>
            </form>
            <?php
            if (isset($_SESSION['ACCESS_TOKEN']))
            {
                echo "<pre>";
                print_r(unserialize($_SESSION['REQUEST_TOKEN']));
                print_r(unserialize($_SESSION['ACCESS_TOKEN']));
                echo "</pre>";
                $token = unserialize($_SESSION['ACCESS_TOKEN']);
                echo "<div class=\"well well-sm\">\n";
                echo "<p><strong>Token:</strong> " . $token['oauth_token']."<br/>\n";

                $api   = new Json($token['oauth_token'], $_SESSION['production']);
                //$api->setLogging('/tmp/');

                $params = array('PublicProfileData' => true);
                try {
                    $user = $api->getYourUserProfile($params);
                }
                catch(Exception $e) {
                    echo "<p>" . $e->getMessage() . "</p>\n";
                }

                echo "<strong>Connected as:</strong> " . $user->Profile->User->UserName . " (Id = " . $user->Profile->User->Id . ")<br/>\n";

                preg_match('/([0-9]+)/', $user->Profile->PublicProfile->MemberSince, $matches);
                $memberSince = date('Y-m-d H:i:s', floor($matches[0]/1000));
                echo "<strong>Member since:</strong> " . $memberSince . "</p>\n";
                echo "</div>\n";

                //echo "<div><pre style='height: 200px;overflow: auto;background:#ccc;'>getYourUserProfile:<br>".print_r($user, true)."</pre></div>";
                //print_r($api->GetWptLogTypes());

                //$limits = $api->getAPILimits();
                //echo "<p><strong>CacheLimit:</strong> ". $limits->Limits->CacheLimits[0]->CacheLimit." in ".$limits->Limits->CacheLimits[0]->InMinutes." minutes</p>";

                /*$geocacheTypes = $api->GetGeocacheTypes();
                echo "GeocacheTypes : <ul>";
                foreach($geocacheTypes->GeocacheTypes as $value) {
                    echo "<li>".$value->GeocacheTypeName." (".$value->GeocacheTypeId.")</li>";
                }
                echo "</ul>";

                $attributeTypesData = $api->getAttributeTypesData();
                echo "AttributeTypesData : <ul>";
                foreach($attributeTypesData->AttributeTypes as $value) {
                    echo "<li>".$value->Name." (".$value->ID.")</li>";
                }
                echo "</ul>";*/

                /*$params['isLite'] = true;
                $params['PointRadiusLatitude'] = 48.85975;
                $params['PointRadiusLongitude'] = 2.34068;
                $params['MaxPerPage'] = 10;
                $params['GeocacheLogCount'] = 0;
                $params['TrackableLogCount'] = 0;
                //$params = array('CacheCodes'=>array('GC2FNN9'), 'MaxPerPage'=>50);
                $data = $api->searchForGeocaches($params);
                echo "<pre>";
                var_dump($data);
                echo "</pre>";

                $params = array('IsLite'=>true,
                                'StartIndex'=>2,
                                'MaxPerPage'=>5,
                                'GeocacheLogCount'=>0,
                                'TrackableLogCount'=>0
                    );
                $data = $api->getMoreGeocaches($params);
                echo "<pre>";
                var_dump($data);
                echo "</pre>";*/
            }
            ?>
        <footer>
            <hr />
            <ul>
                <li>Source: <a href="https://github.com/Surfoo/geocaching-api">https://github.com/Surfoo/geocaching-api</a></li>
                <li><a href="docs/">Documentation</a></li>
            </ul>
        </footer>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    </body>
</html>
