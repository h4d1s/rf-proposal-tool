@props([
  "name" => "",
  "text" => ""
])

@php
  $sort_asc_desc = "";
  if(request('orderby') && request('orderby') === $name) {
    $sort_asc_desc = request('order') === 'asc' ? 'asc' : 'desc';
  }
@endphp

<a
  href="{{ request()->fullUrlWithQuery([
    'orderby' => $name,
    'order' => request('order') === 'desc' ? 'asc' : 'desc'
  ]) }}"
  class="sort {{ $sort_asc_desc }}">
  {{ $text }}
</a>
