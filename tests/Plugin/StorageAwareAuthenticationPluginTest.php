<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Geocaching\Plugin\StorageAwareAuthenticationPlugin;
use Http\Promise\FulfilledPromise;
use League\OAuth2\Client\Token\TokenSet;
use League\OAuth2\Client\Token\TokenStorageInterface;
use Nyholm\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class StorageAwareAuthenticationPluginTest extends TestCase
{
    public function testUsesTokenFromStorageWhenAvailable(): void
    {
        $tokens = TokenSet::create('fresh-access', 'refresh-token', 3600);

        $storage = $this->createMock(TokenStorageInterface::class);
        $storage->expects($this->once())
            ->method('getTokens')
            ->with('user-123')
            ->willReturn($tokens);

        $plugin = new StorageAwareAuthenticationPlugin($storage, 'user-123', 'fallback-access');

        $capturedRequest = null;
        $next = function ($request) use (&$capturedRequest) {
            $capturedRequest = $request;
            return new FulfilledPromise('ok');
        };

        $plugin->handleRequest(new Request('GET', 'https://example.com'), $next, $next)->wait();

        self::assertSame(
            'Bearer fresh-access',
            $capturedRequest->getHeaderLine('Authorization'),
            'Should apply authorization header from storage tokens'
        );
    }

    public function testFallsBackToProvidedAccessTokenWhenStorageEmpty(): void
    {
        $storage = $this->createMock(TokenStorageInterface::class);
        $storage->expects($this->once())
            ->method('getTokens')
            ->with('user-123')
            ->willReturn(null);

        $plugin = new StorageAwareAuthenticationPlugin($storage, 'user-123', 'fallback-access');

        $capturedRequest = null;
        $next = function ($request) use (&$capturedRequest) {
            $capturedRequest = $request;
            return new FulfilledPromise('ok');
        };

        $plugin->handleRequest(new Request('GET', 'https://example.com'), $next, $next)->wait();

        self::assertSame(
            'Bearer fallback-access',
            $capturedRequest->getHeaderLine('Authorization'),
            'Should fall back to initial bearer when storage has no tokens'
        );
    }
}
