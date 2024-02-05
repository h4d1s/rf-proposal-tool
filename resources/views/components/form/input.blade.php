@props([
    'model' => null,
    'id' => '',
    'name' => '',
    'value' => '',
    'label' => '',
    'placeholder' => '',
    'type' => 'text',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'class_label' => '',
    'class_input' => '',
    'grid_label' => '',
    'grid_input' => '',
    'prepend' => '',
    'append' => '',
])

@php
  if ($grid_label && $grid_input) {
      $class .= ' form-row';
  } else {
      $class .= ' form-group';
  }
@endphp

<div class="{{ $class }}">
  @if ($grid_label)
    <div class="{{ $grid_label }}">
  @endif

  <label for="{{ $name }}" class="form-label text-label {{ $class_label }} ">
    {{ $label }} @if ($required)
      *
    @endif
  </label>

  @if ($grid_label)
    </div>
  @endif

  @if ($grid_input)
    <div class="{{ $grid_input }}">
  @endif

  @if ($prepend || $append)
    <div class="input-group input-group-merge">
  @endif

  <input type="{{ $type }}"
    class="form-control @if ($prepend) form-control-prepended @endif @if ($append) form-control-appended @endif {{ $class_input }} @error($name) is-invalid @enderror"
    name="{{ $name }}" id="{{ $id ?: $name }}" placeholder="{{ $placeholder }}"
    value="{{ old($name) ?? (isset($model) && !empty($model) ? ($model->{$name} ?? '') : $value) }}"
    @required($required)
    @if($disabled) disabled @endif />

  @if ($append)
    <div class="input-group-append">
      <div class="input-group-text">
        {{ $append }}
      </div>
    </div>
  @endif

  @if ($prepend)
    <div class="input-group-prepend">
      <div class="input-group-text">
        {{ $prepend }}
      </div>
    </div>
  @endif

  {{-- @error($name) --}}
  <div class="invalid-feedback" id="{{ $id ?: $name }}_feedback">
    <ul class="list-unstyled mb-0">
      @foreach ($errors as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  {{-- @enderror --}}

  @if ($prepend || $append)
    </div>
  @endif

@if ($grid_input)
  </div>
@endif
</div>
