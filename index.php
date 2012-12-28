<?php

error_reporting(E_ALL | E_STRICT);
session_start();

require_once __DIR__ . '/Geocaching_Api_Json.class.php';

if(isset($_POST['reset']))
{
    $_SESSION = array();
    if (ini_get("session.use_cookies"))
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0);
    }
    session_destroy();
    header('Location: index.php');
    exit(0);
}

if (!isset($_SESSION['ACCESS_TOKEN']))
{
    require_once __DIR__ . '/Geocaching_OAuth.class.php';

    $callback_url = 'http://' . $_SERVER['HTTP_HOST'] . Geocaching_OAuth::getRequestUri();

    //Ask a token, go to the Geocaching OAuth URL
    if(isset($_POST['oauth']) && isset($_POST['oauth_key']) && isset($_POST['oauth_secret']))
    {
        $consumer = new Geocaching_OAuth($_POST['oauth_key'], $_POST['oauth_secret'], $callback_url);
        $token = $consumer->getRequestToken();
        $_SESSION['OAUTH_KEY'] = $_POST['oauth_key'];
        $_SESSION['OAUTH_SECRET'] = $_POST['oauth_secret'];
        $_SESSION['REQUEST_TOKEN'] = serialize($token);
        $consumer->redirect();
    }

    //Go back from Geocaching OAuth URL, retrieve the token
    if(!empty($_GET) && isset($_SESSION['REQUEST_TOKEN']))
    {
        $consumer = new Geocaching_OAuth($_SESSION['OAUTH_KEY'], $_SESSION['OAUTH_SECRET'], $callback_url);
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
        <title>Geocaching API</title>
        <style type="text/css">
        body {
            font: 1em Arial;
        }
        </style>
    </head>
    <body>
        <!-- <h1>Geocaching API</h1> -->
        <form action="" method="post">
            <fieldset>
                <legend>Geocaching OAuth</legend>
                <p>
                    <label for="oauth_key">Your OAuth Key:</label><br/>
                    <input type="text" name="oauth_key" value="" id="oauth_key" size="36" maxlength="36" <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'required'; ?> />
                </p>
                <p>
                    <label for="oauth_secret">Your OAuth Secret:</label><br/>
                    <input type="text" name="oauth_secret" value="" id="oauth_secret" size="36" maxlength="36" <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'required'; ?> />
                </p>
                <input type="submit" name="oauth" value="OAuth dance!" <?php if(isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?>/>
                <input type="submit" name="reset" value="Reset OAuth Token" <?php if(!isset($_SESSION['ACCESS_TOKEN'])) echo 'disabled="disabled"'; ?> />
            </fieldset>
        </form>
        <?php
        if (isset($_SESSION['ACCESS_TOKEN']))
        {
            $token = unserialize($_SESSION['ACCESS_TOKEN']);
            $api = new Geocaching_Api_Json($token['oauth_token']);
            $user   = $api->getYourUserProfile();
            $limits = $api->getAPILimits();
            $limits = $api->getAPILimits();
            echo "<p><strong>Token:</strong> " . $token['oauth_token']."<br/>";
            echo "<strong>Connected as:</strong> " . $user->Profile->User->UserName . " (Id = " . $user->Profile->User->Id . ")</p>";
            echo "<div><pre style='height: 200px;overflow: auto;background:#ccc;'>getYourUserProfile:<br>".print_r($user, true)."</pre></div>";

            echo "<p><strong>CacheLimit:</strong> ". $limits->Limits->CacheLimits[0]->CacheLimit." in ".$limits->Limits->CacheLimits[0]->InMinutes." minutes</p>";

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

            //$params = array('GeocacheTypes'=>2, 'LogTypes'=>false, 'AttributeTypes'=>false);
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
            $data = $api->getMoreGeocaches($params);*/
            $data = $api->getStatusMessages();
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
        }
        ?>
    </body>
</html>