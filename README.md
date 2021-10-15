# Laravel Centrifugo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/meetjet/laravel-centrifugo.svg?style=flat-square)](https://packagist.org/packages/meetjet/laravel-centrifugo)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/meetjet/laravel-centrifugo/run-tests?label=tests)](https://github.com/meetjet/laravel-centrifugo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/meetjet/laravel-centrifugo/Check%20&%20fix%20styling?label=code%20style)](https://github.com/meetjet/laravel-centrifugo/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/meetjet/laravel-centrifugo.svg?style=flat-square)](https://packagist.org/packages/meetjet/laravel-centrifugo)

## Features
- Compatible with latest [Centrifugo 3.0.3](https://github.com/centrifugal/centrifugo/releases/tag/v3.0.3) 
- Contains instructions and configuration file for setting up with Laravel Sail

## Installation

You can install the package via composer:

```bash
composer require meetjet/laravel-centrifugo
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Meetjet\LaravelCentrifugo\LaravelCentrifugoServiceProvider" --tag="laravel-centrifugo-config"
```

This is the contents of the published config file:
```php
return [
];
```

## Usage

```php
$laravel-centrifugo = new Meetjet\LaravelCentrifugo();
echo $laravel-centrifugo->echoPhrase('Hello, Meetjet!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Zorca Orcinus](https://github.com/zorca)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
