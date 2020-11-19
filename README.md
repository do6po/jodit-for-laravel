An easy way to use the Jodit editor with your Laravel Api service.

## Installation

The package can be installed via composer:
``` bash
composer require do6po/laravel-jodit
```

If you are using Laravel version &lt;= 5.4 or [the package discovery](https://laravel.com/docs/5.5/packages#package-discovery)
is disabled, add the following providers in `config/app.php`:

```php
'providers' => [
    Do6po\LaravelJodit\Providers\JoditServiceProvider::class,
]
``` 

## Configuration

To configure the package you need to publish settings first:

```
php artisan vendor:publish --provider="Do6po\LaravelJodit\Providers\JoditServiceProvider" --tag=config
```

See comments inside the config:  `config/jodit.php`.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.