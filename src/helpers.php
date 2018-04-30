<?php

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

if (! function_exists('weglot_hreflang_render')) {
    function weglot_hreflang_render()
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
        $urls[] = $baseUrl;
        foreach ($config['destination_languages'] as $language) {
            $urls[] = '/' . $language . $baseUrl;
        }

        return \view('weglot-translate::hreflangs', ['urls' => $urls]);
    }
}
