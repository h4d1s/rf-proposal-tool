@props([
  "name" => "",
  "id" => 0,
])

<div class="custom-control custom-checkbox">
  <input
    type="checkbox"
    class="custom-control-input js-checkbox-select-row"
    id="checkbox-select-{{ $id }}"
    name="{{ $name }}[]"
    value="{{ $id }}" />
  <label class="custom-control-label" for="checkbox-select-{{ $id }}">
    <span class="text-hide">{{ __('Check') }}</span>
  </label>
</div>
