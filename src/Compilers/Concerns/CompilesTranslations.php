<?php

namespace Weglot\Translate\Compilers\Concerns;

trait CompilesTranslations
{
    /**
     * Compile the lang statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileLang($expression)
    {
        if (is_null($expression)) {
            return '<?php $__env->startTranslation(); ?>';
        } elseif ($expression[1] === '[') {
            return "<?php \$__env->startTranslation{$expression}; ?>";
        }

        $expression = preg_replace('#[\'\"]?[\(\)][\'\"]?#i', '', $expression);
        return app('translator')->getFromJson($expression);
    }

    /**
     * Compile the end-lang statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndlang()
    {
        return '<?php echo $__env->renderTranslation(); ?>';
    }

    /**
     * Compile the choice statements into valid PHP.
     *
     * @TODO Remove this ugly eval
     * @param  string  $expression
     * @return string
     */
    protected function compileChoice($expression)
    {
        ob_start();
        eval('echo app("translator")->choice' .$expression. ';');
        $translated = ob_get_clean();

        return $translated;
    }
}
