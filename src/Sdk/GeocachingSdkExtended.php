<?php

/**
 * Geocaching PHP SDK Extented.
 *
 * @author  Surfoo <surfooo@gmail.com>
 *
 * @see    https://github.com/Surfoo/geocaching-api
 *
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

use Geocaching\Lib\Adapters\HttpClientInterface;

/**
 * List of methods from Groundspeak API.
 *
 * @see    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @see    https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see    https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingSdkExtended extends GeocachingSdk
{
    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        parent::__construct($httpClient);
    }

    /**
     * Get the full user's profile.
     *
     * @param array $fields
     *
     * @return GuzzleHttpClient
     */
    public function getMyProfile(array $fields = ['referenceCode', 'findCount', 'hideCount', 'favoritePoints', 'username', 'membershipLevelId', 'avatarUrl', 'homeCoordinates'])
    {
        $query = [];
        if (!empty($fields)) {
            $query = ['fields' => implode(',', $fields)];
        }

        return $this->httpClient->get('users/me', $query);
    }
}
