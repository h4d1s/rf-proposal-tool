<div class="form-row">
  <x-form.input :model="$model" class="col-12 col-md-4 mb-3" label="{{ __('Title') }}" name="title">
  </x-form.input>

  <x-form.input :model="$model" class="col-12 col-md-4 mb-3" label="{{ __('First name') }}" name="first_name"
    :required="true">
  </x-form.input>

  <x-form.input :model="$model" class="col-12 col-md-4 mb-3" label="{{ __('Last name') }}" name="last_name"
    :required="true">
  </x-form.input>

  <x-form.input :model="$model" class="col-12 col-md-4 mb-3" type="email" label="{{ __('Email') }}" name="email"
    required="true">
  </x-form.input>

  <x-form.input :model="$model" class="col-12 col-md-4 mb-3" name="phone" type="phone" label="{{ __('Phone') }}"
    placeholder="{{ __('(000) 000-0000') }}">
  </x-form.input>

  <div class="col-12 col-md-4 mb-3">
    <label for="clients" class="form-label text-label d-block">{{ __('Company') }}</label>
    <div id="client-company-select">
      <v-select
      v-model="selected"
      :options="options"
      :filterable="false"
      @close="onClose"
      @search="onSearch">
        <template #no-options="{ search, searching }">
          <template v-if="searching">
            No results found for <em>@{{ search }}</em>.
          </template>
          <template v-else>{{ __('type to search companies...') }}</template>
        </template>
        <template #option="option">
          @{{ option.name }}
        </template>
        <template #selected-option="option">
          <div class="selected">
            @{{ option.name }}
          </div>
        </template>
      </v-select>
      <input type="hidden" name="company" v-if="selected" :value="selected.id" />
    </div>
  </div>

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
        @php
          $country_code = null;
          if($model && $model->address) {
            $country_code = $model->address->country->code;
          }
        @endphp
        @foreach ($countries as $country)
          <option value="{{ $country->id }}" @selected(old('country', $country_code) === $country->code)>
            {{ $country->name }}
          </option>
        @endforeach
      </x-slot>
    </x-form.select>
  </div>
</div>
