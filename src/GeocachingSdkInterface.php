<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching;

use Geocaching\Client\AdventureClient;
use Geocaching\Client\FriendClient;
use Geocaching\Client\GeocacheClient;
use Geocaching\Client\ListClient;
use Geocaching\Client\LogClient;
use Geocaching\Client\LogdraftClient;
use Geocaching\Client\ReferenceDataClient;
use Geocaching\Client\StatusClient;
use Geocaching\Client\TrackableClient;
use Geocaching\Client\UserClient;
use Geocaching\Client\UserWaypointClient;
use Geocaching\Client\WherigoClient;

interface GeocachingSdkInterface
{
    public function getHttpClient(): \Psr\Http\Client\ClientInterface;
    public function adventureClient(): AdventureClient;
    public function friendClient(): FriendClient;
    public function logClient(): LogClient;
    public function geocacheClient(): GeocacheClient;
    public function trackableClient(): TrackableClient;
    public function userClient(): UserClient;
    public function listClient(): ListClient;
    public function logdraftClient(): LogdraftClient;
    public function referenceDataClient(): ReferenceDataClient;
    public function userWaypointClient(): UserWaypointClient;
    public function statusClient(): StatusClient;
    public function wherigoClient(): WherigoClient;
}
