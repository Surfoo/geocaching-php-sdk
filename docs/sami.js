
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Geocaching" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Geocaching.html">Geocaching</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Geocaching_Exception" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Geocaching/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Geocaching_Exception_GeocachingSdkException" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Geocaching/Exception/GeocachingSdkException.html">GeocachingSdkException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Geocaching_Lib" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Geocaching/Lib.html">Lib</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Geocaching_Lib_Adapters" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Geocaching/Lib/Adapters.html">Adapters</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Geocaching_Lib_Adapters_GuzzleHttpClient" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Geocaching/Lib/Adapters/GuzzleHttpClient.html">GuzzleHttpClient</a>                    </div>                </li>                            <li data-name="class:Geocaching_Lib_Adapters_HttpClientInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Geocaching/Lib/Adapters/HttpClientInterface.html">HttpClientInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Geocaching_Sdk" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Geocaching/Sdk.html">Sdk</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Geocaching_Sdk_GeocachingSdk" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Geocaching/Sdk/GeocachingSdk.html">GeocachingSdk</a>                    </div>                </li>                            <li data-name="class:Geocaching_Sdk_GeocachingSdkExtended" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Geocaching/Sdk/GeocachingSdkExtended.html">GeocachingSdkExtended</a>                    </div>                </li>                            <li data-name="class:Geocaching_Sdk_GeocachingSdkInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Geocaching/Sdk/GeocachingSdkInterface.html">GeocachingSdkInterface</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Geocaching_GeocachingFactory" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Geocaching/GeocachingFactory.html">GeocachingFactory</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Geocaching.html", "name": "Geocaching", "doc": "Namespace Geocaching"},{"type": "Namespace", "link": "Geocaching/Exception.html", "name": "Geocaching\\Exception", "doc": "Namespace Geocaching\\Exception"},{"type": "Namespace", "link": "Geocaching/Lib.html", "name": "Geocaching\\Lib", "doc": "Namespace Geocaching\\Lib"},{"type": "Namespace", "link": "Geocaching/Lib/Adapters.html", "name": "Geocaching\\Lib\\Adapters", "doc": "Namespace Geocaching\\Lib\\Adapters"},{"type": "Namespace", "link": "Geocaching/Sdk.html", "name": "Geocaching\\Sdk", "doc": "Namespace Geocaching\\Sdk"},
            {"type": "Interface", "fromName": "Geocaching\\Lib\\Adapters", "fromLink": "Geocaching/Lib/Adapters.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_getBody", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::getBody", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_getHeaders", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::getHeaders", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_get", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_post", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::post", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_put", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::put", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_delete", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::delete", "doc": "&quot;&quot;"},
            
            {"type": "Interface", "fromName": "Geocaching\\Sdk", "fromLink": "Geocaching/Sdk.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html", "name": "Geocaching\\Sdk\\GeocachingSdkInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_searchGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::searchGeocaches", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocache", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocache", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocaches", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateGeocacheNote", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheNote", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheTrackables", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheTrackables", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackable", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserTrackables", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserTrackables", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocoinTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocoinTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setTrackableLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getLogdrafts", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getLogdrafts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_promoteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::promoteLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setLogdraftImage", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setLogdraftImage", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheUserWaypoints", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserWaypoints", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setBulkGeocachesList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setBulkGeocachesList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUser", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUser", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUsers", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUsers", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserGeocacheLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserLists", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserLists", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserSouvenirs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserSouvenirs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getFriends", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getFriends", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getFriendRequests", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getFriendRequests", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_sendFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::sendFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_acceptFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::acceptFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteFriend", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteFriend", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getReferenceCodeFromId", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getReferenceCodeFromId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getCountries", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getCountries", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getStates", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getStates", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getStatesByCountry", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getStatesByCountry", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getMembershipLevels", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getMembershipLevels", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getAttributes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getAttributes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_ping", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::ping", "doc": "&quot;&quot;"},
            
            
            {"type": "Class", "fromName": "Geocaching\\Exception", "fromLink": "Geocaching/Exception.html", "link": "Geocaching/Exception/GeocachingSdkException.html", "name": "Geocaching\\Exception\\GeocachingSdkException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Exception\\GeocachingSdkException", "fromLink": "Geocaching/Exception/GeocachingSdkException.html", "link": "Geocaching/Exception/GeocachingSdkException.html#method___construct", "name": "Geocaching\\Exception\\GeocachingSdkException::__construct", "doc": "&quot;GeocachingSdkException constructor.&quot;"},
            
            {"type": "Class", "fromName": "Geocaching", "fromLink": "Geocaching.html", "link": "Geocaching/GeocachingFactory.html", "name": "Geocaching\\GeocachingFactory", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\GeocachingFactory", "fromLink": "Geocaching/GeocachingFactory.html", "link": "Geocaching/GeocachingFactory.html#method_createSdk", "name": "Geocaching\\GeocachingFactory::createSdk", "doc": "&quot;Return Geocaching SDK to use API&#039;s methods&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\GeocachingFactory", "fromLink": "Geocaching/GeocachingFactory.html", "link": "Geocaching/GeocachingFactory.html#method_createSdkExtended", "name": "Geocaching\\GeocachingFactory::createSdkExtended", "doc": "&quot;Return Geocaching custom methods&quot;"},
            
            {"type": "Class", "fromName": "Geocaching\\Lib\\Adapters", "fromLink": "Geocaching/Lib/Adapters.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method___construct", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::__construct", "doc": "&quot;GuzzleHttpClient constructor.&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_getBody", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::getBody", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_getHeaders", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::getHeaders", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_getStatusCode", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::getStatusCode", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_getReasonPhrase", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::getReasonPhrase", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_get", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_post", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::post", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_put", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::put", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient", "fromLink": "Geocaching/Lib/Adapters/GuzzleHttpClient.html", "link": "Geocaching/Lib/Adapters/GuzzleHttpClient.html#method_delete", "name": "Geocaching\\Lib\\Adapters\\GuzzleHttpClient::delete", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Geocaching\\Lib\\Adapters", "fromLink": "Geocaching/Lib/Adapters.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_getBody", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::getBody", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_getHeaders", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::getHeaders", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_get", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_post", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::post", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_put", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::put", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Lib\\Adapters\\HttpClientInterface", "fromLink": "Geocaching/Lib/Adapters/HttpClientInterface.html", "link": "Geocaching/Lib/Adapters/HttpClientInterface.html#method_delete", "name": "Geocaching\\Lib\\Adapters\\HttpClientInterface::delete", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Geocaching\\Sdk", "fromLink": "Geocaching/Sdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html", "name": "Geocaching\\Sdk\\GeocachingSdk", "doc": "&quot;List of methods from Groundspeak API.&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method___construct", "name": "Geocaching\\Sdk\\GeocachingSdk::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getFriends", "name": "Geocaching\\Sdk\\GeocachingSdk::getFriends", "doc": "&quot;swagger: GET \/v{api-version}\/friends&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getFriendRequests", "name": "Geocaching\\Sdk\\GeocachingSdk::getFriendRequests", "doc": "&quot;swagger: GET \/v{api-version}\/friendrequests&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_sendFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdk::sendFriendRequest", "doc": "&quot;swagger: POST \/v{api-version}\/friendrequests&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_acceptFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdk::acceptFriendRequest", "doc": "&quot;swagger: POST \/v{api-version}\/friendrequests\/{requestId}\/accept&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteFriend", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteFriend", "doc": "&quot;swagger: DELETE \/v{api-version}\/friends\/{userCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteFriendRequest", "doc": "&quot;swagger: DELETE \/v{api-version}\/friendrequests\/{requestId}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteGeocacheLog", "doc": "&quot;swagger: DELETE \/v{api-version}\/geocachelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheLog", "doc": "&quot;swagger: GET \/v{api-version}\/geocachelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdk::updateGeocacheLog", "doc": "&quot;swagger: PUT \/v{api-version}\/geocachelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheLogImages", "doc": "&quot;swagger: GET \/v{api-version}\/geocachelogs\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdk::setGeocacheLogImages", "doc": "&quot;swagger: POST \/v{api-version}\/geocachelogs\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdk::setGeocacheLog", "doc": "&quot;swagger: POST \/v{api-version}\/geocachelogs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteGeocacheNote", "doc": "&quot;swagger: DELETE \/v{api-version}\/geocaches\/{referenceCode}\/notes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdk::updateGeocacheNote", "doc": "&quot;swagger: PUT \/v{api-version}\/geocaches\/{referenceCode}\/notes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocache", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocache", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheImages", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheImages", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheTrackables", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheTrackables", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/{referenceCode}\/trackables&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocaches", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheLogs", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/{referenceCode}\/geocachelogs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_searchGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdk::searchGeocaches", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/search&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteList", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteList", "doc": "&quot;swagger: DELETE \/v{api-version}\/lists\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getList", "name": "Geocaching\\Sdk\\GeocachingSdk::getList", "doc": "&quot;swagger: GET \/v{api-version}\/lists\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateList", "name": "Geocaching\\Sdk\\GeocachingSdk::updateList", "doc": "&quot;swagger: PUT \/v{api-version}\/lists\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getZippedPocketQuery", "name": "Geocaching\\Sdk\\GeocachingSdk::getZippedPocketQuery", "doc": "&quot;swagger: GET \/v{api-version}\/lists\/{referenceCode}\/geocaches\/zipped&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheList", "doc": "&quot;swagger: GET \/v{api-version}\/lists\/{referenceCode}\/geocaches&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdk::setGeocacheList", "doc": "&quot;swagger: POST \/v{api-version}\/lists\/{referenceCode}\/geocaches&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setList", "name": "Geocaching\\Sdk\\GeocachingSdk::setList", "doc": "&quot;swagger: POST \/v{api-version}\/lists&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setBulkGeocachesList", "name": "Geocaching\\Sdk\\GeocachingSdk::setBulkGeocachesList", "doc": "&quot;swagger: POST \/v{api-version}\/lists\/{referenceCode}\/bulkgeocaches&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteGeocacheList", "doc": "&quot;swagger: DELETE \/v{api-version}\/lists\/{referenceCode}\/geocaches\/{geocacheReferenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteLogdraft", "doc": "&quot;swagger: DELETE \/v{api-version}\/logdrafts\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdk::getLogdraft", "doc": "&quot;swagger: GET \/v{api-version}\/logdrafts\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdk::updateLogdraft", "doc": "&quot;swagger: PUT \/v{api-version}\/logdrafts\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getLogdrafts", "name": "Geocaching\\Sdk\\GeocachingSdk::getLogdrafts", "doc": "&quot;swagger: GET \/v{api-version}\/logdrafts&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdk::setLogdraft", "doc": "&quot;swagger: POST \/v{api-version}\/logdrafts&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_promoteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdk::promoteLogdraft", "doc": "&quot;swagger: POST \/v{api-version}\/logdrafts\/{referenceCode}\/promote&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setLogdraftImage", "name": "Geocaching\\Sdk\\GeocachingSdk::setLogdraftImage", "doc": "&quot;swagger: POST \/v{api-version}\/logdrafts\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteTrackableLog", "doc": "&quot;swagger: DELETE \/v{api-version}\/trackablelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackableLog", "doc": "&quot;swagger: GET \/v{api-version}\/trackablelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdk::updateTrackableLog", "doc": "&quot;swagger: PUT \/v{api-version}\/trackablelogs\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackableLogImages", "doc": "&quot;swagger: GET \/v{api-version}\/trackablelogs\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdk::setTrackableLogImages", "doc": "&quot;swagger: POST \/v{api-version}\/trackablelogs\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdk::setTrackableLog", "doc": "&quot;swagger: POST \/v{api-version}\/trackablelogs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackable", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackable", "doc": "&quot;swagger: GET \/v{api-version}\/trackables\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserTrackables", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserTrackables", "doc": "&quot;swagger: GET \/v{api-version}\/trackables&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocoinTypes", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocoinTypes", "doc": "&quot;swagger: GET \/v{api-version}\/trackables\/geocointypes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackableImages", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackableImages", "doc": "&quot;swagger: GET \/v{api-version}\/trackables\/{referenceCode}\/Images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackableLogs", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackableLogs", "doc": "&quot;swagger: GET \/v{api-version}\/trackables\/{referenceCode}\/trackablelogs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUser", "name": "Geocaching\\Sdk\\GeocachingSdk::getUser", "doc": "&quot;swagger: GET \/v{api-version}\/users\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserImages", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserImages", "doc": "&quot;swagger: GET \/v{api-version}\/users\/{referenceCode}\/images&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserSouvenirs", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserSouvenirs", "doc": "&quot;swagger: GET \/v{api-version}\/users\/{referenceCode}\/souvenirs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUsers", "name": "Geocaching\\Sdk\\GeocachingSdk::getUsers", "doc": "&quot;swagger: GET \/v{api-version}\/users&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserLists", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserLists", "doc": "&quot;swagger: GET \/v{api-version}\/users\/{referenceCode}\/lists&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserGeocacheLogs", "doc": "&quot;swagger: GET \/v{api-version}\/users\/{referenceCode}\/geocachelogs&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdk::getUserWaypoints", "doc": "&quot;swagger: GET \/v{api-version}\/userwaypoints&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_setGeocacheUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdk::setGeocacheUserWaypoint", "doc": "&quot;swagger: POST \/v{api-version}\/userwaypoints&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheUserWaypoints", "doc": "&quot;swagger: GET \/v{api-version}\/geocaches\/{referenceCode}\/userwaypoints&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_deleteUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdk::deleteUserWaypoint", "doc": "&quot;swagger: DELETE \/v{api-version}\/userwaypoints\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_updateUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdk::updateUserWaypoint", "doc": "&quot;swagger: PUT \/v{api-version}\/userwaypoints\/{referenceCode}&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getReferenceCodeFromId", "name": "Geocaching\\Sdk\\GeocachingSdk::getReferenceCodeFromId", "doc": "&quot;swagger: GET \/v{api-version}\/utilities\/referencecode&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getCountries", "name": "Geocaching\\Sdk\\GeocachingSdk::getCountries", "doc": "&quot;swagger: GET \/v{api-version}\/countries&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getStates", "name": "Geocaching\\Sdk\\GeocachingSdk::getStates", "doc": "&quot;swagger: GET \/v{api-version}\/states&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getStatesByCountry", "name": "Geocaching\\Sdk\\GeocachingSdk::getStatesByCountry", "doc": "&quot;swagger: GET \/v{api-version}\/countries\/{countryId}\/states&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getMembershipLevels", "name": "Geocaching\\Sdk\\GeocachingSdk::getMembershipLevels", "doc": "&quot;swagger: GET \/v{api-version}\/membershiplevels&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheTypes", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheTypes", "doc": "&quot;swagger: GET \/v{api-version}\/geocachetypes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getAttributes", "name": "Geocaching\\Sdk\\GeocachingSdk::getAttributes", "doc": "&quot;swagger: GET \/v{api-version}\/attributes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getGeocacheLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdk::getGeocacheLogTypes", "doc": "&quot;swagger: GET \/v{api-version}\/geocachelogtypes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_getTrackableLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdk::getTrackableLogTypes", "doc": "&quot;swagger: GET \/v{api-version}\/trackablelogtypes&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_ping", "name": "Geocaching\\Sdk\\GeocachingSdk::ping", "doc": "&quot;swagger: GET \/status\/ping&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdk", "fromLink": "Geocaching/Sdk/GeocachingSdk.html", "link": "Geocaching/Sdk/GeocachingSdk.html#method_status", "name": "Geocaching\\Sdk\\GeocachingSdk::status", "doc": "&quot;alias of ping()&quot;"},
            
            {"type": "Class", "fromName": "Geocaching\\Sdk", "fromLink": "Geocaching/Sdk.html", "link": "Geocaching/Sdk/GeocachingSdkExtended.html", "name": "Geocaching\\Sdk\\GeocachingSdkExtended", "doc": "&quot;List of methods from Groundspeak API.&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkExtended", "fromLink": "Geocaching/Sdk/GeocachingSdkExtended.html", "link": "Geocaching/Sdk/GeocachingSdkExtended.html#method___construct", "name": "Geocaching\\Sdk\\GeocachingSdkExtended::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkExtended", "fromLink": "Geocaching/Sdk/GeocachingSdkExtended.html", "link": "Geocaching/Sdk/GeocachingSdkExtended.html#method_getMyProfile", "name": "Geocaching\\Sdk\\GeocachingSdkExtended::getMyProfile", "doc": "&quot;Get the full user&#039;s profile.&quot;"},
            
            {"type": "Class", "fromName": "Geocaching\\Sdk", "fromLink": "Geocaching/Sdk.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html", "name": "Geocaching\\Sdk\\GeocachingSdkInterface", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_searchGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::searchGeocaches", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocache", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocache", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocaches", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocaches", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateGeocacheNote", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheNote", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheNote", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheTrackables", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheTrackables", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackable", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserTrackables", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserTrackables", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocoinTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocoinTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteTrackableLog", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteTrackableLog", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setTrackableLogImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setTrackableLogImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getLogdrafts", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getLogdrafts", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_promoteLogdraft", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::promoteLogdraft", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setLogdraftImage", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setLogdraftImage", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheUserWaypoints", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserWaypoints", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserWaypoints", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteUserWaypoint", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteUserWaypoint", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_updateList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::updateList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_setBulkGeocachesList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::setBulkGeocachesList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteGeocacheList", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteGeocacheList", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUser", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUser", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUsers", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUsers", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserGeocacheLogs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserGeocacheLogs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserLists", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserLists", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserSouvenirs", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserSouvenirs", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getUserImages", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getUserImages", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getFriends", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getFriends", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getFriendRequests", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getFriendRequests", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_sendFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::sendFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_acceptFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::acceptFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteFriendRequest", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteFriendRequest", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_deleteFriend", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::deleteFriend", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getReferenceCodeFromId", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getReferenceCodeFromId", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getCountries", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getCountries", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getStates", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getStates", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getStatesByCountry", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getStatesByCountry", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getMembershipLevels", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getMembershipLevels", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getAttributes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getAttributes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getGeocacheLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getGeocacheLogTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_getTrackableLogTypes", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::getTrackableLogTypes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Geocaching\\Sdk\\GeocachingSdkInterface", "fromLink": "Geocaching/Sdk/GeocachingSdkInterface.html", "link": "Geocaching/Sdk/GeocachingSdkInterface.html#method_ping", "name": "Geocaching\\Sdk\\GeocachingSdkInterface::ping", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


