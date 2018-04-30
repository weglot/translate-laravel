<?php

namespace Weglot\Translate;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Weglot\Translate\Compilers\BladeCompiler;

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

        $this->router();
    }

    /**
     * Creating routes for destination languages
     */
    protected function router()
    {
        $destinationLanguages = config('weglot-translate.destination_languages');
        foreach($destinationLanguages as $destination) {
            Route::middleware('web')
                ->namespace(config('weglot-translate.laravel.controller_namespace'))
                ->prefix($destination)
                ->group(base_path('routes/web.php'));
        }
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

        $resolver->register('blade', function() use ($app)
        {
            $compiler = new BladeCompiler($app['files'], $app['config']['view.compiled']);

            return new CompilerEngine($compiler);
        });
    }
}