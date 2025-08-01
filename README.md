# Geocaching PHP SDK

[![Latest Stable Version](https://poser.pugx.org/surfoo/geocaching-php-sdk/v/stable.svg)](https://packagist.org/packages/surfoo/geocaching-php-sdk)
[![Total Downloads](https://poser.pugx.org/surfoo/geocaching-php-sdk/downloads.svg)](https://packagist.org/packages/surfoo/geocaching-php-sdk)
[![Latest Unstable Version](https://poser.pugx.org/surfoo/geocaching-php-sdk/v/unstable.svg)](https://packagist.org/packages/surfoo/geocaching-php-sdk)

The documentation about the API is available here: 
  - https://api.groundspeak.com/documentation
  - https://api.groundspeak.com/api-docs/index

You can follow changes about the documentation and the API here:
  - https://github.com/Surfoo/groundspeak-api-monitoring

## Requirements

 - PHP >= 8.1
 - [composer](https://getcomposer.org/doc/00-intro.md#system-requirements).

## Composer

From the command line:

```
composer require surfoo/geocaching-php-sdk
```

## Using the PHP SDK

First, you must have your API key from Groundspeak, but access to the API are no longer open.

You can find an example of implementation (with OAuth 2) in this repository: https://github.com/Surfoo/geocaching-api-demo

## Usage Guide

See [`USAGE.md`](./USAGE.md) for detailed usage instructions, including:
- How to use the new modular client structure (recommended)
- How to use legacy method calls (backward compatibility)
- Examples for common API calls

## HTTP Request/Response Logging

The SDK provides comprehensive HTTP logging capabilities to help with debugging and monitoring API interactions. The logging feature includes:

- **Request/Response Correlation**: Each request gets a unique ID to match requests with their responses
- **Automatic Token Masking**: Sensitive authentication tokens are automatically masked for security
- **Configurable Detail Levels**: Choose what information to log (headers, bodies, timing)
- **Status-based Log Levels**: Automatic log level adjustment based on HTTP status codes
- **Performance Metrics**: Request duration tracking in milliseconds

### Quick Setup

```php
use Geocaching\Enum\Environment;
use Geocaching\GeocachingSdk;
use Geocaching\Options;
use Psr\Log\LogLevel;

// Initialize SDK options
$options = new Options([
    'environment' => Environment::STAGING,
    'access_token' => 'your_token_here',
]);

// Enable HTTP logging (automatically configured with proper PSR-3 support)
$options->enableHttpLogging(
    'php://stdout',    // Output destination (console, file path, etc.)
    LogLevel::INFO,    // Log level (DEBUG, INFO, WARNING, ERROR)
    false,            // Log request/response bodies (true/false)
    true,             // Mask sensitive tokens (true/false)
    1000              // Max body length before truncation
);

// Create SDK instance
$sdk = new GeocachingSdk($options);

// All API calls will now be logged
$response = $sdk->status()->ping();
```

### Configuration Options

#### Simple Logging (enableHttpLogging)

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$output` | `string` | `'php://stdout'` | Output destination (console, file path, etc.) |
| `$level` | `string` | `LogLevel::INFO` | Base log level for successful requests |
| `$logBodies` | `bool` | `false` | Whether to include request/response bodies |
| `$maskTokens` | `bool` | `true` | Automatically mask sensitive authentication data |
| `$maxBodyLength` | `int` | `1000` | Maximum body length before truncation |
| `$logFormat` | `string\|null` | `null` | Custom log format (null for default) |

#### Advanced Logging (enableHttpLoggingWithLogger)

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$logger` | `LoggerInterface` | *required* | Custom PSR-3 compatible logger |
| `$level` | `string` | `LogLevel::INFO` | Base log level for successful requests |
| `$logBodies` | `bool` | `false` | Whether to include request/response bodies |
| `$maskTokens` | `bool` | `true` | Automatically mask sensitive authentication data |
| `$maxBodyLength` | `int` | `1000` | Maximum body length before truncation |

### Log Output Example

```
[2025-01-15 10:30:15] geocaching-api.INFO: [GEOCACHING] HTTP Request: GET https://staging.api.groundspeak.com/v1/users/PR12345 {"request_id":"req_65a5b2f7c8d9e","method":"GET","uri":"https://staging.api.groundspeak.com/v1/users/PR12345","headers":{"authorization":["***"],"content-type":["application/json"]}}

[2025-01-15 10:30:15] geocaching-api.INFO: [GEOCACHING] HTTP Response: 200 OK (245.67ms) {"request_id":"req_65a5b2f7c8d9e","status_code":200,"duration_ms":245.67,"reason_phrase":"OK","headers":{"content-type":["application/json"],"x-ratelimit-remaining":["999"]}}
```

### Security Features

- **Token Masking**: Automatically masks tokens in URLs (`access_token=***`) and headers (`Authorization: ***`)
- **Selective Header Logging**: Only logs relevant response headers, excluding sensitive information
- **Body Truncation**: Large request/response bodies are truncated to prevent log flooding

### Advanced Usage

#### Using a Custom Logger

For full control over logging behavior:

```php
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\UidProcessor;

// Create custom logger with rotating files and unique request IDs
$customLogger = new Logger('geocaching-api');
$customLogger->pushHandler(new RotatingFileHandler('logs/geocaching.log', 7));
$customLogger->pushProcessor(new UidProcessor());

// Use custom logger
$options->enableHttpLoggingWithLogger(
    $customLogger,
    LogLevel::DEBUG,
    true,  // Log bodies
    true,  // Mask tokens  
    2000   // Max body length
);
```

#### Custom Log Format

You can customize the log format:

```php
$options->enableHttpLogging(
    'logs/api.log',
    LogLevel::INFO,
    false,
    true,
    1000,
    "[%datetime%] %level_name%: %message%\n" // Custom format
);
```

#### Multiple Output Destinations

```php
// Log to console for development
$options->enableHttpLogging('php://stdout', LogLevel::DEBUG);

// Or log to file for production
$options->enableHttpLogging('/var/log/geocaching-api.log', LogLevel::WARNING);
```

## Contributing

All contributions are welcome! Feel free to submit pull requests, issues or ideas :-)
