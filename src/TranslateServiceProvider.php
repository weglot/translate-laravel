<?php

namespace Weglot\Translate;

use Illuminate\Support\ServiceProvider;

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
        $this->publishes([
            __DIR__ . '/config.php' => config_path('weglot-translate.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'weglot-translate'
        );
    }
}
