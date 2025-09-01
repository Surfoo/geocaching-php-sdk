<?php

declare(strict_types=1);

namespace Geocaching\Token;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Represents a set of OAuth tokens (access + refresh) with expiration.
 */
readonly class TokenSet
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
        public DateTimeInterface $expiresAt,
        public ?string $tokenType = 'Bearer',
        public ?array $scopes = null
    ) {
        if (empty($accessToken)) {
            throw new InvalidArgumentException('Access token cannot be empty');
        }
        if (empty($refreshToken)) {
            throw new InvalidArgumentException('Refresh token cannot be empty');
        }
    }

    /**
     * Create TokenSet from OAuth response array.
     *
     * @param array $oauthResponse The OAuth response containing tokens
     * @param string $refreshToken The current refresh token (if not in response)
     * @return self
     */
    public static function fromOAuthResponse(array $oauthResponse, ?string $refreshToken = null): self
    {
        $accessToken = $oauthResponse['access_token'] ?? '';
        $expiresIn = (int) ($oauthResponse['expires_in'] ?? 3600);
        $newRefreshToken = $oauthResponse['refresh_token'] ?? $refreshToken;
        $tokenType = $oauthResponse['token_type'] ?? 'Bearer';
        $scopes = isset($oauthResponse['scope']) ? explode(' ', $oauthResponse['scope']) : null;

        if (!$newRefreshToken) {
            throw new InvalidArgumentException('Refresh token must be provided');
        }

        $expiresAt = new DateTimeImmutable("+{$expiresIn} seconds");

        return new self($accessToken, $newRefreshToken, $expiresAt, $tokenType, $scopes);
    }

    /**
     * Create TokenSet with manual expiration time.
     *
     * @param string $accessToken
     * @param string $refreshToken  
     * @param int $expiresInSeconds Seconds until expiration
     * @return self
     */
    public static function create(string $accessToken, string $refreshToken, int $expiresInSeconds = 3600): self
    {
        $expiresAt = new DateTimeImmutable("+{$expiresInSeconds} seconds");
        return new self($accessToken, $refreshToken, $expiresAt);
    }

    /**
     * Check if the access token is expired or will expire soon.
     *
     * @param int $bufferSeconds Safety buffer in seconds (default: 60)
     * @return bool True if expired or expires soon
     */
    public function isExpired(int $bufferSeconds = 60): bool
    {
        $now = new DateTimeImmutable();
        $expiryWithBuffer = $this->expiresAt->modify("-{$bufferSeconds} seconds");
        
        return $now >= $expiryWithBuffer;
    }

    /**
     * Get seconds until expiration.
     *
     * @return int Seconds until expiration (negative if already expired)
     */
    public function getSecondsUntilExpiry(): int
    {
        $now = new DateTimeImmutable();
        return $this->expiresAt->getTimestamp() - $now->getTimestamp();
    }

    /**
     * Get the Authorization header value.
     *
     * @return string The complete Authorization header value
     */
    public function getAuthorizationHeader(): string
    {
        return $this->tokenType . ' ' . $this->accessToken;
    }

    /**
     * Convert to array for storage.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'expires_at' => $this->expiresAt->format('Y-m-d H:i:s'),
            'token_type' => $this->tokenType,
            'scopes' => $this->scopes,
        ];
    }

    /**
     * Create from stored array.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $expiresAt = new DateTimeImmutable($data['expires_at']);
        
        return new self(
            $data['access_token'],
            $data['refresh_token'],
            $expiresAt,
            $data['token_type'] ?? 'Bearer',
            $data['scopes'] ?? null
        );
    }
}