<!-- logo -->
<img src="https://cdn.weglot.com/logo/logo-hor.png" height="40" />

# Laravel Package

<!-- tags -->
[![WeglotSlack](https://weglot-community.now.sh/badge.svg)](https://weglot-community.now.sh/)
[![Latest Stable Version](https://poser.pugx.org/weglot/translate-laravel/v/stable)](https://packagist.org/packages/weglot/translate-laravel)
[![Maintainability](https://api.codeclimate.com/v1/badges/574432a2fcb67231a109/maintainability)](https://codeclimate.com/github/weglot/translate-laravel/maintainability)
[![License](https://poser.pugx.org/weglot/translate-laravel/license)](https://packagist.org/packages/weglot/translate-laravel)

## Overview
Seamless integration of Weglot into your Laravel project.

## Requirements
- PHP version 5.5 and later
- Laravel 5.*
- Weglot API Key, starting at [free level](https://dashboard.weglot.com/register?origin=7)

## Installation
You can install the library via [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require weglot/translate-laravel
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once __DIR__. '/vendor/autoload.php';
```

## Getting Started

### Package Register

This package use auto-discovery, when you require it from composer, you should have nothing to do and Provider gonna be added automatically to your `config/app.php` providers list.

If this doesn't work, you can add our provider to the `config/app.php`, as following:
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

### Quick configuration

As usual for Laravel packages, you can publish configuration files by doing:
```bash
$ php artisan vendor:publish --provider="Weglot\Translate\TranslateServiceProvider" --tag="config"
```

You'll find the configuration file in `config/weglot-translate.php` with default values.
If you want to go deeper in [configuration](#configuration), I suggest you to consult the [corresponding part](#configuration) of this README.

## Configuration

Here is a full configuration file:
```php
<?php

return [
    'api_key' => env('WG_API_KEY'),
    'original_language' => config('app.locale', 'en'),
    'destination_languages' => [
        'fr'
    ],
    'exclude_blocks' => ['.site-name'],
    'exclude_urls' => ['\/admin\/.*'],
    'prefix_path' => '',
    'cache' => false,

    'laravel' => [
        'controller_namespace' => 'App\Http\Controllers',
        'routes_web' => 'routes/web.php'
    ]
];
```

This is an example of configuration, enter your own API key, your original language and destination languages that you want.
- `api_key` : is your personal API key. You can get an API Key by signing up on [Weglot](https://dashboard.weglot.com/register?origin=7).
- `original_language` : original language is the language of your website before translation.
- `destination_languages` : are the languages that you want your website to be translated into.
- `prefix_path` : if your laravel installation is not on webroot (ie. something like that: `https://my.website.com/foo/` is your actual root) set it to specify the path to your laravel installation
- `cache` : if you wanna use cache or not. It's not a required field and set as false by default. Look at [Caching part](#caching) for more details.

There is also a non-required parameters:
- `exclude_blocks` : where you can list all blocks you don't want to be translated. On this example, you can see that all blocks with the `site-name` class won't be translated.
- `exclude_urls` : you can prevent urls path from being translated (such as an admin path in this example)

And some Laravel-related parameters:
- `laravel.controller_namespace` : Used internaly when rewriting routes, change it if your Laravel namespace isn't `App` or your controllers are moved.
- `laravel.routes_web` : Used internaly when rewriting routes, refer to the file where you have all your web routes.

## Routing

Since we are adding routes for each destination languages we need a strong way to manipulate urls.

We choose to make that through named routes and `route()` helper.

When you create a route, you have to give a name as following:
```php
Route::get('/', 'Controller@method')
    ->name('my_route_name');
```

Then you can use it in your blade templates as following:
```twig
<a href="{{ route('my_route_name') }}">My link</a>
```

Like that, we will detect current language and adjust url if needed.

### Forcing language

You can force any language as following:
```twig
<a href="{{ route('my_route_name', ['_wg_lang' => 'es']) }}">My link</a>
```

Like that, it will force `es` language for this link !

## Caching

We implemented usage of `Cache` Facade for our package.

If you wanna use cache, just put the `cache` parameter to true in this package configuration. It will plug onto the Laravel cache behavior.

If you wanna clear your translation cache, just use the `weglot:cache:clear` command as following:
```bash
$ php artisan weglot:cache:clear
```

## Helper reference

### weglotCurrentUrlInstance

One of the core helper of this plugin it returns an instance of `Weglot\Util\Url` which is what manages:
- Detect current language
- What are translated urls based on current url
- Is a given url translable or not (based on `excludedUrls` option)
- Generate hreflinks

Here is some usage examples:
```php
$url = weglotCurrentUrlInstance();

// returns current language
$lang = $url->detectCurrentLanguage();

// returns all translated urls
$urls = $url->currentRequestAllUrls();
/**
 * Will return an array like this:
 * Array(
 *   'en' => 'https://weglot.com/',
 *   'fr' => 'https://weglot.com/fr',
 *   'es' => 'https://weglot.com/es',
 *   'de' => 'https://weglot.com/de'
 * )
 **/

// returns a boolean to know if the current url is translable
$translable = $url->isTranslable();

// returns string containing DOM with hreflang tags
$hreflangTags = $url->generateHrefLangsTags();
/**
 * Will return an array like this:
 * <link rel="alternate" href="https://weglot.com" hreflang="en"/>
 * <link rel="alternate" href="https://weglot.com/fr" hreflang="fr"/>
 * <link rel="alternate" href="https://weglot.com/es" hreflang="es"/>
 * <link rel="alternate" href="https://weglot.com/de" hreflang="de"/>
 **/
```

### weglotButtonRender

You can add a language button with the helper function: `weglotButtonRender`

Two layouts exists:
```blade
<!-- first layout -->
{{ weglotButtonRender(1) }}

<!-- second layout -->
{{ weglotButtonRender(2) }}
```

### weglotHrefLangRender

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

### weglotLanguage

Simple helper to convert ISO 639-1 code to full language name. It can takes one boolean parameter that allow you to choose having english name or original language name.

Here is a quick example:
```php
$name = weglotLanguage('bg');
// $name will contains: "Bulgarian"

$name = weglotLanguage('bg', false);
// $name will contains: "български"
```

## Examples

You'll find a short README with details about example on each repository:

- https://github.com/weglot/weglot-laravel-example-l5

## About
`translate-laravel` is guided and supported by the Weglot Developer Team.

`translate-laravel` is maintained and funded by Weglot SAS.
The names and logos for `translate-laravel` are trademarks of Weglot SAS.

## License
[The MIT License (MIT)](LICENSE.txt)
