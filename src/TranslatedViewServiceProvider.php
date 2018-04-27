<?php

namespace Weglot\Translate;

use Weglot\Translate\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\ViewServiceProvider;

/**
 * Class TranslateServiceProvider
 * @package Weglot\Translate
 */
class TranslatedViewServiceProvider extends ViewServiceProvider
{
    /**
     * Register the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $this->app->singleton('blade.compiler', function () {
            return new BladeCompiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }
}
