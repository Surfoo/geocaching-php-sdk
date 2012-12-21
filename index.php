<?php

error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/Geocaching_OAuth.class.php';
require_once __DIR__ . '/Geocaching_Api_Json.class.php';

define('OAUTH_KEY'   , '');
define('OAUTH_SECRET', '');

if (!isset($_SESSION['ACCESS_TOKEN']))
{
    $callback_url = 'http://' . $_SERVER['HTTP_HOST'] . Geocaching_OAuth::getRequestUri();
    $consumer = new Geocaching_OAuth(OAUTH_KEY, OAUTH_SECRET, $callback_url);

    if(!empty($_GET) && isset($_SESSION['REQUEST_TOKEN']))
    {
        $token = $consumer->getAccessToken($_GET, unserialize($_SESSION['REQUEST_TOKEN']));
        $_SESSION['ACCESS_TOKEN'] = serialize($token);
    }

    if(isset($_POST['oauth']))
    {
        $token = $consumer->getRequestToken();
        $_SESSION['REQUEST_TOKEN'] = serialize($token);
        $consumer->redirect();
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
        <h1>Geocaching API</h1>
        <form action="" method="post">
            <input type="submit" name="oauth" value="OAuth dance!" />
        </form>
        <?php
        if (isset($_SESSION['ACCESS_TOKEN']))
        {
            $token = unserialize($_SESSION['ACCESS_TOKEN']);
            $api = new Geocaching_Api_Json($token['oauth_token']);
            $user   = $api->getYourUserProfile();
            $limits = $api->getAPILimits();
            echo "<p><strong>Token:</strong> " . $token['oauth_token']."</p>";
            echo "<p><strong>Connected as:</strong> " . $user->Profile->User->UserName . " (Id = " . $user->Profile->User->Id . ")</p>";
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


            /*$params = array('Username'=>$user->Profile->User->UserName, 'StartIndex'=>0, 'MaxPerPage'=>50);
            $data = $api->getUserGallery($params);
            echo "<pre>";
            var_dump($data);
            echo "</pre>";*/
        }
        ?>
    </body>
</html>