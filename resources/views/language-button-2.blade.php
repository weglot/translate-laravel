@foreach ($urls as $lang => $url)
    <a href="{{ route(Route::current()->getName(), ['_wg_lang' => $lang]) }}" data-wg-notranslate class="weglot-link weglot-{{ $lang }}">{{ weglotLanguage($lang, false) }}</a>
@endforeach