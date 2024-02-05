<div class="form-row">
  <x-form.input
    :model="$model"
    class="col-md-6 col-12 mb-3"
    label="{{ __('Name') }}"
    name="name"
    :required="true">
  </x-form.input>
  <x-form.input
    :model="$model"
    class="col-md-6 col-12 mb-3"
    label="{{ __('Subject') }}"
    name="subject"
    :required="true">
  </x-form.input>
  <x-form.textarea :model="$model" class="col-md-12 col-12 mb-3" id="body" name="body" label="{{ __('Body') }}"
  :required="true">
  <x-slot:help>
    {{ __("Content is markdown.") }}
  </x-slot:help>
  </x-form.textarea>
</div>
