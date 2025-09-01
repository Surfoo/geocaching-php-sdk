<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Geocaching\Exception\RefreshTokenExpiredException;
use Geocaching\Exception\TokenRefreshException;
use Geocaching\Exception\TokenStorageException;
use Geocaching\Token\TokenSet;
use Geocaching\Token\TokenStorageInterface;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use League\OAuth2\Client\Provider\Geocaching;
use League\OAuth2\Client\Provider\Exception\GeocachingIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Plugin that automatically refreshes OAuth tokens when they expire.
 * 
 * Uses the League OAuth2 Geocaching provider for token refresh operations.
 * Intercepts 401 responses, refreshes the access token using the refresh token,
 * updates the storage, and retries the original request.
 */
class TokenRefreshPlugin implements Plugin
{
    private const MAX_RETRY_ATTEMPTS = 3;
    private const LOCK_WAIT_MICROSECONDS = [100000, 250000, 500000]; // Progressive backoff

    public function __construct(
        private string $userId,
        private TokenStorageInterface $storage,
        private Geocaching $oauthProvider,
        private LoggerInterface $logger = new NullLogger(),
        private int $maxRetryAttempts = self::MAX_RETRY_ATTEMPTS
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(
            function (ResponseInterface $response) use ($request, $first) {
                // If we get a 401, try to refresh the token and retry
                if ($response->getStatusCode() === 401) {
                    $this->logger->debug('[GEOCACHING] Received 401, attempting token refresh', [
                        'user_id' => $this->userId,
                        'request_uri' => (string) $request->getUri()
                    ]);
                    
                    return $this->refreshTokenAndRetry($request, $first);
                }
                
                return $response;
            },
            function (\Throwable $exception) {
                // Re-throw any other exceptions
                throw $exception;
            }
        );
    }

    /**
     * Refresh the token and retry the original request.
     */
    private function refreshTokenAndRetry(RequestInterface $request, callable $first): Promise
    {
        try {
            $newTokens = $this->refreshAccessToken();
            $newRequest = $this->updateRequestWithNewToken($request, $newTokens);
            
            $this->logger->info('[GEOCACHING] Token refreshed successfully, retrying request', [
                'user_id' => $this->userId,
                'expires_at' => $newTokens->expiresAt->format('Y-m-d H:i:s')
            ]);
            
            return $first($newRequest);
            
        } catch (RefreshTokenExpiredException $e) {
            $this->logger->error('[GEOCACHING] Refresh token expired, user must re-authenticate', [
                'user_id' => $this->userId,
                'error' => $e->getMessage()
            ]);
            throw $e;
            
        } catch (TokenRefreshException $e) {
            $this->logger->error('[GEOCACHING] Failed to refresh token', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'response_data' => $e->getResponseData()
            ]);
            throw $e;
        }
    }

    /**
     * Refresh the access token with concurrency protection.
     */
    private function refreshAccessToken(): TokenSet
    {
        // Try to acquire lock, with retries for concurrent requests
        for ($attempt = 0; $attempt < $this->maxRetryAttempts; $attempt++) {
            if ($this->storage->lockUser($this->userId)) {
                try {
                    return $this->performTokenRefresh();
                } finally {
                    $this->storage->unlockUser($this->userId);
                }
            }
            
            // Another process is refreshing, wait and check if they succeeded
            if ($attempt < $this->maxRetryAttempts - 1) {
                usleep(self::LOCK_WAIT_MICROSECONDS[$attempt] ?? 500000);
                
                // Check if the other process already refreshed the token
                $tokens = $this->storage->getTokens($this->userId);
                if ($tokens && !$tokens->isExpired()) {
                    $this->logger->debug('[GEOCACHING] Token was refreshed by another process', [
                        'user_id' => $this->userId
                    ]);
                    return $tokens;
                }
            }
        }
        
        throw new TokenStorageException("Could not acquire lock for user {$this->userId} after {$this->maxRetryAttempts} attempts");
    }

    /**
     * Perform the actual token refresh (must be called within lock).
     */
    private function performTokenRefresh(): TokenSet
    {
        // Get current tokens
        $currentTokens = $this->storage->getTokens($this->userId);
        if (!$currentTokens) {
            throw new TokenStorageException("No tokens found for user {$this->userId}");
        }

        // Check if token was already refreshed by another process
        if (!$currentTokens->isExpired()) {
            $this->logger->debug('[GEOCACHING] Token is no longer expired, using existing token', [
                'user_id' => $this->userId
            ]);
            return $currentTokens;
        }

        // Call OAuth refresh endpoint
        $oauthResponse = $this->callOAuthRefreshEndpoint($currentTokens->refreshToken);
        
        // Create new token set
        $newTokens = TokenSet::fromOAuthResponse($oauthResponse, $currentTokens->refreshToken);
        
        // Save to storage
        $this->storage->saveTokens($this->userId, $newTokens);
        
        return $newTokens;
    }

    /**
     * Call the OAuth refresh endpoint using the Geocaching provider.
     */
    private function callOAuthRefreshEndpoint(string $refreshToken): array
    {
        try {
            $this->logger->debug('[GEOCACHING] Refreshing token using OAuth provider', [
                'user_id' => $this->userId,
                'provider_class' => get_class($this->oauthProvider)
            ]);

            // Use the League OAuth2 provider to refresh the token
            $accessToken = $this->oauthProvider->getAccessToken('refresh_token', [
                'refresh_token' => $refreshToken
            ]);

            $this->logger->debug('[GEOCACHING] Token refresh successful', [
                'user_id' => $this->userId,
                'expires' => $accessToken->getExpires(),
                'has_refresh_token' => !empty($accessToken->getRefreshToken())
            ]);

            // Convert AccessToken to our expected array format
            return $this->convertAccessTokenToArray($accessToken, $refreshToken);

        } catch (GeocachingIdentityProviderException $e) {
            $this->logger->error('[GEOCACHING] OAuth provider exception during refresh', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'response_body' => method_exists($e, 'getResponseBody') ? $e->getResponseBody() : null
            ]);

            // Map provider exceptions to our exceptions
            $errorData = [];
            if (method_exists($e, 'getResponseBody')) {
                $responseBody = $e->getResponseBody();
                $errorData = json_decode($responseBody, true) ?? [];
            }

            // Check for expired refresh token errors
            if (isset($errorData['error'])) {
                $expiredErrors = ['invalid_grant', 'invalid_request', 'unauthorized_client'];
                if (in_array($errorData['error'], $expiredErrors)) {
                    throw new RefreshTokenExpiredException(
                        $errorData['error_description'] ?? 'Refresh token is invalid or expired'
                    );
                }
            }

            throw new TokenRefreshException(
                'OAuth provider error: ' . $e->getMessage(),
                $e->getCode(),
                $e,
                $errorData
            );

        } catch (\Exception $e) {
            $this->logger->error('[GEOCACHING] Unexpected error during token refresh', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e)
            ]);

            throw new TokenRefreshException(
                'Unexpected error during token refresh: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Convert League OAuth2 AccessToken to our expected array format.
     */
    private function convertAccessTokenToArray(AccessToken $accessToken, string $originalRefreshToken): array
    {
        return [
            'access_token' => $accessToken->getToken(),
            'refresh_token' => $accessToken->getRefreshToken() ?: $originalRefreshToken,
            'expires_in' => $accessToken->getExpires() ? ($accessToken->getExpires() - time()) : 3600,
            'token_type' => 'Bearer',
            'scope' => null,
        ];
    }

    /**
     * Update request with new access token.
     */
    private function updateRequestWithNewToken(RequestInterface $request, TokenSet $tokens): RequestInterface
    {
        return $request->withHeader('Authorization', $tokens->getAuthorizationHeader());
    }
}