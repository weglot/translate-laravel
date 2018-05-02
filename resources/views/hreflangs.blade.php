@foreach ($urls as $lang => $url)
<link rel="alternate" href="{{ url($url) }}" hreflang="{{ $lang }}"/>
@endforeach