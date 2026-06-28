<?php

declare(strict_types=1);

namespace Geocaching\Plugin;

use Http\Client\Common\Plugin;
use Http\Message\Authentication\Bearer;
use Http\Promise\Promise;
use League\OAuth2\Client\Token\TokenStorageInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Authentication plugin that always applies the freshest token from storage.
 *
 * Falls back to the initially configured access token when storage is empty.
 */
final readonly class StorageAwareAuthenticationPlugin implements Plugin
{
    public function __construct(
        private TokenStorageInterface $storage,
        private string $referenceCode,
        private string $fallbackAccessToken
    ) {
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $tokens = $this->storage->getTokens($this->referenceCode);

        if ($tokens) {
            $request = $request->withHeader('Authorization', $tokens->getAuthorizationHeader());
        } else {
            // Fall back to the original token so the first call still works
            $request = (new Bearer($this->fallbackAccessToken))->authenticate($request);
        }

        return $next($request);
    }
}
