@extends('layouts.app')

@section('content')
  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Product #:id', ['id' => $product->id]) }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">

      <div class="form-row">
        <div class="col-12 justify-content-center mb-3">
          <label>{{ __('Name') }}</label>
          <p>{{ $product->name }}</p>
        </div>

        <div class="col-12 mb-3">
          @if ($product->images && $product->images->count() > 0)
            <div class="swiper">
              <div class="swiper-wrapper">
                @foreach ($product->images as $image)
                  <div class="swiper-slide">
                    <img src="{{ asset('storage/images/' . $image->path) }}" class="img-fluid" alt="" />
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
          <label>{{ __('Description') }}</label>
          <p>{{ $product->description }}</p>
        </div>

        <div class="col-12 mb-3">
          <label>{{ __('Price') }}</label>
          <p>{{ $currency }}{{ $product->price }}</p>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-12">
          <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
            {{ __('Edit') }}
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/products/show.ts')
@endpush
