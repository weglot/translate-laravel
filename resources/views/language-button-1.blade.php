<div id="weglot-language-picker">
    <ul class="weglot-navigation" data-wg-notranslate>
        @foreach ($urls as $lang => $url)
            <li class="weglot-{{ $lang }}">
                <a href="{{ $url }}" class="weglot-{{ $lang }}">
                    {{ weglot_language($lang) }}
                </a>
            </li>
        @endforeach
    </ul>
</div>