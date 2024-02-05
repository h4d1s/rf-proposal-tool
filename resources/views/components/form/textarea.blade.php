@props([
  "model" => null,
  "id" => "",
  "name" => "",
  "label" => "",
  "placeholder" => "",
  "required" => false,
  "help" => "",
  "class" => ""
])

<div class="form-group {{ $class }}">
  <label for="{{ $name }}" class="form-label text-label">
    {{ $label }} @if($required) * @endif
  </label>
  <textarea
    class="form-control @error($name) is-invalid @enderror"
    name="{{ $name }}"
    id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    rows="4"
    @if($required) required="" @endif
  >{{ old($name, isset($model) ? $model[$name] : '') }}</textarea>
  @if($help)
    <small id="noteHelp" class="form-text text-muted">
      {{ $help }}
    </small>
  @endif
  @error($name)
    <div class="invalid-feedback" id="{{ $id }}_feedback">
      {{ $errors->first($name) }}
    </div>
  @enderror
</div>
