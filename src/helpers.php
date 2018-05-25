<?php

use Weglot\Client\Client;
use Weglot\Client\Endpoint\Languages;
use Weglot\Client\Api\LanguageEntry;
use Weglot\Util\Url;
use Illuminate\Support\Facades\Request;

if (! function_exists('weglotLanguage')) {
    /**
     * Used to get language name from ISO 639-1 code
     * @param string $iso639
     * @param bool $getEnglish
     * @return string
     */
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
    /**
     * Render hreflang links for SEO
     * @return string
     */
    function weglotHrefLangRender()
    {
        $url = weglotCurrentUrlInstance();
        return $url->generateHrefLangsTags();
    }
}

if (! function_exists('weglotButtonRender')) {
    /**
     * Render simple templates to switch between languages
     * @param int $index
     * @return \Illuminate\View\View
     */
    function weglotButtonRender($index)
    {
        $url = weglotCurrentUrlInstance();
        return \view(
            'weglot-translate::language-button-' . $index,
            ['urls' => $url->currentRequestAllUrls()]
        );
    }
}

if (! function_exists('weglotCurrentUrlInstance')) {
    /**
     * Returns Url instance for current URL
     * @return Url
     */
    function weglotCurrentUrlInstance()
    {
        $url = Request::fullUrl();
        return new Url(
            $url,
            config('weglot-translate.original_language'),
            config('weglot-translate.destination_languages'),
            config('weglot-translate.prefix_path')
        );
    }
}
