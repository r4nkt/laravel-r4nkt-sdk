# A Laravel SDK that makes working with r4nkt even easier.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/r4nkt/laravel-r4nkt-sdk.svg?style=flat-square)](https://packagist.org/packages/r4nkt/laravel-r4nkt-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/r4nkt/laravel-r4nkt-sdk/run-tests?label=tests)](https://github.com/r4nkt/laravel-r4nkt-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/r4nkt/laravel-r4nkt-sdk/Check%20&%20fix%20styling?label=code%20style)](https://github.com/r4nkt/laravel-r4nkt-sdk/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/r4nkt/laravel-r4nkt-sdk.svg?style=flat-square)](https://packagist.org/packages/r4nkt/laravel-r4nkt-sdk)

---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this laravel-r4nkt-sdk
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files
3. Remove this block of text.
4. Have fun creating your package.
5. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---

[R4nkt](https://r4nkt.com) makes it easy to gamify just about anything. This package makes it even easier to gamify your Laravel-based projects.

Before using this package we highly recommend reading [the documentation over at R4nkt](https://docs.r4nkt.com).

## Installation

You can install the package via composer:

```bash
composer require r4nkt/laravel-r4nkt-sdk
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="R4nkt\\LaravelR4nkt\\LaravelR4nktServiceProvider" --tag="laravel-r4nkt-sdk-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="R4nkt\\LaravelR4nkt\\LaravelR4nktServiceProvider" --tag="laravel-r4nkt-sdk-config"
```

This is the contents of the published config file:

```php
return [
    /** @todo */
];
```

## Usage

```php
/** @todo */
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

If you discover any security related issues, please email support@r4nkt.com instead of using the issue tracker.

## Credits

- [Travis Elkins](https://github.com/telkins)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
