<?php

declare(strict_types=1);

namespace Geocaching\Token;

/**
 * Interface for token storage implementations.
 * 
 * Allows users to implement their own storage mechanism (database, Redis, file, etc.)
 * with concurrent access protection.
 */
interface TokenStorageInterface
{
    /**
     * Retrieve tokens for a specific user.
     *
     * @param string $userId The user identifier
     * @return TokenSet|null The token set or null if not found
     */
    public function getTokens(string $userId): ?TokenSet;

    /**
     * Save tokens for a specific user.
     *
     * @param string $userId The user identifier
     * @param TokenSet $tokens The tokens to save
     * @return void
     */
    public function saveTokens(string $userId, TokenSet $tokens): void;

    /**
     * Acquire exclusive lock for a user to prevent concurrent token refreshes.
     *
     * @param string $userId The user identifier
     * @param int $timeoutSeconds Lock timeout in seconds (default: 30)
     * @return bool True if lock acquired, false otherwise
     */
    public function lockUser(string $userId, int $timeoutSeconds = 30): bool;

    /**
     * Release the lock for a user.
     *
     * @param string $userId The user identifier
     * @return void
     */
    public function unlockUser(string $userId): void;

    /**
     * Check if a user is currently locked by another process.
     *
     * @param string $userId The user identifier
     * @return bool True if locked, false otherwise
     */
    public function isUserLocked(string $userId): bool;
}