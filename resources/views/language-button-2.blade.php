@foreach ($urls as $lang => $url)
    <a href="{{ url($url) }}" data-wg-notranslate class="weglot-link weglot-{{ $lang }}">{{ weglotLanguage($lang, false) }}</a>
@endforeach