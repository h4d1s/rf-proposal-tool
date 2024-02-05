@props([
  "model" => null,
  "id" => "",
  "name" => "",
  "label" => "",
  "class" => "",
  "class_input" => "",
  "class_label" => "",
])

<div class="form-group {{ $class }}">
  <div class="custom-control custom-checkbox">
    <input
      type="checkbox"
      class="custom-control-input {{ $class_input }}"
      id="checkbox-select-{{ $id }}"
      name="{{ $name }}"
      value="{{ old($name) ?? ((isset($model) && !empty($model)) ? ($model->{$name} ?? "") : "") }}"
      @checked(old($name))
    />
    <label
      class="custom-control-label {{ $class_label }}"
      for="checkbox-select-{{ $name }}">
      {{ $label }}
    </label>
  </div>
</div>
