PHP project (>=8.2) with Symfony.

This project is a PHP library for using the Geocaching API.
- Official API Swagger: https://api.groundspeak.com/api-docs/v1/swagger
- Official documentation: https://api.groundspeak.com/documentation

## Architecture
- Uses PSR-7, PSR-17, PSR-18 for HTTP client agnosticism
- HTTPlug for HTTP client abstraction
- Plugin architecture with Http\Client\Common\Plugin
- Clients separated by business domain (GeocacheClient, UserClient, etc.)

## Environments
- Production: https://api.groundspeak.com
- Staging: https://staging.api.groundspeak.com
- StatusClient uses absolute URLs to bypass auth

## HTTP Logging
- GeocachingHttpLoggerPlugin available for HTTP request/response logging
- Automatic token masking in logs
- Configuration via Options::enableHttpLogging()

## Tests
- PHPUnit 12 with PHP 8 attributes (#[DataProvider])
- Unit tests in tests/
- Test command: composer run phpunit
- Currently 77 tests, 189 assertions

## Common Issues Fixed
- Query string concatenation: use ternary operator to avoid "Array to string conversion"
- Interface types: HttpMethodsClientInterface instead of HttpMethodsClient
- StatusClient bypasses auth/BaseUri plugins but keeps logging

## API Reference URLs
All clients follow official Swagger patterns:
- /geocaches, /users, /adventures, /lists, /logs, /trackables, etc.
- Adventure anon endpoints: /adventures/anon/ (not /adventures/) 