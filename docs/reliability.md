# Reliability & Observability

Use the SDK’s built-in plugins to log HTTP traffic, retry transient failures, and prevent cascading outages with a circuit breaker.

## HTTP Logging

Enable structured logging with sensible defaults:

```php
use Geocaching\Options;
use Psr\Log\LogLevel;

$options->enableHttpLogging(
    output: 'php://stdout', // file path or stream
    level: LogLevel::INFO,
    logBodies: false,
    maskTokens: true,
    maxBodyLength: 1000,
);
```

Key features:
- Correlates requests/responses with a unique ID.
- Masks tokens in URLs and `Authorization` headers when `maskTokens` is true.
- Adjusts log level automatically based on status codes (5xx → error, 4xx → warning).
- Truncates large bodies to `maxBodyLength` bytes when body logging is enabled.

Bring your own PSR-3 logger with custom handlers/formatters:

```php
use Monolog\Logger;
use Psr\Log\LogLevel;

$logger = new Logger('geocaching');
$options->enableHttpLoggingWithLogger(
    logger: $logger,
    level: LogLevel::DEBUG,
    logBodies: true,
    maskTokens: true,
    maxBodyLength: 2000,
);
```

## Retry Strategies

Handle transient errors automatically with two strategies:

- `configureRetry()` — exponential backoff (default). Config keys:  
  `max_attempts`, `base_delay_ms`, `multiplier`, `max_delay_ms`, `retryable_exceptions`, `retryable_status_codes`, `logger`.
- `configureFixedRetry()` — fixed delay between attempts. Config keys:  
  `max_attempts`, `delay_ms`, `retryable_exceptions`, `retryable_status_codes`, `logger`.

```php
$options->configureRetry([
    'max_attempts' => 4,
    'base_delay_ms' => 500,
    'multiplier' => 2.0,
    'retryable_status_codes' => [429, 500, 503],
]);
```

Default retryable status codes include `429`, `500`, `502`, `503`, and `504`, and common network exceptions are retried automatically.

## Circuit Breaker

Stop hammering an unhealthy service by opening the circuit after repeated failures:

```php
$breaker = $options->enableCircuitBreaker([
    'failure_threshold' => 5,  // open after 5 consecutive failures
    'recovery_timeout'  => 30, // seconds before trying again
    'success_threshold' => 2,  // successes needed in half-open state
]);
```

The `CircuitBreaker` tracks states (`closed` → `open` → `half_open`) and exposes getters (`getState()`, `getFailureCount()`, `getNextRetryTime()`). You can retrieve it later with `$options->getCircuitBreaker()`.

## Combined Reliability

Enable both retry and circuit breaker with one helper. The SDK uses a single plugin for efficiency:

```php
$reliability = $options->enableReliability([
    'circuit_breaker' => [
        'failure_threshold' => 4,
        'recovery_timeout'  => 20,
        'success_threshold' => 2,
    ],
    'retry' => [
        'base_delay_ms' => 750,
        'multiplier'    => 1.8,
        'max_attempts'  => 4,
    ],
    'logger' => $logger, // optional PSR-3 logger for both layers
]);

$reliability['circuit_breaker']; // CircuitBreaker
$reliability['retry_strategy'];  // RetryStrategy
```

Use `$options->getRetryStrategy()` to inspect retry settings from elsewhere in your code.
