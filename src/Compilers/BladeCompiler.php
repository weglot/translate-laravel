<?php

namespace Weglot\Translate\Compilers;

use Illuminate\View\Compilers\BladeCompiler as LaravelBladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;
use Weglot\Client\Client;
use Weglot\Parser\ConfigProvider\ServerConfigProvider;
use Weglot\Parser\Parser;

/**
 * Class BladeCompiler
 * @package Weglot\Translate\Compilers
 */
class BladeCompiler extends LaravelBladeCompiler implements CompilerInterface
{
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
        $config = config('weglot-translate');

        $client = new Client($config['api_key']);
        $configProvider = new ServerConfigProvider();

        $parser = new Parser($client, $configProvider, $config['exclude_blocks']);
        return $parser->translate($contents, $config['original_language'], 'de');
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  string  $path
     * @return string
     */
    public function getCompiledPath($path)
    {
        $localizedPath = 'de|' . $path;
        return $this->cachePath.'/'.sha1($localizedPath).'.php';
    }
}