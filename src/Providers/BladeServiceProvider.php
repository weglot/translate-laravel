<?php

namespace Weglot\Translate\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Weglot\Client\Api\LanguageCollection;
use Weglot\Client\Api\LanguageEntry;
use Weglot\Client\Client;
use Weglot\Client\Endpoint\Languages;
use Weglot\Translate\Compilers\BladeCompiler;

/**
 * Class RouterServiceProvider
 * @package Weglot\Translate
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * @var LanguageCollection
     */
    protected $languageCollection = null;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->fetchLanguageCollection();

        // language filter, used to get locale full name from ISO 639-1 code
        Blade::directive('language', function ($locale) {
            $language = $this->languageCollection->getCode($locale);
            if (!$language instanceof LanguageEntry) {
                return '';
            }
            return $language->getLocalName();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // adding our custom blade compiler class to view service
        $app = $this->app;
        $resolver = $app['view']->getEngineResolver();

        $resolver->register('blade', function () use ($app) {
            $compiler = new BladeCompiler($app['files'], $app['config']['view.compiled']);

            return new CompilerEngine($compiler);
        });
    }

    /**
     * Fetching languages collection from Weglot API
     */
    protected function fetchLanguageCollection()
    {
        $client = new Client(config('weglot-translate.api_key'));
        $translate = new Languages($client);
        $this->languageCollection = $translate->handle();
    }
}
