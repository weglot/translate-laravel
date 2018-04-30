@foreach ($urls as $lang => $url)
<link rel="alternate" href="{{ $url }}" hreflang="{{ $lang }}"/>
@endforeach