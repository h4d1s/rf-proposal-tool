<div class="form-row">
  <div class="col-12 justify-content-center mb-3">
    <x-form.input :model="$model" label="{{ __('Name') }}" name="name" placeholder="{{ __('Name') }}"
      required="true">
    </x-form.input>
  </div>
  <div class="col-12 mb-3">
    @if ($model && $model->images && $model->images->count() > 0)
      <div class="swiper">
        <div class="swiper-wrapper">
          @foreach ($model->images as $image)
            <div class="swiper-slide">
              <img src="{{ asset("storage/images/" . $image->path) }}" class="img-fluid" alt="" />
            </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <a href="#" class="swiper-button-prev"></a>
        <a href="#" class="swiper-button-next"></a>
      </div>
    @endif
  </div>

  <div class="col-12 mb-3">
    <div class="form-group">
      <x-form.textarea :model="$model" id="description" name="description" label="{{ __('Description') }}"
      :required="true">
      </x-form.textarea>
    </div>
  </div>

  <div class="col-12 mb-3">
    <x-form.input :model="$model" label="{{ __('Price') }}" name="price" placeholder="{{ __('Name') }}"
      :required="true">
    </x-form.input>
  </div>
</div>
