# Laravel Updater

[![Latest Version on Packagist](https://img.shields.io/packagist/v/salahhusa9/laravel-updater.svg?style=flat-square)](https://packagist.org/packages/salahhusa9/laravel-updater)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/salahhusa9/laravel-updater/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/salahhusa9/laravel-updater/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/salahhusa9/laravel-updater/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/salahhusa9/laravel-updater/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/salahhusa9/laravel-updater.svg?style=flat-square)](https://packagist.org/packages/salahhusa9/laravel-updater)

This is a useful package for update your laravel project with one command/one click.

## Support us

You can support us by [buying me a coffee](https://github.com/sponsors/salahhusa9) ☕️ .

## Installation

You can install the package via composer:

```bash
composer require salahhusa9/laravel-updater
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-updater-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-updater-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-updater-views"
```

## Usage

<!-- ```php
$updater = new Salahhusa9\Updater();
echo $updater->echoPhrase('Hello, Salahhusa9!');
``` -->

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [salahhusa9](https://github.com/salahhusa9)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
