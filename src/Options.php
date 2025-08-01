<?php

declare(strict_types=1);

namespace Geocaching;

use Geocaching\Enum\BaseUri;
use Geocaching\Enum\Environment;
use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
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
}
