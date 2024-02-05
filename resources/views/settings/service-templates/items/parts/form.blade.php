<div class="form-row">
    <x-form.input
        :model="$model"
        class="col-md-12 col-12 mb-3"
        label="{{ __('Name') }}"
        name="name"
        :required="true">
    </x-form.input>
    <x-form.textarea
    :model="$model"
    class="col-md-12 col-12 mb-3"
    id="body"
    name="description"
    label="{{ __('Description') }}">
    </x-form.textarea>
    <x-form.input
        :model="$model"
        class="col-md-4 col-12 mb-3"
        label="{{ __('Qty') }}"
        name="qty"
        :required="true">
    </x-form.input>
    <x-form.input
        :model="$model"
        class="col-md-4 col-12 mb-3"
        label="{{ __('Unit') }}"
        name="unit">
    </x-form.input>
    <x-form.input
        :model="$model"
        class="col-md-4 col-12 mb-3"
        label="{{ __('Price') }}"
        name="price"
        :required="true">
    </x-form.input>
</div>
  