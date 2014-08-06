<?php

error_reporting(E_ALL | E_STRICT);

require __DIR__ . '/vendor/autoload.php';

define('MONITORING_FILENAME', 'tools/monitoring.html');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Monitoring of the Groundspeak API</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <style type="text/css">
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
        <h1>Monitoring</h1>
        <p class="well well-lg">
            This page keeps an eye on changes about the <a href="https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help">Groundspeak API</a> every week.<br />
            The first part lists changes about new or missing methods. The second one lists changes about arguments of these methods.
        </p>
        <div class="row">
<?php
if(file_exists(MONITORING_FILENAME) && is_readable(MONITORING_FILENAME)) {
    $content = file_get_contents(MONITORING_FILENAME);
    echo $content;
}
?>
        </div>
        <footer>
            <hr />
            <ul>
                <li><a href="https://github.com/Surfoo/geocaching-api">GitHub Project</a></li> &middot; 
                <li><a href="docs/">Documentation</a></li>
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
