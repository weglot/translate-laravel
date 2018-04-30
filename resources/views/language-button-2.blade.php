@foreach ($urls as $lang => $url)
    <a href="{{ $url }}" data-wg-notranslate class="weglot-link weglot-{{ $lang }}">
        {{ weglot_language($lang) }}
    </a>
@endforeach