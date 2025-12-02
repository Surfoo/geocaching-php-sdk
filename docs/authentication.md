# Authentication & Tokens

The Geocaching API uses OAuth 2.0 bearer tokens. Bring an access token issued by Groundspeak and wire it into the SDK options. The SDK also ships with helpers for refreshing expired tokens automatically.

## Basic Token Usage

```php
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;

$options = new Options([
    'environment'  => Environment::PRODUCTION,
    'access_token' => 'your_access_token',
]);

$sdk = new GeocachingSdk($options);
```

## Automatic Token Refresh

Use the built-in `TokenRefreshPlugin` (from the `surfoo/oauth2-geocaching` package) to transparently refresh expired tokens and retry the failed request. You need:
- A `TokenStorageInterface` implementation to persist access/refresh tokens with locking.
- The user `referenceCode` (e.g., `PR12345`).
- A configured `League\OAuth2\Client\Provider\Geocaching` provider, or credentials so the SDK can create one.

### Storage Example

```php
use League\OAuth2\Client\Token\TokenSet;
use League\OAuth2\Client\Token\TokenStorageInterface;

final class InMemoryTokenStorage implements TokenStorageInterface
{
    private array $store = [];
    private array $locks = [];

    public function getTokens(string $referenceCode): ?TokenSet
    {
        return $this->store[$referenceCode] ?? null;
    }

    public function saveTokens(string $referenceCode, TokenSet $tokens): void
    {
        $this->store[$referenceCode] = $tokens;
    }

    public function lockUser(string $referenceCode, int $timeoutSeconds = 30): bool
    {
        if (!empty($this->locks[$referenceCode])) {
            return false;
        }
        $this->locks[$referenceCode] = true;
        return true;
    }

    public function unlockUser(string $referenceCode): void
    {
        unset($this->locks[$referenceCode]);
    }

    public function isUserLocked(string $referenceCode): bool
    {
        return !empty($this->locks[$referenceCode]);
    }
}
```

### Enable Refresh With an Existing Provider

```php
use League\OAuth2\Client\Provider\Geocaching as OAuthProvider;
use Monolog\Logger;

$oauthProvider = new OAuthProvider([
    'clientId'     => 'client_id',
    'clientSecret' => 'client_secret',
    'redirectUri'  => 'https://your-app.test/callback',
    'environment'  => 'production', // or 'staging'
]);

$options->enableTokenRefresh([
    'reference_code'     => 'PR12345',
    'storage'            => new InMemoryTokenStorage(),
    'oauth_provider'     => $oauthProvider,
    'logger'             => new Logger('token-refresh'), // optional
    'max_retry_attempts' => 3,                           // optional (default 3)
]);
```

### Enable Refresh With Credentials Only

Let the SDK create the OAuth provider for you:

```php
$options->enableTokenRefreshWithCredentials([
    'reference_code'     => 'PR12345',
    'storage'            => new InMemoryTokenStorage(),
    'client_id'          => 'client_id',
    'client_secret'      => 'client_secret',
    'redirect_uri'       => 'https://your-app.test/callback',
    'environment'        => 'staging', // production | staging | dev
    'logger'             => $logger,    // optional
    'max_retry_attempts' => 5,          // optional
]);
```

### How Refreshing Works
- The plugin intercepts `401` responses, refreshes the access token using the stored refresh token, retries the original request, and updates storage.
- Concurrency is protected with `lockUser()`/`unlockUser()` so simultaneous requests do not trigger multiple refreshes.
- If the refresh token is invalid or expired, a `RefreshTokenExpiredException` is thrown so you can restart the OAuth flow.

Persist tokens in durable storage (database, cache, or encrypted file) for production workloads; the in-memory example is for demos and testing only.
