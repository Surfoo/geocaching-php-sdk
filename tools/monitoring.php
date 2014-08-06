#!/usr/bin/php
<?php

error_reporting(E_ALL | E_STRICT);

require dirname(__DIR__) . '/vendor/autoload.php';

echo '<p class="date"><strong>Date of monitoring</strong>: ' . date('r') . '</p>'."\n";

// Groundspeak methods
$html = file_get_contents('https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help');
preg_match_all('/<tr>\s+<td>([a-z]+)<\/td>/i', $html, $matches);
$methods_from_GS = $matches[1];

// AbstractGeocachingApi Methods
$reflect = new ReflectionClass('Geocaching\Api\AbstractGeocachingApi');
$methods_list = $reflect->getMethods();
foreach ($methods_list as $_method) {
    if ($_method->isAbstract()) {
        $methods[] = ucfirst($_method->getName());
    }
}

$positive_diff_methods = array_diff($methods_from_GS, $methods);
$negative_diff_methods = array_diff($methods, $methods_from_GS);
if (!empty($positive_diff_methods) || !empty($negative_diff_methods)) {
    echo '<div class="alert alert-warning">'."\n";
    if ($positive_diff_methods) {
        echo "<strong>These methods are not in the library:</strong>\n";
        echo '<ul>'."\n";
        foreach ($positive_diff_methods as $method) {
            echo '    <li><a href="https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/' . $method . '">' . $method . '</a></li>'."\n";
        }
        echo '</ul>'."\n";
    }
    if ($negative_diff_methods) {
        echo "<strong>These methods are not in the the Groundspeak API:</strong>\n";
        echo '<ul>'."\n";
        foreach ($negative_diff_methods as $method) {
            echo '    <li>' . $method . '</li>'."\n";
        }
        echo '</ul>'."\n";
    }
    echo '</div>'."\n";
}

// Check the difference between the Groundspeak API and the 2 libraries
monitoring('Geocaching\Api\AbstractGeocachingApi');
monitoring('Geocaching\Api\GeocachingApi');

function monitoring($class)
{
    $reflect = new ReflectionClass($class);
    echo '<div class="col-md-6">'."\n";
    echo '<h2>' . $class . '</h2>'."\n";

    foreach ($reflect->getMethods() as $reflectmethod) {
        $error = false;
        $params = [];
        $params_from_GS = [];
        if (preg_match('/@link ([^\s]+)/', $reflectmethod->getDocComment(), $matche)) {

            $html_content = file_get_contents($matche[1]);
            preg_match('#<span class="uri-template">([^<]+)</span>#', $html_content, $url);
            $url = html_entity_decode($url[1]);
            $details_url = parse_url($url);
            preg_match('#<b>HTTP Method: </b>\s+<span class="method">([^<]+)</span>#', $html_content, $method_match);
            $method = $method_match[1];

            if ($method == 'GET') {
                $get_params = explode('&', $details_url['query']);
                foreach ($get_params as $fragment) {
                    preg_match('/^([^=]+)/', $fragment, $get_param);
                    if ($get_param[1] == 'accessToken') {
                        continue;
                    }
                    $params_from_GS[] = $get_param[1];
                }
            } elseif ($method == 'POST') {
                preg_match('#<pre class="request-json">([^<]+)</pre>#', $html_content, $post_params);
                $json_params = json_decode($post_params[1], true);
                unset($json_params['AccessToken']);
                foreach ($json_params as $key1 => $value) {
                    if (!is_array($value)) {
                        $params_from_GS[] = $key1;
                    } else {
                        foreach ($value as $key2 => $_value) {
                            if (!is_numeric($key2) && !array_key_exists($key2, $params_from_GS)) {
                                $params_from_GS[] = $key2;
                            } else {
                                $params_from_GS[] = $key1;
                            }
                        }
                    }
                }
                $params_from_GS = array_unique($params_from_GS);
            }

            if (preg_match('/- required params?: (.+)/i', $reflectmethod->getDocComment(), $required_params)) {
                preg_match_all('/([^\s,]+)/', $required_params[1], $matches);
                $params = array_merge($params, $matches[1]);
            }

            if (preg_match('/- optional params?: (.+)@link/is', $reflectmethod->getDocComment(), $optional_params)) {
                preg_match_all('/([^\s,\*]+)/', $optional_params[1], $matches);
                $params = array_merge($params, $matches[1]);
            }

            $format = '<div class="alert alert-%s">
                        <strong>
                            <a href="https://staging.api.groundspeak.com/Live/v6beta/geocaching.svc/help/operations/' . ucfirst($reflectmethod->getName()) . '">' . $reflectmethod->getName() . '</a>
                        </strong>: %s';

            $result = array_intersect($params_from_GS, $params);
            if (count($result) != count($params_from_GS)) {
                echo sprintf($format, 'danger', 'FAILED')."\n";
                echo '    <div class="diff">Difference:'."\n";
                echo "        <ul>\n";
                foreach (array_diff($params_from_GS, $params) as $method) {
                    echo '            <li>' . $method . '</a></li>'."\n";
                }
                echo "        <ul>\n";
                echo "    </div>\n";
            } else {
                echo sprintf($format, 'success', 'OK');
            }

            echo "</div>\n";
        }
    }
    echo "</div>\n";
}
