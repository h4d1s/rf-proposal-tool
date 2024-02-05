<div class="form-row">
  <x-form.input :model="$model" label="{{ __('Name') }}" name="name"
    :required="true" class="col-12 col-md-4 mb-3">
  </x-form.input>

  <x-form.input :model="$model" label="{{ __('Phone') }}" name="phone"
    class="col-12 col-md-4 mb-3">
  </x-form.input>

  <x-form.input :model="$model" label="{{ __('Email') }}" name="email"
    :required="true" class="col-12 col-md-4 mb-3">
  </x-form.input>

  <x-form.input :model="$model" label="{{ __('Website') }}" name="website"
    class="col-12 col-md-4 mb-3">
  </x-form.input>

  <x-form.input :model="$model->address ?? ''" class="col-12 mb-3" type="text" label="{{ __('Address line') }}" name="address"
    :required="true">
  </x-form.input>

  <x-form.input :model="$model->address ?? ''" class="col-12 col-md-4 mb-3" type="text" label="{{ __('Postcode') }}"
    name="postal_code" :required="true">
  </x-form.input>

  <x-form.input :model="$model->address ?? ''" class="col-12 col-md-4 mb-3" type="text" label="{{ __('City') }}"
    name="city" :required="true">
  </x-form.input>

  <div class="col-12 col-md-4 mb-3">
    <x-form.select id="country" name="country" label="{{ __('Country') }}" :required="true">
      <x-slot:options>
        <option value="">---</option>
        @foreach ($countries as $country)
          @php
          $country_code = null;
          if($model && $model->address) {
            $country_code = $model->address->country->code;
          }
          @endphp
          
          <option value="{{ $country->id }}" @selected(old('country', $country_code) === $country->code)>
            {{ $country->name }}
          </option>
        @endforeach
      </x-slot>
    </x-form.select>
  </div>
</div>
