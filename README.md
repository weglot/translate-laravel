<!-- logo -->
<img src="https://cdn.weglot.com/logo/logo-hor.png" height="40" />

# Laravel Package

<!-- tags -->
[![Latest Stable Version](https://poser.pugx.org/weglot/weglot-laravel/v/stable)](https://packagist.org/packages/weglot/weglot-laravel)
[![License](https://poser.pugx.org/weglot/weglot-laravel/license)](https://packagist.org/packages/weglot/weglot-laravel)

## Overview
Seamless integration of Weglot into your Laravel project.

## Requirements
- PHP version 5.5 and later
- Weglot API Key, starting at [free level](https://dashboard.weglot.com/register)

## Installation
You can install the library via [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require weglot/weglot-laravel
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once __DIR__. '/vendor/autoload.php';
```

## Getting Started

### Package Register

#### Laravel 5

Add Weglot package in the `config/app.php`:
```php
return [
    // ...

    'providers' => [
        // ... Other packages ...
        Weglot\Translate\TranslateServiceProvider::class
    ],

    // ...
];
```

### Configuration

As usual for Laravel packages, you can publish configuration files by doing:
```bash
$ php artisan vendor:publish --provider="Weglot\Translate\TranslateServiceProvider" --tag="config"
```

You'll find the configuration file in `config/weglot-translate.php`:
```php
<?php

return [
    'api_key' => env('WG_API_KEY'),
    'original_language' => config('app.locale', 'en'),
    'destination_languages' => [
        'fr'
    ],
    'exclude_blocks' => ['.site-name'],
    'cache' => false,

    'laravel' => [
        'controller_namespace' => 'App\Http\Controllers',
        'routes_web' => 'routes/web.php'
    ]
];
```

This is an example of configuration, enter your own API key, your original language and destination languages that you want.
- `api_key` : is your personal API key. You can get an API Key by signing up on [Weglot](https://weglot.com/).
- `original_language` : original language is the language of your website before translation.
- `destination_languages` : are the languages that you want your website to be translated into.
- `cache` : if you wanna use cache or not. It's not a required field and set as false by default. Look at [Caching part](#caching) for more details.
- `laravel.controller_namespace` : Used internaly when rewriting routes, change it if your Laravel namespace isn't `App` or your controllers are moved.
- `laravel.routes_web` : Used internaly when rewriting routes, refer to the file where you have all your web routes.

There is also a non-required parameters `exclude_blocks` where you can list all blocks you don't want to be translated. On this example, you can see that all blocks with the `site-name` class won't be translated.

### Caching

We implemented usage of `Cache` Facade for our package.

If you wanna use cache, just put the `cache` parameter to true in this package configuration. It will plug onto the Laravel cache behavior.

### Optional - Hreflang links

Hreflang links are a way to describe your website and to tell webcrawlers (such as search engines) if this page is available in other languages.
More details on Google post about hreflang: https://support.google.com/webmasters/answer/189077

You can add them through the helper function: `weglotHrefLangRender`

Just put the function at the end of your `<head>` tag:
```blade
<html>
    <head>
        ...

        {{ weglotHrefLangRender() }}
    </head>
```

### Optional - Language button

You can add a language button with the helper function: `weglotButtonRender`

Two layouts exists:
```blade
<!-- first layout -->
{{ weglotButtonRender(1) }}

<!-- second layout -->
{{ weglotButtonRender(2) }}
```


## Examples

// TODO

## About
`weglot-laravel` is guided and supported by the Weglot Developer Team.

`weglot-laravel` is maintained and funded by Weglot SAS.
The names and logos for `weglot-laravel` are trademarks of Weglot SAS.

## License
[The MIT License (MIT)](LICENSE.txt)
