<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 21/06/2018
 * Time: 11:06
 */

namespace Weglot\Translate\Compilers;

use Illuminate\View\Engines\CompilerEngine as IlluminateCompilerEngine;
use Weglot\Client\Client;
use Weglot\Parser\ConfigProvider\ServerConfigProvider;
use Weglot\Parser\Parser;
use Weglot\Translate\Facades\Cache;
use Weglot\Translate\TranslateServiceProvider;

/**
 * Class CompilerEngine
 * @package Weglot\Translate\Compilers
 */
class CompilerEngine extends IlluminateCompilerEngine
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $data = [])
    {
        $contents = parent::get($path, $data);

        $config = config('weglot-translate');
        $url = weglotCurrentUrlInstance();

        $client = new Client($config['api_key']);
        $configProvider = new ServerConfigProvider();

        // custom header
        $client->setHttpClient(null, 'Laravel\\' . TranslateServiceProvider::VERSION);

        if ($config['cache']) {
            $client->setCacheItemPool(Cache::getItemCachePool());
        }

        $locale = $url->isTranslable() ? $url->detectCurrentLanguage() : $config['original_language'];
        if ($locale !== $config['original_language']) {
            $parser = new Parser($client, $configProvider, $config['exclude_blocks']);
            $contents = $parser->translate($contents, $config['original_language'], $locale);
        }

        return $contents;
    }
}
