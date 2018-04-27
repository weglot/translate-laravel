<?php

namespace Weglot\Translate;

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
        // publish custom configuration
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
        // using custom configuration
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'weglot-translate'
        );

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
