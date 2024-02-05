<x-form.input :model="$model" class="mb-3" class_label="mb-0" label="{{ __('Name') }}"
name="name" :required="true" class_label="form-label text-label mb-0"
  grid_label="col-sm-3 align-self-center" grid_input="col">
</x-form.input>

<div class="form-row mb-3">
  <div class="col-sm-3 align-self-center">
    <label class="form-label text-label mb-0">
      {{ __('Project') }} *
    </label>
  </div>
  <div class="col align-self-center">
    <div id="proposal-select-project">
      <v-select label="name" :filterable="false" :options="options"
        v-model="selected" @search="onSearch">
        <template #no-options="{ search, searching }">
          <template v-if="searching">
            No results found for <em>@{{ search }}</em>.
          </template>
          <template v-else>{{ __('type to search projects...') }}</template>
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
      <input type="hidden" name="project" v-if="selected" :value="selected.id" />
    </div>
  </div>
</div>

<x-form.input :model="$model" class="mb-3 align-self-center" class_label="mb-0"
  grid_label="col-sm-3 align-self-center" grid_input="col-sm-3" label="{{ __('Expiration date') }}"
  name="expiration_date">
</x-form.input>
