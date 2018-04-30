<?php

namespace Weglot\Translate\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Weglot\Translate\Compilers\BladeCompiler;

/**
 * Class RouterServiceProvider
 * @package Weglot\Translate
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
}
