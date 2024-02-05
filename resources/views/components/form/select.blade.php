@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'label_class' => '',
    'required' => false,
    'options' => '',
    'disabled' => false
])

<div class="form-group">
  <label for="{{ $name }}" class="form-label text-label {{ $label_class }}">
    {{ $label }} @if ($required)
      *
    @endif
  </label>
  <select class="form-control" name="{{ $name }}" aria-describedby="{{ $id ?: $name }}_feedback"
    @if ($required) required="" @endif
    @if ($disabled) disabled @endif>
    {{ $options }}
  </select>

  @error($name)
    <div class="invalid-feedback" id="{{ $id ?: $name }}_feedback">
      {{ $errors->first($name) }}
    </div>
  @enderror
</div>
