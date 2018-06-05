<div id="weglot-language-picker">
    <ul class="weglot-navigation" data-wg-notranslate>
        @foreach ($urls as $lang => $url)
            <li class="weglot-{{ $lang }}"><a href="{{ route(Route::current()->getName(), ['_wg_lang' => $lang]) }}" class="weglot-{{ $lang }}">{{ weglotLanguage($lang, false) }}</a></li>
        @endforeach
    </ul>
</div>