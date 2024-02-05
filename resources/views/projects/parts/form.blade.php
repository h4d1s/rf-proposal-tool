<div class="form-row">
  <div class="col-12 col-md-12 mb-3">
    <x-form.input :model="$model" label="{{ __('Name') }}" name="name"
      :required="true">
    </x-form.input>
  </div>
  <div class="col-12 col-md-12 mb-3">
    <div class="form-group">
      <x-form.textarea :model="$model" id="description" name="description" label="{{ __('Description') }}">
      </x-form.textarea>
    </div>
  </div>
  <div class="col-12 col-md-12 mb-3">
    <label for="customer">{{ __('Customer') }}</label>
    <div id="projects-customer-select">
      <v-select
      name="customer"
      v-model="selected"
      :options="options"
      :filterable="false"
      @open="onOpen"
      @close="onClose"
      @search="onSearch">
        <template #no-options="{ search, searching }">
          <template v-if="searching">
            No results found for <em>@{{ search }}</em>.
          </template>
          <template v-else>{{ __('type to search customers...') }}</template>
        </template>
        <template #option="option">
          @{{ option.name }} (@{{ option.type }})
        </template>
        <template #selected-option="option">
          <div class="selected">
            @{{ option.name }} (@{{ option.type }})
          </div>
        </template>
      </v-select>
      <input type="hidden" name="customer" v-if="selected" :value="selected.id" />
      <input type="hidden" name="customer_type" v-if="selected" :value="selected.type" />
    </div>
  </div>
</div>
