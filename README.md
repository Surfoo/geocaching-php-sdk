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

 - PHP >= 7.1
 - [composer](https://getcomposer.org/doc/00-intro.md#system-requirements).

## Composer

From the command line:

```
composer require surfoo/geocaching-php-sdk
```

Or in your `composer.json`:

``` json
{
    "require": {
        "surfoo/geocaching-php-sdk": "^3.0"
    }
}
```

For the old API (no longer maintained):

```
composer require geocaching/api
```

Or in your `composer.json`:

``` json
{
    "require": {
        "geocaching/api": "~2.0"
    }
}
```

## Using the PHP SDK

First, you must have your API key from Groundspeak, but access to the API are no longer open.

You can find an example of implementation (with OAuth 2) in this repository: https://github.com/Surfoo/geocaching-api-demo

## Contributing

All contributions are welcome! Feel free to submit pull requests, issues or ideas :-)