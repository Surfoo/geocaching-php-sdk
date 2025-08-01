<?php

declare(strict_types=1);

namespace Geocaching;

use Http\Client\Common\HttpMethodsClientInterface;

/**
 * Interface for building HTTP clients that are PSR-18 compatible.
 *
 * The returned HttpMethodsClientInterface provides convenient methods like get(), post(), etc.
 * and implements ClientInterface (PSR-18).
 */
interface ClientBuilderInterface
{
    /**
     * Get an HTTP client with convenience methods.
     *
     * @return HttpMethodsClientInterface A PSR-18 compatible client with convenience methods
     */
    public function getHttpClient(): HttpMethodsClientInterface;
    
    /**
     * Get the base URI without API version (for status endpoints).
     *
     * @return string The base URI (e.g., https://api.groundspeak.com)
     */
    public function getBaseUri(): string;
    
    /**
     * Set the base URI for status endpoints.
     *
     * @param string $baseUri The base URI without version
     */
    public function setBaseUri(string $baseUri): void;
    // Client factory methods for dependency injection
    public function getAdventureClient(): \Geocaching\Client\AdventureClient;
    public function getFriendClient(): \Geocaching\Client\FriendClient;
    public function getLogClient(): \Geocaching\Client\LogClient;
    public function getGeocacheClient(): \Geocaching\Client\GeocacheClient;
    public function getTrackableClient(): \Geocaching\Client\TrackableClient;
    public function getUserClient(): \Geocaching\Client\UserClient;
    public function getListClient(): \Geocaching\Client\ListClient;
    public function getLogdraftClient(): \Geocaching\Client\LogdraftClient;
    public function getReferenceDataClient(): \Geocaching\Client\ReferenceDataClient;
    public function getUserWaypointClient(): \Geocaching\Client\UserWaypointClient;
    public function getStatusClient(): \Geocaching\Client\StatusClient;
    public function getWherigoClient(): \Geocaching\Client\WherigoClient;
    public function getStatisticsClient(): \Geocaching\Client\StatisticsClient;
}
