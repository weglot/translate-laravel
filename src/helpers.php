<?php

use Weglot\Client\Client;
use Weglot\Client\Endpoint\Languages;
use Weglot\Client\Api\LanguageEntry;
use Illuminate\Support\Facades\Request;

if (! function_exists('currentLocale')) {
    /**
     * Check current locale, based on URI segments
     * @return string
     */
    function currentLocale()
    {
        $segment = Request::segment(1);
        if (in_array($segment, config('weglot-translate.destination_languages'))) {
            return $segment;
        }
        return config('weglot-translate.original_language');
    }
}

if (!function_exists('currentRequestLocalizedUrls')) {
    /**
     * Returns array with all possible URL for current Request
     * @return array
     */
    function currentRequestLocalizedUrls()
    {
        // init
        $route = Request::route();
        $locale = currentLocale();
        $config = config('weglot-translate');

        // get current uri
        $baseUrl = $route->uri();
        if ($baseUrl[0] !== '/') {
            $baseUrl = '/' .$baseUrl;
        }

        // build base uri
        if ($locale !== $config['original_language']) {
            $languages = implode('|', $config['destination_languages']);
            $baseUrl = preg_replace('#\/?(' .$languages. ')#i', '', $baseUrl);

            // if we go back at root
            if ($baseUrl === '') {
                $baseUrl = '/';
            }
        }

        // creating urls
        $urls = [];
        $urls[$config['original_language']] = $baseUrl;
        foreach ($config['destination_languages'] as $language) {
            $urls[$language] = '/' . $language . $baseUrl;
        }

        return $urls;
    }
}

if (! function_exists('weglot_language')) {
    function weglot_language($iso639, $getEnglish = true)
    {
        $client = new Client(config('weglot-translate.api_key'));
        $translate = new Languages($client);
        $languageCollection = $translate->handle();

        $language = $languageCollection->getCode($iso639);
        if (!$language instanceof LanguageEntry) {
            return '';
        }

        if ($getEnglish) {
            return $language->getEnglishName();
        }
        return $language->getLocalName();
    }
}

if (! function_exists('weglot_hreflang_render')) {
    function weglot_hreflang_render()
    {
        return \view(
            'weglot-translate::hreflangs',
            ['urls' => currentRequestLocalizedUrls()]
        );
    }
}

if (! function_exists('weglot_translate_render')) {
    function weglot_translate_render($index)
    {
        return \view(
            'weglot-translate::language-button-' . $index,
            ['urls' => currentRequestLocalizedUrls()]
        );
    }
}
