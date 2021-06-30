# Package for use PrestaShop Webservice on Laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lucasgiovanny/laravel-prestashop.svg?style=flat-square)](https://packagist.org/packages/lucasgiovanny/laravel-prestashop)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lucasgiovanny/laravel-prestashop/run-tests?label=tests)](https://github.com/lucasgiovanny/laravel-prestashop/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/lucasgiovanny/laravel-prestashop/Check%20&%20fix%20styling?label=code%20style)](https://github.com/lucasgiovanny/laravel-prestashop/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lucasgiovanny/laravel-prestashop.svg?style=flat-square)](https://packagist.org/packages/lucasgiovanny/laravel-prestashop)

## Installation

You can install the package via composer:

```bash
composer require lucasgiovanny/laravel-prestashop
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Lucasgiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider" --tag="laravel-prestashop-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Lucasgiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider" --tag="laravel-prestashop-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-prestashop = new Lucasgiovanny\LaravelPrestashop();
echo $laravel-prestashop->echoPhrase('Hello, Spatie!');
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

- [Lucas Giovanny](https://github.com/lucasgiovanny)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
