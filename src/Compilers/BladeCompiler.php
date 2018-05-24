<?php

namespace Weglot\Translate\Compilers;

use Illuminate\View\Compilers\BladeCompiler as LaravelBladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;
use Weglot\Client\Client;
use Weglot\Parser\ConfigProvider\ServerConfigProvider;
use Weglot\Parser\Parser;
use Weglot\Translate\Compilers\Concerns\CompilesTranslations;
use Weglot\Translate\Facades\Cache;
use Weglot\Translate\TranslateServiceProvider;

/**
 * Class BladeCompiler
 * @package Weglot\Translate\Compilers
 */
class BladeCompiler extends LaravelBladeCompiler implements CompilerInterface
{
    use CompilesTranslations;

    /**
     * Compile the given Blade template contents.
     *
     * @param string $value
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Weglot\Client\Api\Exception\ApiError
     * @throws \Weglot\Client\Api\Exception\InputAndOutputCountMatchException
     * @throws \Weglot\Client\Api\Exception\InvalidWordTypeException
     * @throws \Weglot\Client\Api\Exception\MissingRequiredParamException
     * @throws \Weglot\Client\Api\Exception\MissingWordsOutputException
     */
    public function compileString($value)
    {
        $contents = parent::compileString($value);
        $contents = $this->cleanPhpLangTags($contents);

        $config = config('weglot-translate');

        $client = new Client($config['api_key']);
        $configProvider = new ServerConfigProvider();

        // custom user-agent
        $client->getHttpClient()->addUserAgentInfo('laravel', TranslateServiceProvider::VERSION);

        if ($config['cache']) {
            $client->setCacheItemPool(Cache::getItemCachePool());
        }

        $locale = $this->currentLocale();
        if ($locale !== $config['original_language']) {
            $parser = new Parser($client, $configProvider, $config['exclude_blocks']);
            $contents = $parser->translate($contents, $config['original_language'], $locale);
        }

        return $contents;
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  string  $path
     * @return string
     */
    public function getCompiledPath($path)
    {
        $localizedPath = sprintf('%s|%s', $this->currentLocale(), $path);
        return $this->cachePath . '/' . sha1($localizedPath) . '.php';
    }

    /**
     * @return string
     */
    private function currentLocale()
    {
        return weglotCurrentUrlInstance()->detectCurrentLanguage();
    }
}
