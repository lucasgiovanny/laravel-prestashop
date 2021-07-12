# Package for use PrestaShop Webservice on Laravel

This package still in development. Feel free to contribute and give ideas!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lucasgiovanny/laravel-prestashop.svg?style=flat-square)](https://packagist.org/packages/lucasgiovanny/laravel-prestashop)
[![Total Downloads](https://img.shields.io/packagist/dt/lucasgiovanny/laravel-prestashop.svg?style=flat-square)](https://packagist.org/packages/lucasgiovanny/laravel-prestashop)

## Installation

You can install the package via composer:

```bash
composer require lucasgiovanny/laravel-prestashop
```


You can publish the config file with:
```bash
php artisan vendor:publish --provider="Lucasgiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider" --tag="laravel-prestashop-config"
```

## Usage

The idea of this package it's to easily use Prestashop webservice. You'll be able to retrieve and use your store data as close as possible from Laravel's Eloquent syntax.

Before start, you need to configure your store webservice. You have two ways of do it:

1. Set store on the config file

To connect your Prestashop webservice, you can define this settings on your `.env` file:

```env
PRESTASHOP_ENDPOINT=https://prestashop.example/api
PRESTASHOP_TOKEN=YOUR-WEBSERVICE-TOKEN
```

If you prefer, you can define it directly on the `config/prestashop.php` file

2. On-demand

You can also define the store directly when executing an action:
```php
use LucasGiovanny\LaravelPrestashop\Facades\Prestashop;

Prestashop::store("https://prestashop.example.com/api", "YOUR-WEBSERVICE-TOKEN")
    ->orders()
    ->get();
```

### Retrieve information from a resource

Let's retrieve all Prestashop orders for example:

```php
use Lucasgiovanny\LaravelPrestashop\Facades\Prestashop;

$orders = Prestashop::orders()->get();
// This will output a Laravel collection with all orders

foreach($orders as $order){
    $order->id;
    $order->total_paid;
    ///...
}
```

### Choose the data you want to display

You can use `display()` method or the `select()` method.

```php
use Lucasgiovanny\LaravelPrestashop\Facades\Prestashop;

$orders = Prestashop::orders()->select('id')->get(); //It'll return only order id

$orders = Prestashop::orders()->select(['id', 'reference','invoice_number'])->get();
```

### Using filters

You can use `filter()` method or the `where()` method.

```php
use Lucasgiovanny\LaravelPrestashop\Facades\Prestashop;

// Works like Laravel Eloquent query builder method! :)
$orders = Prestashop::orders()->filter('reference', 'XKBKNABJK')->get();

$orders = Prestashop::orders()->where('reference','BEGIN', 'XKB')->get();
```

### Find or first

You can use `find()` method to find a resource by id or the `first()` method to retrieve the first element from the request.

```php
use Lucasgiovanny\LaravelPrestashop\Facades\Prestashop;

$orders = Prestashop::customers()->find(23);

$orders = Prestashop::customers()->first();
```

## Testing

On the todo list.

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
