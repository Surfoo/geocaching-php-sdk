<?php

/**
 * Geocaching API with PHP.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @link    https://github.com/Surfoo/geocaching-api
 * @license https://opensource.org/licenses/MIT
 */

namespace Geocaching\Api;

use Geocaching\Lib\Adapters\HttpClientInterface;
use Geocaching\Lib\Response\Response;

/**
 * List of methods from Groundspeak API.
 *
 * @link    https://github.com/Surfoo/geocaching-api Geocaching API on GitHub
 * @link    https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @link    https://api.groundspeak.com/api-docs/index Swagger
 */
class GeocachingApi extends GeocachingApi
{
    /**
     * Undocumented function
     *
     * @param array $fields
     * @return void
     */
    public function getMyProfile(array $fields = ['referenceCode', 'findCount', 'hideCount', 'favoritePoints', 'username', 'membershipLevelId', 'avatarUrl', 'homeCoordinates'])
    {
        $params = [];
        if (!empty($fields)) {
            $params = ['fields' => implode(',', $fields)];
        }

        return $this->httpClient->get('users/me', $params);
    }
}
