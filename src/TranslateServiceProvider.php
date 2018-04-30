<?php

namespace Weglot\Translate;

use Illuminate\Support\ServiceProvider;
use Weglot\Translate\Providers\BladeServiceProvider;
use Weglot\Translate\Providers\RouterServiceProvider;

/**
 * Class TranslateServiceProvider
 * @package Weglot\Translate
 */
class TranslateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // publish & use custom configuration
        $this->publishes([
            __DIR__ . '/config.php' => config_path('weglot-translate.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'weglot-translate'
        );

        $this->app->register(RouterServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(BladeServiceProvider::class);
    }
}
