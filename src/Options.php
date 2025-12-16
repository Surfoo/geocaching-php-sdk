<?php

declare(strict_types=1);

namespace Geocaching;

use Geocaching\Enum\BaseUri;
use Geocaching\Enum\Environment;
use Geocaching\Plugin\CircuitBreakerPlugin;
use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
use Geocaching\Plugin\StorageAwareAuthenticationPlugin;
use Geocaching\Plugin\ReliabilityPlugin;
use Geocaching\Plugin\RetryPlugin;
use Geocaching\Reliability\CircuitBreaker;
use Geocaching\Reliability\ExponentialBackoffStrategy;
use Geocaching\Reliability\FixedDelayStrategy;
use Geocaching\Reliability\RetryStrategy;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\Bearer;
use League\OAuth2\Client\Provider\Geocaching;
use League\OAuth2\Client\Plugin\TokenRefreshPlugin;
use League\OAuth2\Client\Token\TokenStorageInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Options
{
    /**
     * @const string
     */
    public const API_VERSION = 'v1';

    private array $options;

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $baseUri = match ($options['environment']) {
            Environment::STAGING => BaseUri::STAGING,
            default              => BaseUri::PRODUCTION,
        };

        $options['uri'] = sprintf('%s/%s/', $baseUri->value, self::API_VERSION);

        $this->options = $resolver->resolve($options);

        // Set base URI for status endpoints (without version)
        $this->getClientBuilder()->setBaseUri($baseUri->value);
        
        $this->getClientBuilder()->addPlugin(new BaseUriPlugin($this->getUri()));
        $this->addAuthenticationPlugin();
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['environment', 'access_token', 'uri']);
        $resolver->setDefaults(
            [
                'client_builder' => new ClientBuilder(),
                'uri_factory'    => Psr17FactoryDiscovery::findUriFactory(),
                'token_storage'  => null,
                'reference_code' => null,
            ]
        );

        $resolver->setAllowedTypes('environment', Environment::class);
        $resolver->setAllowedTypes('access_token', 'string');
        $resolver->setAllowedTypes('client_builder', ClientBuilder::class);
        $resolver->setAllowedTypes('uri_factory', UriFactoryInterface::class);
        $resolver->setAllowedTypes('uri', 'string');
        $resolver->setAllowedTypes('token_storage', [TokenStorageInterface::class, 'null']);
        $resolver->setAllowedTypes('reference_code', ['string', 'null']);
    }

    public function getClientBuilder(): ClientBuilder
    {
        return $this->options['client_builder'];
    }

    public function getUriFactory(): UriFactoryInterface
    {
        return $this->options['uri_factory'];
    }

    public function getUri(): UriInterface
    {
        return $this->getUriFactory()->createUri($this->options['uri']);
    }

    public function getAccessToken(): string
    {
        return $this->options['access_token'];
    }

    /**
     * Register an authentication plugin that always uses the freshest token.
     *
     * If a TokenStorage is provided, we pull the current token from storage so
     * retries after refresh use the updated access token. Otherwise we fall
     * back to a static Bearer token.
     */
    private function addAuthenticationPlugin(): void
    {
        $storage       = $this->options['token_storage'];
        $referenceCode = $this->options['reference_code'];

        if ($storage && $referenceCode) {
            $plugin = new StorageAwareAuthenticationPlugin(
                $storage,
                $referenceCode,
                $this->getAccessToken()
            );
        } else {
            $plugin = new AuthenticationPlugin(new Bearer($this->getAccessToken()));
        }

        $this->getClientBuilder()->addPlugin($plugin);
    }
    
    /**
     * Enable HTTP logging for all API requests/responses with a pre-configured logger.
     *
     * This method creates and configures a Monolog logger with proper PSR-3 placeholder
     * support out of the box. Perfect for quick debugging and development.
     *
     * @param string $output        Output destination ('php://stdout', 'php://stderr', file path, etc.)
     * @param string $level         Log level (default: INFO)
     * @param bool   $logBodies     Whether to log request/response bodies (default: false)
     * @param bool   $maskTokens    Whether to mask sensitive tokens (default: true)
     * @param int    $maxBodyLength Maximum body length before truncation (default: 1000)
     * @param string $logFormat     Custom log format (optional)
     */
    public function enableHttpLogging(
        string $output = 'php://stdout',
        string $level = LogLevel::INFO,
        bool $logBodies = false,
        bool $maskTokens = true,
        int $maxBodyLength = 1000,
        ?string $logFormat = null
    ): void {
        $logger = $this->createConfiguredLogger($output, $level, $logFormat);
        $this->enableHttpLoggingWithLogger($logger, $level, $logBodies, $maskTokens, $maxBodyLength);
    }

    /**
     * Enable HTTP logging with a custom logger instance.
     *
     * Use this method if you want full control over the logger configuration,
     * custom handlers, formatters, or processors.
     *
     * @param LoggerInterface $logger        Custom PSR-3 logger instance
     * @param string          $level         Log level (default: INFO)
     * @param bool            $logBodies     Whether to log request/response bodies (default: false)
     * @param bool            $maskTokens    Whether to mask sensitive tokens (default: true)
     * @param int             $maxBodyLength Maximum body length before truncation (default: 1000)
     */
    public function enableHttpLoggingWithLogger(
        LoggerInterface $logger,
        string $level = LogLevel::INFO,
        bool $logBodies = false,
        bool $maskTokens = true,
        int $maxBodyLength = 1000
    ): void {
        $loggingPlugin = new GeocachingHttpLoggerPlugin(
            $logger,
            $level,
            $logBodies,
            $maskTokens,
            $maxBodyLength
        );
        
        $this->getClientBuilder()->addPlugin($loggingPlugin);
    }

    /**
     * Create a pre-configured Monolog logger with proper PSR-3 placeholder support.
     *
     * @param  string      $output    Output destination
     * @param  string      $level     Log level
     * @param  string|null $logFormat Custom log format (null for default)
     * @return Logger      Configured logger instance
     */
    private function createConfiguredLogger(string $output, string $level, ?string $logFormat = null): Logger
    {
        $logger = new Logger('geocaching-api');
        
        // Convert PSR-3 log level string to Monolog Level
        $monologLevel = match (strtolower($level)) {
            'debug'     => Level::Debug,
            'info'      => Level::Info,
            'notice'    => Level::Notice,
            'warning'   => Level::Warning,
            'error'     => Level::Error,
            'critical'  => Level::Critical,
            'alert'     => Level::Alert,
            'emergency' => Level::Emergency,
            default     => Level::Info,
        };
        
        // Create handler
        $handler = new StreamHandler($output, $monologLevel);
        
        // Configure formatter with PSR-3 placeholder support
        $format    = $logFormat ?? "[%datetime%] %channel%.%level_name%: %message% %context%\n";
        $formatter = new LineFormatter(
            $format,
            'Y-m-d H:i:s',
            true, // Allow inline line breaks
            true  // Ignore empty context and extra
        );
        
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);
        
        return $logger;
    }

    /**
     * Enable automatic token refresh when access tokens expire.
     *
     * This adds a TokenRefreshPlugin that will automatically refresh expired access tokens
     * using the provided OAuth provider and storage implementation.
     *
     * @param  array                     $config Configuration array with the following keys:
     *                                           - reference_code: User reference code for token storage
     *                                           - storage: TokenStorageInterface implementation
     *                                           - oauth_provider: Geocaching OAuth provider instance
     *                                           - logger: PSR-3 logger for token refresh events (optional)
     *                                           - max_retry_attempts: Maximum retry attempts (optional, default: 3)
     * @throws \InvalidArgumentException If required configuration is missing
     */
    public function enableTokenRefresh(array $config): void
    {
        $this->validateTokenRefreshConfig($config);

        $plugin = new TokenRefreshPlugin(
            referenceCode: $config['reference_code'],
            storage: $config['storage'],
            oauthProvider: $config['oauth_provider'],
            logger: $config['logger'] ?? new \Psr\Log\NullLogger(),
            maxRetryAttempts: $config['max_retry_attempts'] ?? 3
        );

        $this->getClientBuilder()->addPlugin($plugin);
    }

    /**
     * Enable automatic token refresh with OAuth provider auto-creation.
     *
     * This is a convenience method that creates the OAuth provider for you.
     * Use enableTokenRefresh() if you want more control over the provider configuration.
     *
     * @param  array                     $config Configuration array with the following keys:
     *                                           - reference_code: User reference code for token storage
     *                                           - storage: TokenStorageInterface implementation
     *                                           - client_id: OAuth client ID
     *                                           - client_secret: OAuth client secret
     *                                           - redirect_uri: OAuth redirect URI
     *                                           - environment: OAuth environment ('production', 'staging')
     *                                           - logger: PSR-3 logger for token refresh events (optional)
     *                                           - max_retry_attempts: Maximum retry attempts (optional, default: 3)
     * @throws \InvalidArgumentException If required configuration is missing
     */
    public function enableTokenRefreshWithCredentials(array $config): void
    {
        $this->validateTokenRefreshCredentialsConfig($config);

        // Create OAuth provider
        $oauthProvider = new Geocaching([
            'clientId'     => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri'  => $config['redirect_uri'],
            'environment'  => $config['environment'] ?? 'production',
        ]);

        // Use the main method with the created provider
        $this->enableTokenRefresh([
            'reference_code'     => $config['reference_code'],
            'storage'            => $config['storage'],
            'oauth_provider'     => $oauthProvider,
            'logger'             => $config['logger'] ?? new \Psr\Log\NullLogger(),
            'max_retry_attempts' => $config['max_retry_attempts'] ?? 3,
        ]);
    }

    /**
     * Validate token refresh configuration.
     *
     * @throws \InvalidArgumentException
     */
    private function validateTokenRefreshConfig(array $config): void
    {
        $required = ['reference_code', 'storage', 'oauth_provider'];
        
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                throw new \InvalidArgumentException("Token refresh config missing required key: {$key}");
            }
        }

        if (!$config['storage'] instanceof TokenStorageInterface) {
            throw new \InvalidArgumentException('Token storage must implement TokenStorageInterface');
        }

        if (!$config['oauth_provider'] instanceof Geocaching) {
            throw new \InvalidArgumentException('OAuth provider must be an instance of League\OAuth2\Client\Provider\Geocaching');
        }

        if (empty($config['reference_code']) || !is_string($config['reference_code'])) {
            throw new \InvalidArgumentException('reference_code must be a non-empty string');
        }

        if (isset($config['max_retry_attempts']) && (!is_int($config['max_retry_attempts']) || $config['max_retry_attempts'] < 1)) {
            throw new \InvalidArgumentException('max_retry_attempts must be a positive integer if provided');
        }
    }

    /**
     * Validate token refresh configuration with credentials.
     *
     * @throws \InvalidArgumentException
     */
    private function validateTokenRefreshCredentialsConfig(array $config): void
    {
        $required = ['reference_code', 'storage', 'client_id', 'client_secret', 'redirect_uri'];
        
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                throw new \InvalidArgumentException("Token refresh config missing required key: {$key}");
            }
        }

        if (!$config['storage'] instanceof TokenStorageInterface) {
            throw new \InvalidArgumentException('Token storage must implement TokenStorageInterface');
        }

        if (empty($config['reference_code']) || !is_string($config['reference_code'])) {
            throw new \InvalidArgumentException('reference_code must be a non-empty string');
        }

        if (empty($config['client_id']) || !is_string($config['client_id'])) {
            throw new \InvalidArgumentException('client_id must be a non-empty string');
        }

        if (empty($config['client_secret']) || !is_string($config['client_secret'])) {
            throw new \InvalidArgumentException('client_secret must be a non-empty string');
        }

        if (empty($config['redirect_uri']) || !is_string($config['redirect_uri'])) {
            throw new \InvalidArgumentException('redirect_uri must be a non-empty string');
        }

        if (isset($config['environment']) && !in_array($config['environment'], ['production', 'staging', 'dev'])) {
            throw new \InvalidArgumentException('environment must be one of: production, staging, dev');
        }

        if (isset($config['max_retry_attempts']) && (!is_int($config['max_retry_attempts']) || $config['max_retry_attempts'] < 1)) {
            throw new \InvalidArgumentException('max_retry_attempts must be a positive integer if provided');
        }
    }

    /**
     * Enable circuit breaker pattern to prevent cascading failures.
     *
     * Circuit breaker monitors failures and temporarily stops making requests
     * to failing services, allowing them time to recover.
     *
     * @param  array          $config Configuration array with the following keys:
     *                                - failure_threshold: Number of failures before opening circuit (default: 5)
     *                                - recovery_timeout: Seconds before trying to close circuit (default: 30)
     *                                - success_threshold: Successes needed to close circuit from half-open (default: 2)
     *                                - logger: PSR-3 logger for circuit breaker events (optional)
     * @return CircuitBreaker The configured circuit breaker instance
     */
    public function enableCircuitBreaker(array $config = []): CircuitBreaker
    {
        $circuitBreaker = new CircuitBreaker(
            failureThreshold: $config['failure_threshold'] ?? 5,
            recoveryTimeoutSeconds: $config['recovery_timeout'] ?? 30,
            successThreshold: $config['success_threshold'] ?? 2
        );

        // Store circuit breaker for plugin usage
        $this->options['circuit_breaker'] = $circuitBreaker;
        
        // Add circuit breaker plugin to HTTP client
        $plugin = new CircuitBreakerPlugin(
            $circuitBreaker,
            $config['logger'] ?? new \Psr\Log\NullLogger()
        );
        $this->getClientBuilder()->addPlugin($plugin);
        
        return $circuitBreaker;
    }

    /**
     * Configure retry behavior with exponential backoff.
     *
     * Automatically retries failed requests with increasing delays between attempts.
     * Best for handling temporary network issues and rate limiting.
     *
     * @param  array         $config Configuration array with the following keys:
     *                               - max_attempts: Maximum retry attempts (default: 3)
     *                               - base_delay_ms: Base delay in milliseconds (default: 1000)
     *                               - multiplier: Backoff multiplier (default: 2.0)
     *                               - max_delay_ms: Maximum delay cap (default: 30000)
     *                               - retryable_exceptions: Exception classes to retry (optional)
     *                               - retryable_status_codes: HTTP status codes to retry (optional)
     *                               - logger: PSR-3 logger for retry events (optional)
     * @return RetryStrategy The configured retry strategy
     */
    public function configureRetry(array $config = []): RetryStrategy
    {
        $strategy = new ExponentialBackoffStrategy(
            baseDelayMs: $config['base_delay_ms'] ?? 1000,
            multiplier: $config['multiplier'] ?? 2.0,
            maxDelayMs: $config['max_delay_ms'] ?? 30000,
            maxAttempts: $config['max_attempts'] ?? 3,
            retryableExceptions: $config['retryable_exceptions'] ?? null,
            retryableStatusCodes: $config['retryable_status_codes'] ?? null
        );

        $this->options['retry_strategy'] = $strategy;
        
        // Add retry plugin to HTTP client
        $plugin = new RetryPlugin(
            $strategy,
            $config['logger'] ?? new \Psr\Log\NullLogger()
        );
        $this->getClientBuilder()->addPlugin($plugin);
        
        return $strategy;
    }

    /**
     * Configure retry behavior with fixed delays.
     *
     * Retries failed requests with consistent delays between attempts.
     * Simpler than exponential backoff, good for predictable retry patterns.
     *
     * @param  array         $config Configuration array with the following keys:
     *                               - max_attempts: Maximum retry attempts (default: 3)
     *                               - delay_ms: Fixed delay in milliseconds (default: 1000)
     *                               - retryable_exceptions: Exception classes to retry (optional)
     *                               - retryable_status_codes: HTTP status codes to retry (optional)
     *                               - logger: PSR-3 logger for retry events (optional)
     * @return RetryStrategy The configured retry strategy
     */
    public function configureFixedRetry(array $config = []): RetryStrategy
    {
        $strategy = new FixedDelayStrategy(
            delayMs: $config['delay_ms'] ?? 1000,
            maxAttempts: $config['max_attempts'] ?? 3,
            retryableExceptions: $config['retryable_exceptions'] ?? null,
            retryableStatusCodes: $config['retryable_status_codes'] ?? null
        );

        $this->options['retry_strategy'] = $strategy;
        
        // Add retry plugin to HTTP client
        $plugin = new RetryPlugin(
            $strategy,
            $config['logger'] ?? new \Psr\Log\NullLogger()
        );
        $this->getClientBuilder()->addPlugin($plugin);
        
        return $strategy;
    }

    /**
     * Enable both circuit breaker and retry with optimized defaults.
     *
     * This convenience method configures both reliability patterns with
     * settings that work well together for most use cases. Uses a combined
     * plugin for optimal performance.
     *
     * @param  array $config Configuration array with keys for both circuit breaker and retry
     * @return array Returns ['circuit_breaker' => CircuitBreaker, 'retry_strategy' => RetryStrategy]
     */
    public function enableReliability(array $config = []): array
    {
        $circuitBreaker = new CircuitBreaker(
            failureThreshold: $config['circuit_breaker']['failure_threshold'] ?? 5,
            recoveryTimeoutSeconds: $config['circuit_breaker']['recovery_timeout'] ?? 30,
            successThreshold: $config['circuit_breaker']['success_threshold'] ?? 2
        );

        $retryStrategy = new ExponentialBackoffStrategy(
            baseDelayMs: $config['retry']['base_delay_ms'] ?? 1000,
            multiplier: $config['retry']['multiplier'] ?? 2.0,
            maxDelayMs: $config['retry']['max_delay_ms'] ?? 30000,
            maxAttempts: $config['retry']['max_attempts'] ?? 3,
            retryableExceptions: $config['retry']['retryable_exceptions'] ?? null,
            retryableStatusCodes: $config['retry']['retryable_status_codes'] ?? null
        );

        // Store both for getters
        $this->options['circuit_breaker'] = $circuitBreaker;
        $this->options['retry_strategy']  = $retryStrategy;
        
        // Add combined reliability plugin (more efficient than separate plugins)
        $plugin = new ReliabilityPlugin(
            $circuitBreaker,
            $retryStrategy,
            $config['logger'] ?? new \Psr\Log\NullLogger()
        );
        $this->getClientBuilder()->addPlugin($plugin);
        
        return [
            'circuit_breaker' => $circuitBreaker,
            'retry_strategy'  => $retryStrategy,
        ];
    }

    /**
     * Get the configured circuit breaker instance.
     */
    public function getCircuitBreaker(): ?CircuitBreaker
    {
        return $this->options['circuit_breaker'] ?? null;
    }

    /**
     * Get the configured retry strategy.
     */
    public function getRetryStrategy(): ?RetryStrategy
    {
        return $this->options['retry_strategy'] ?? null;
    }
}
