<?php

namespace Weglot\Translate\Compilers;

use Illuminate\View\Compilers\BladeCompiler as LaravelBladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;

/**
 * Class BladeCompiler
 * @package Weglot\Translate\Compilers
 */
class BladeCompiler extends LaravelBladeCompiler implements CompilerInterface
{
    /**
     * Compile the given Blade template contents.
     *
     * @param  string  $value
     * @return string
     */
    public function compileString($value)
    {
        $contents = parent::compileString($value);

        return $contents;
    }
}