<?php

use Weglot\Client\Client;
use Weglot\Client\Endpoint\Languages;
use Weglot\Client\Api\LanguageEntry;
use Illuminate\Support\Facades\Request;

if (! function_exists('weglotCurrentLocale')) {
    /**
     * Check current locale, based on URI segments
     * @return string
     */
    function weglotCurrentLocale()
    {
        $segment = Request::segment(1);
        if (in_array($segment, config('weglot-translate.destination_languages'))) {
            return $segment;
        }
        return config('weglot-translate.original_language');
    }
}

if (!function_exists('weglotCurrentRequestLocalizedUrls')) {
    /**
     * Returns array with all possible URL for current Request
     * @return array
     */
    function weglotCurrentRequestLocalizedUrls()
    {
        // init
        $route = Request::route();
        $locale = weglotCurrentLocale();
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

if (! function_exists('weglotLanguage')) {
    function weglotLanguage($iso639, $getEnglish = true)
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

if (! function_exists('weglotHrefLangRender')) {
    function weglotHrefLangRender()
    {
        return \view(
            'weglot-translate::hreflangs',
            ['urls' => weglotCurrentRequestLocalizedUrls()]
        );
    }
}

if (! function_exists('weglotButtonRender')) {
    function weglotButtonRender($index)
    {
        return \view(
            'weglot-translate::language-button-' . $index,
            ['urls' => weglotCurrentRequestLocalizedUrls()]
        );
    }
}
