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
      href="{{ route("proposals.edit", ["proposal" => $proposal, "tab" => $id]) }}"
      class="nav-link @if($id === $tab || (empty($tab) && $loop->index === 0)){{ 'active' }}@endif"
      role="tab"
      aria-controls="v-pills-proposal-{{ $id }}">
      {{ $text }}
    </a>
  @endforeach

  <hr>

  @php
    $tabs_settings = [
      'notes' => __('Notes'),
      'discussion' => __('Discussion'),
      'overview' => __('Overview'),
    ];
  @endphp
  @foreach ($tabs_settings as $tab_id => $text)
    <a
      href="{{route("proposals.edit", ["proposal" => $proposal, "tab" => $tab_id]) }}"
      class="nav-link @if($tab_id === $tab){{ 'active' }}@endif"
      role="tab"
      aria-controls="v-pills-proposal-{{ $tab_id }}">
      {{ $text }}
    </a>
  @endforeach
</nav>
