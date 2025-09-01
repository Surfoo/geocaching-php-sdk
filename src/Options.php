<?php

declare(strict_types=1);

namespace Geocaching;

use Geocaching\Enum\BaseUri;
use Geocaching\Enum\Environment;
use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
use Geocaching\Plugin\TokenRefreshPlugin;
use Geocaching\Token\TokenStorageInterface;
use League\OAuth2\Client\Provider\Geocaching;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\Bearer;
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
        $this->getClientBuilder()->addPlugin(new AuthenticationPlugin(new Bearer($this->getAccessToken())));
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['environment', 'access_token', 'uri']);
        $resolver->setDefaults(
            [
                'client_builder' => new ClientBuilder(),
                'uri_factory'    => Psr17FactoryDiscovery::findUriFactory(),
            ]
        );

        $resolver->setAllowedTypes('environment', Environment::class);
        $resolver->setAllowedTypes('access_token', 'string');
        $resolver->setAllowedTypes('client_builder', ClientBuilder::class);
        $resolver->setAllowedTypes('uri_factory', UriFactoryInterface::class);
        $resolver->setAllowedTypes('uri', 'string');
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
     * @param array $config Configuration array with the following keys:
     *                      - user_id: User identifier for token storage
     *                      - storage: TokenStorageInterface implementation  
     *                      - oauth_provider: Geocaching OAuth provider instance
     *                      - logger: PSR-3 logger for token refresh events (optional)
     *                      - max_retry_attempts: Maximum retry attempts (optional, default: 3)
     * @return void
     * @throws \InvalidArgumentException If required configuration is missing
     */
    public function enableTokenRefresh(array $config): void
    {
        $this->validateTokenRefreshConfig($config);

        $plugin = new TokenRefreshPlugin(
            userId: $config['user_id'],
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
     * @param array $config Configuration array with the following keys:
     *                      - user_id: User identifier for token storage
     *                      - storage: TokenStorageInterface implementation  
     *                      - client_id: OAuth client ID
     *                      - client_secret: OAuth client secret
     *                      - redirect_uri: OAuth redirect URI
     *                      - environment: OAuth environment ('production', 'staging')
     *                      - logger: PSR-3 logger for token refresh events (optional)
     *                      - max_retry_attempts: Maximum retry attempts (optional, default: 3)
     * @return void
     * @throws \InvalidArgumentException If required configuration is missing
     */
    public function enableTokenRefreshWithCredentials(array $config): void
    {
        $this->validateTokenRefreshCredentialsConfig($config);

        // Create OAuth provider
        $oauthProvider = new Geocaching([
            'clientId' => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri' => $config['redirect_uri'],
            'environment' => $config['environment'] ?? 'production',
        ]);

        // Use the main method with the created provider
        $this->enableTokenRefresh([
            'user_id' => $config['user_id'],
            'storage' => $config['storage'],
            'oauth_provider' => $oauthProvider,
            'logger' => $config['logger'] ?? new \Psr\Log\NullLogger(),
            'max_retry_attempts' => $config['max_retry_attempts'] ?? 3
        ]);
    }

    /**
     * Validate token refresh configuration.
     *
     * @param array $config
     * @return void
     * @throws \InvalidArgumentException
     */
    private function validateTokenRefreshConfig(array $config): void
    {
        $required = ['user_id', 'storage', 'oauth_provider'];
        
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

        if (empty($config['user_id']) || !is_string($config['user_id'])) {
            throw new \InvalidArgumentException('user_id must be a non-empty string');
        }

        if (isset($config['max_retry_attempts']) && (!is_int($config['max_retry_attempts']) || $config['max_retry_attempts'] < 1)) {
            throw new \InvalidArgumentException('max_retry_attempts must be a positive integer if provided');
        }
    }

    /**
     * Validate token refresh configuration with credentials.
     *
     * @param array $config
     * @return void
     * @throws \InvalidArgumentException
     */
    private function validateTokenRefreshCredentialsConfig(array $config): void
    {
        $required = ['user_id', 'storage', 'client_id', 'client_secret', 'redirect_uri'];
        
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                throw new \InvalidArgumentException("Token refresh config missing required key: {$key}");
            }
        }

        if (!$config['storage'] instanceof TokenStorageInterface) {
            throw new \InvalidArgumentException('Token storage must implement TokenStorageInterface');
        }

        if (empty($config['user_id']) || !is_string($config['user_id'])) {
            throw new \InvalidArgumentException('user_id must be a non-empty string');
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
}
