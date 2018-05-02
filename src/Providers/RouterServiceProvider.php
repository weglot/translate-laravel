<?php

namespace Weglot\Translate\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class RouterServiceProvider
 * @package Weglot\Translate
 */
class RouterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $destinationLanguages = config('weglot-translate.destination_languages');
        foreach ($destinationLanguages as $destination) {
            Route::middleware('web')
                ->namespace(config('weglot-translate.laravel.controller_namespace'))
                ->prefix($destination)
                ->group(base_path(config('weglot-translate.laravel.routes_web')));
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
