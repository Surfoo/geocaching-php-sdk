<?php

/**
 * Geocaching PHP SDK Extented.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see    https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Sdk;

use Geocaching\Lib\Adapters\HttpClientInterface;

class GeocachingSdkExtended extends GeocachingSdk
{
    public function __construct(HttpClientInterface $httpClient)
    {
        parent::__construct($httpClient);
    }

    /**
     * Get the full user's profile.
     *
     * @return \Geocaching\Lib\Adapters\GuzzleHttpClient
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
