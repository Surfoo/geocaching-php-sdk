<?php

/**
 * Geocaching PHP SDK.
 *
 * @author  Surfoo <surfooo@gmail.com>
 * @see     https://github.com/Surfoo/geocaching-php-sdk
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace Geocaching;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * List of methods from Groundspeak API.
 *
 * @see https://api.groundspeak.com/documentation API Documentation by Groundspeak
 * @see https://api.groundspeak.com/api-docs/index Swagger
 */
final class GeocachingSdk implements GeocachingSdkInterface
{
    private ClientBuilder $clientBuilder;

    public function __construct(Options $options)
    {
        $this->clientBuilder = $options->getClientBuilder();
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }

    /**
     * swagger: GET /v{api-version}/adventures/{adventureId}
     *
     * @see https://api.groundspeak.com/documentation#get-adventure
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Get
     */
    public function getAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/adventures/' . $adventureId, $headers);
    }

    /**
     * swagger: GET /v{api-version}/adventures/anon/{adventureId}
     *
     * @see https://api.groundspeak.com/documentation#get-adventure-start
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_GetStartLocation
     */
    public function getStartLocationAdventure(string $adventureId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/adventures/anon/' . $adventureId, $headers);
    }

    /**
     * swagger: GET /v{api-version}/adventures/search
     *
     * @see https://api.groundspeak.com/documentation#adventures-search
     * @see https://api.groundspeak.com/api-docs/index#!/Adventures/Adventures_Search
     */
    public function searchAdventures(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/adventures/search' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/friendrequests
     *
     * @see https://api.groundspeak.com/documentation#get-friendrequests
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriendRequests
     */
    public function getFriendRequests(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/friendrequests' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests
     *
     * @see https://api.groundspeak.com/documentation#create-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_CreateFriendRequest
     */
    public function sendFriendRequest(array $friendRequest, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/friendrequests' . $query, $headers, $friendRequest);
    }

    /**
     * swagger: GET /v{api-version}/friends
     *
     * @see https://api.groundspeak.com/documentation#get-friends
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriends
     */
    public function getFriends(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/friends' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/friends/geocaches/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_GetFriendsGeocacheLogs
     */
    public function getFriendsGeocacheLogsByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/friends/geocaches/' . $referenceCode . '/geocachelogs' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/friendrequests/{requestId}/accept
     *
     * @see https://api.groundspeak.com/documentation#accept-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_AcceptFriendRequest
     */
    public function acceptFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/friendrequests/' . $requestId . '/accept', $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/friends/{userCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-friend
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_RemoveFriend
     */
    public function deleteFriend(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/friends/' . $referenceCode, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/friendrequests/{requestId}
     *
     * @see https://api.groundspeak.com/documentation#delete-friendrequest
     * @see https://api.groundspeak.com/api-docs/index#!/Friends/Friends_DeleteFriendRequest
     */
    public function deleteFriendRequest(string $requestId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/friendrequests/' . $requestId, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteGeocacheLog
     */
    public function deleteGeocacheLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetGeocacheLog
     */
    public function getGeocacheLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocachelogs/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: PUT /v{api-version}/geocachelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_Put
     */
    public function updateGeocacheLog(string $referenceCode, array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->put('/geocachelogs/' . $referenceCode . $query, $headers, $geocacheLog);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/upvotes
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog-upvotes
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetLogUpvotes
     */
    public function getGeocacheLogUpvotes(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocachelogs/upvotes' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_GetImages
     */
    public function getGeocacheLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocachelogs/' . $referenceCode . '/images' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#create-geocachelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostImages
     */
    public function setGeocacheLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/geocachelogs/' . $referenceCode . '/images' . $query, $headers, $imageToUpload);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#create-geocachelog
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_PostLog
     */
    public function setGeocacheLog(array $geocacheLog, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/geocachelogs' . $query, $headers, $geocacheLog);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}/upvotes/{upvoteTypeId}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-upvote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteUpvote
     */
    public function deleteGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    /**
     * swagger: POST /v{api-version}/geocachelogs/{referenceCode}/upvotes/{upvoteTypeId}
     *
     * @see https://api.groundspeak.com/documentation#add-geocachelog-upvote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_AddUpvote
     */
    public function setGeocacheLogUpvotes(string $referenceCode, int $upvoteTypeId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/geocachelogs/' . $referenceCode . '/upvotes/' . $upvoteTypeId, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/geocachelogs/{referenceCode}/images/{imageGuid}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheLogs/GeocacheLogs_DeleteGeocacheLogImages
     */
    public function deleteGeocacheLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocachelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/geocaches/{referenceCode}/notes
     *
     * @see https://api.groundspeak.com/documentation#delete-geocachenote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_DeleteNote
     */
    public function deleteGeocacheNote(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocaches/' . $referenceCode . '/notes', $headers);
    }

    /**
     * swagger: PUT /v{api-version}/geocaches/{referenceCode}/notes
     *
     * @see https://api.groundspeak.com/documentation#upsert-geocachenote
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_Delete
     */
    public function updateGeocacheNote(string $referenceCode, array $note, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->put('/geocaches/' . $referenceCode . '/notes', $headers, $note);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geocache
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Get
     */
    public function getGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-images
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetImages
     */
    public function getGeocacheImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/images' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/favoritedby
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-favoritedby
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetFavoritedBy
     */
    public function getFavoritedUsersByGeocache(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/favoritedby' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetGeocaches
     */
    public function getGeocaches(array $query, array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/trackables
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/GeocacheNotes/GeocacheNotes_UpsertNote
     */
    public function getGeocacheTrackables(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/trackables' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_GetLogs
     */
    public function getGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/geocachelogs' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/search
     *
     * @see https://api.groundspeak.com/documentation#search
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_Search
     */
    public function searchGeocaches(array $query, array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/search' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/geocaches/{referenceCode}/finalcoordinates
     *
     * @see https://api.groundspeak.com/documentation#verify-final-coordinates
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_CheckFinalCoordinates
     */
    public function checkFinalCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/geocaches/' . $referenceCode . '/finalcoordinates', $headers, $coordinates);
    }

    /**
     * swagger: POST /v{api-version}/geocaches/{referenceCode}/bulktrackablelogs
     *
     * @see https://api.groundspeak.com/documentation#bulk-create-trackablelogs
     * @see https://api.groundspeak.com/api-docs/index#!/Geocaches/Geocaches_BulkCreateTrackableLogs
     */
    public function setBulkTrackableLogs(string $referenceCode, array $logs, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/geocaches/' . $referenceCode . '/bulktrackablelogs' . $query, $headers, $logs);
    }

    /**
     * swagger: GET /v{api-version}/geotours/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-geotour
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeoTour
     */
    public function getGeotour(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geotours/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geotours
     *
     * @see https://api.groundspeak.com/documentation#get-geotours
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeoTours
     */
    public function getGeotours(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geotours' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/geotours/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-geotour-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/GeoTours/GeoTours_GetGeocachesByGeoTour
     */
    public function getGeocachesGeotour(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geotours/' . $referenceCode . '/geocaches' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/HQPromotions/metadata
     *
     * @see https://api.groundspeak.com/api-docs/index#!/HQPromotions/HQPromotions_Get
     */
    public function getHQPromotions(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/HQPromotions/metadata', $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#remove-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveGeocache
     */
    public function deleteList(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/lists/' . $referenceCode, $headers);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetList
     */
    public function getList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/lists/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: PUT /v{api-version}/lists/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_UpdateList
     */
    public function updateList(string $referenceCode, array $list, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->put('/lists/' . $referenceCode . $query, $headers, $list);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches/zipped
     *
     * @see https://api.groundspeak.com/documentation#get-pq-zip
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetZippedPocketQuery
     */
    public function getZippedPocketQuery(string $referenceCode, string $dirname, array $headers = []): ResponseInterface
    {
        $fullAbsolutePath = sprintf('%s/%s.zip', $dirname, $referenceCode);
        $headers          = array_merge($headers, ['sink' => $fullAbsolutePath]);

        return $this->getHttpClient()->get('/lists/' . $referenceCode . '/geocaches/zipped', $headers);
    }

    /**
     * swagger: GET /v{api-version}/lists/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#get-list-geocaches
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_GetGeocaches
     */
    public function getGeocacheList(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/lists/' . $referenceCode . '/geocaches' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/geocaches
     *
     * @see https://api.groundspeak.com/documentation#add-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocache
     */
    public function setGeocacheList(string $referenceCode, array $geocache, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/lists/' . $referenceCode . '/geocaches' . $query, $headers, $geocache);
    }

    /**
     * swagger: POST /v{api-version}/lists
     *
     * @see https://api.groundspeak.com/documentation#create-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_PostList
     */
    public function setList(array $list, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/lists' . $query, $headers, $list);
    }

    /**
     * swagger: POST /v{api-version}/lists/{referenceCode}/bulkgeocaches
     *
     * @see https://api.groundspeak.com/documentation#add-geocaches-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_AddGeocaches
     */
    public function setBulkGeocachesList(string $referenceCode, array $body, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/lists/' . $referenceCode . '/bulkgeocaches', $body, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/lists/{referenceCode}/geocaches/{geocacheReferenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-geocache-list
     * @see https://api.groundspeak.com/api-docs/index#!/Lists/Lists_RemoveList
     */
    public function deleteGeocacheList(string $referenceCode, string $geocacheCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/lists/' . $referenceCode . '/geocaches/' . $geocacheCode, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Delete
     */
    public function deleteLogdraft(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/logdrafts/' . $referenceCode, $headers);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Get
     */
    public function getLogdraft(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/logdrafts/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: PUT /v{api-version}/logdrafts/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Put
     */
    public function updateLogdraft(string $referenceCode, array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->put('/logdrafts/' . $referenceCode . $query, $headers, $logDraft);
    }

    /**
     * swagger: GET /v{api-version}/logdrafts
     *
     * @see https://api.groundspeak.com/documentation#get-logdrafts
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_GetUserDrafts
     */
    public function getLogdrafts(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/logdrafts' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts
     *
     * @see https://api.groundspeak.com/documentation#create-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post
     */
    public function setLogdraft(array $logDraft, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/logdrafts' . $query, $headers, $logDraft);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/promote
     *
     * @see https://api.groundspeak.com/documentation#promote-logdraft
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_PromoteToGeocacheLog
     */
    public function promoteLogdraft(string $referenceCode, array $logDraft, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/logdrafts/' . $referenceCode . '/promote', $headers, $logDraft);
    }

    /**
     * swagger: POST /v{api-version}/logdrafts/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#create-logdraft-image
     * @see https://api.groundspeak.com/api-docs/index#!/LogDrafts/LogDrafts_Post_0
     */
    public function setLogdraftImage(string $referenceCode, array $postImage, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/logdrafts/' . $referenceCode . '/images' . $query, $headers, $postImage);
    }

    /**
     * swagger: DELETE /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_ArchiveTrackableLog
     */
    public function deleteTrackableLog(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/trackablelogs/' . $referenceCode, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetTrackableLog
     */
    public function getTrackableLog(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogs/' . $referenceCode, $query, $headers);
    }

    /**
     * swagger: PUT /v{api-version}/trackablelogs/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_Put
     */
    public function updateTrackableLog(string $referenceCode, array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->put('/trackablelogs/' . $referenceCode, $trackableLog, $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs
     *
     * @see https://api.groundspeak.com/documentation#get-user-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetTrackableLogs
     */
    public function getUserTrackableLog(array $query = [], array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogs/', $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_GetImages
     */
    public function getTrackableLogImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackablelogs/' . $referenceCode . '/images' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-images
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostImages
     */
    public function setTrackableLogImages(string $referenceCode, array $imageToUpload, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/trackablelogs/' . $referenceCode . '/images' . $query, $headers, $imageToUpload);
    }

    /**
     * swagger: DELETE /v{api-version}/trackablelogs/{referenceCode}/images/{imageGuid}
     *
     * @see https://api.groundspeak.com/documentation#delete-trackablelog-image
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_DeleteTrackableLogImages
     */
    public function deleteTrackableLogImage(string $referenceCode, string $imageGuid, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/trackablelogs/' . $referenceCode . '/images/' . $imageGuid, $headers);
    }

    /**
     * swagger: POST /v{api-version}/trackablelogs
     *
     * @see https://api.groundspeak.com/documentation#create-trackablelog
     * @see https://api.groundspeak.com/api-docs/index#!/TrackableLogs/TrackableLogs_PostLog
     */
    public function setTrackableLog(array $trackableLog, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->post('/trackablelogs' . $query, $headers, $trackableLog);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-trackable
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetTrackable
     */
    public function getTrackable(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackables
     *
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetUserTrackables
     */
    public function getUserTrackables(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/journeys
     *
     * @see https://api.groundspeak.com/documentation#get-trackable-journeys
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetTrackableJourneys
     */
    public function getTrackableJourneys(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/journeys' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackables/geocointypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocoin-types
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetGeocoinTypes
     */
    public function getGeocoinTypes(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables/geocointypes' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/Images
     *
     * @see https://api.groundspeak.com/documentation#get-users-trackables
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetImages
     */
    public function getTrackableImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/images' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackables/{referenceCode}/trackablelogs
     *
     * @see https://api.groundspeak.com/documentation#get-trackable-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Trackables/Trackables_GetLogs
     */
    public function getTrackableLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/trackables/' . $referenceCode . '/trackablelogs' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/privacysettings
     *
     * @see https://api.groundspeak.com/documentation#get-user-privacy-settings
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUserPrivacySettings
     */
    public function getUserPrivacySettings(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/privacysettings', $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#get-user
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUser
     */
    public function getUser(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/optedoutusers
     *
     * @see https://api.groundspeak.com/documentation#get-opted-out-users
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetOptedOutUsers
     */
    public function getOptedOutUsers(array $query, array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/optedoutusers' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/images
     *
     * @see https://api.groundspeak.com/documentation#get-user-images
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetImages
     */
    public function getUserImages(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/images' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/souvenirs
     *
     * @see https://api.groundspeak.com/documentation#get-souvenirs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetSouvenirs
     */
    public function getUserSouvenirs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/souvenirs' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users
     *
     * @see https://api.groundspeak.com/documentation#get-users
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetUsers
     */
    public function getUsers(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/lists
     *
     * @see https://api.groundspeak.com/documentation#get-lists
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetLists
     */
    public function getUserLists(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/lists' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/users/{referenceCode}/geocachelogs
     *
     * @see https://api.groundspeak.com/documentation#get-user-logs
     * @see https://api.groundspeak.com/api-docs/index#!/Users/Users_GetGeocacheLogs
     */
    public function getUserGeocacheLogs(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/users/' . $referenceCode . '/geocachelogs' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#get-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetUserWaypointsAsync
     */
    public function getUserWaypoints(array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/userwaypoints' . $query, $headers);
    }

    /**
     * swagger: POST /v{api-version}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#create-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Post
     */
    public function setGeocacheUserWaypoint(string $referenceCode, array $body, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/userwaypoints', $headers, $body);
    }

    /**
     * swagger: GET /v{api-version}/geocaches/{referenceCode}/userwaypoints
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-userwaypoints
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_GetGeocacheUserWaypointsAsync
     */
    public function getGeocacheUserWaypoints(string $referenceCode, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/geocaches/' . $referenceCode . '/userwaypoints' . $query, $headers);
    }

    /**
     * swagger: DELETE /v{api-version}/userwaypoints/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#delete-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Delete
     */
    public function deleteUserWaypoint(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/userwaypoints/' . $referenceCode, $headers);
    }

    /**
     * swagger: PUT /v{api-version}/geocaches/{referenceCode}/correctedcoordinates
     *
     * @see https://api.groundspeak.com/documentation#upsert-correctedcoordinates
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_UpsertCorrectedCoordinates
     */
    public function updateCorrectedCoordinates(string $referenceCode, array $coordinates, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->put('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers, $coordinates);
    }

    /**
     * swagger: DELETE /v{api-version}/geocaches/{referenceCode}/correctedcoordinates
     *
     * @see https://api.groundspeak.com/documentation#delete-correctedcoordinates
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_DeleteCorrectedCoordinates
     */
    public function deleteCorrectedCoordinates(string $referenceCode, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->delete('/geocaches/' . $referenceCode . '/correctedcoordinates', $headers);
    }

    /**
     * swagger: PUT /v{api-version}/userwaypoints/{referenceCode}
     *
     * @see https://api.groundspeak.com/documentation#update-userwaypoint
     * @see https://api.groundspeak.com/api-docs/index#!/UserWaypoints/UserWaypoints_Put
     */
    public function updateUserWaypoint(string $referenceCode, array $query, array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->put('/userwaypoints/' . $referenceCode . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/utilities/referencecode
     *
     * @see https://api.groundspeak.com/documentation#get-reference-code
     * @see https://api.groundspeak.com/api-docs/index#!/Utilities/Utilities_GetReferenceCode
     */
    public function getReferenceCodeFromId(array $query, array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/utilities/referencecode' . $query, $headers);
    }

    /**
     * swagger: GET /v{api-version}/countries
     *
     * @see https://api.groundspeak.com/documentation#get-countries
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetCountries
     */
    public function getCountries(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/countries', $headers);
    }

    /**
     * swagger: GET /v{api-version}/states
     *
     * @see https://api.groundspeak.com/documentation#get-states
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetStates
     */
    public function getStates(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/states', $headers);
    }

    /**
     * swagger: GET /v{api-version}/countries/{countryId}/states
     *
     * @see https://api.groundspeak.com/documentation#get-country-states
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetStatesByCountry
     */
    public function getStatesByCountry(int $countryId, array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/countries/' . $countryId . '/states', $headers);
    }

    /**
     * swagger: GET /v{api-version}/membershiplevels
     *
     * @see https://api.groundspeak.com/documentation#get-membership-levels
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetMembershipLevels
     */
    public function getMembershipLevels(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/membershiplevels', $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachetypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheTypes
     */
    public function getGeocacheTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachetypes', $headers);
    }

    /**
     * swagger: GET /v{api-version}/attributes
     *
     * @see https://api.groundspeak.com/documentation#get-attributes
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetAttributes
     */
    public function getAttributes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/attributes', $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachesizes
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-sizes
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheSizes
     */
    public function getGeocacheSizes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachesizes', $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachestatuses
     *
     * @see https://api.groundspeak.com/documentation#get-geocache-statuses
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheStatuses
     */
    public function getGeocacheStatuses(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachestatuses', $headers);
    }

    /**
     * swagger: GET /v{api-version}/geocachelogtypes
     *
     * @see https://api.groundspeak.com/documentation#get-geocachelog-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetGeocacheLogTypes
     */
    public function getGeocacheLogTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/geocachelogtypes', $headers);
    }

    /**
     * swagger: GET /v{api-version}/trackablelogtypes
     *
     * @see https://api.groundspeak.com/documentation#get-trackablelog-types
     * @see https://api.groundspeak.com/api-docs/index#!/ReferenceData/ReferenceData_GetTrackableLogTypes
     */
    public function getTrackableLogTypes(array $headers = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/trackablelogtypes', $headers);
    }

    /**
     * swagger: GET /v{api-version}/wherigo/{guid}/cartridge
     *
     * @see https://api.groundspeak.com/api-docs/index#!/Wherigo/Wherigo_GetWherigoCartridge
     */
    public function getWherigoCartridge(string $guid, array $query = [], array $headers = []): ResponseInterface
    {
        if (!empty($query)) {
            $query = '?' . http_build_query($query);
        }
        return $this->getHttpClient()->get('/wherigo/' . $guid . '/cartridge' . $query, $headers);
    }

    /**
     * swagger: GET /status/ping
     *
     * @see https://api.groundspeak.com/api-docs/index#!/Status/Status_PingAsync
     */
    public function ping(): ResponseInterface
    {
        return $this->getHttpClient()->get('/ping');
    }

    /**
     * alias of ping()
     */
    public function status(): ResponseInterface
    {
        return $this->ping();
    }
}
