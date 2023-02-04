# midnite81/core

[![Latest Stable Version](https://poser.pugx.org/midnite81/core/version)](https://packagist.org/packages/midnite81/core) [![Total Downloads](https://poser.pugx.org/midnite81/core/downloads)](https://packagist.org/packages/midnite81/core) [![Latest Unstable Version](https://poser.pugx.org/midnite81/core/v/unstable)](https://packagist.org/packages/midnite81/core) [![License](https://poser.pugx.org/midnite81/core/license.svg)](https://packagist.org/packages/midnite81/core)

This is a package for core activity within laravel projects. This is a work in progress and as such documentation is 
sparse, however in the coming weeks and months (and hopefully not years!), I hope to update this documentation.

This package contains;

- [Artisan Commands](docs/Commands.md)
- Attributes
- Eloquent Helpers
- Entities, Responses and Requests
- Exceptions
- Helper Functions
  - first
  - uuid
- Helper Classes 
  - Arrays
  - Attempts
  - ClassRetriever
  - HtmlLinks
  - Matches
  - Strings
  - UserAgent
- Middleware
- Base Actions and Repositories
- Uuid Generator

## Installation

This package requires PHP 8.1+ and has a Laravel Service Provider, which is auto-registered.

To install through composer include the package in your composer.json.
```composer
"midnite81/core": "^1.0"
```

Run composer install or composer update to download the dependencies, or you can run;

```bash
composer require midnite81/core
```

### Service Providers

By default, `Midnite81\Core\CoreServiceProvider` is automatically registered by laravel, unless you've actively turned
off auto registration in your application. Midnite81\Core ships with an additional service provider to enable the 
[Commands](docs/Commands.md) which come with this package. To install this (or both if needed), you need to add them 
to your `config/app.php`

```php
'providers' => [
//  ...
    \Midnite81\Core\CoreServiceProvider::class, // this is auto installed
    \Midnite81\Core\CoreCommandServiceProvider::class
//  ...
]
```

### Configuration files

You may wish to publish the configuration file if you're planning on using the 
[FireScriptCommand](docs/Commands/FireScriptsCommand.md) or 
[QuickFireScriptCommand](docs/Commands/QuickFireScriptsCommand.md)


```bash
php artisan vendor:publish --provider="Midnite81\Core\CoreServiceProvider"
```
