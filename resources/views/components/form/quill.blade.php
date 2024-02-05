@props([
  "model" => null,
  "id" => "",
  "name" => "",
  "label" => "",
  "class" => "",
])

<div class="form-group {{ $class }}">
  <label for="name">{{ __('Body') }}</label>
  <div class="form-group quill">
    <div id="quill-email-template-body">
      @if(isset($model) || old($name)) {{ $model[$name] }} @endif
    </div>
  </div>
  @error('body')
    <div class="invalid-feedback" id="body_feedback">
      {{ $errors->first("body") }}
    </div>
  @enderror
</div>
