<nav class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  @php
    $tabs = [
      'cover-letter' => __('Cover letter'),
      'products' => __('Products'),
      'services' => __('Services'),
      'conclusion' => __('Conclusion')
    ];
  @endphp
  @foreach ($tabs as $id => $text)
    <a
      href="{{ route("proposals.create", ["tab" => $id]) }}"
      class="nav-link @if($id === $tab || (empty($tab) && $loop->index === 0)){{ 'active' }}@endif"
      role="tab"
      aria-controls="v-pills-proposal-{{ $id }}">
      {{ $text }}
    </a>
  @endforeach
</nav>
