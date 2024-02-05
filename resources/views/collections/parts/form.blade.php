  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="form-row">
    <x-form.input class="col-12" :model="$model" label="{{ __('Name') }}" name="name"
      :required="true">
    </x-form.input>

    <div class="col-12 my-4">
      <div class="rf-items-sm">
        <div class="rf-products-gallery" id="gallery-products">
          <gallery-products
          currency={{ $currency }}
          selectable="{{ $selectable === 1 ? true : false }}"
          :current-page="currentPage"
          :total-pages="totalPages"
          :products="products"
          :errored="errored"
          :is-loading="isLoading"
          :selected="selectedIds"
          @paginate="onPaginate">
          </gallery-products>
        </div>
      </div>
    </div>

    <x-form.textarea :model="$model" class="col-12" id="description" name="description" label="{{ __('Description') }}">
    </x-form.textarea>
  </div>
