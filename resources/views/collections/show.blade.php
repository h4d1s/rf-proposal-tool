@extends('layouts.app')

@section('content')
  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Collection #:id', ['id' => $collection->id]) }}
      </h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('collections.destroy', $collection->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-row">
          <div class="col-12">
            <label class="form-label text-label">{{ __('Name') }}</label>
            <p>{{ $collection->name }}</p>
          </div>

          <div class="col-12 my-4">
            <div class="rf-items-sm">
              <div class="rf-products-gallery" id="gallery-products">
                <gallery-products
                currency="{{ $currency }}"
                :selectable="false"
                :current-page="currentPage"
                :total-pages="totalPages"
                :products="products"
                :errored="errored"
                :is-loading="isLoading"
                @paginate="onPaginate" />
              </div>
            </div>
          </div>

          <div class="col-12 col-md-12 mb-3">
            <label for="description">
              {{ __('Description') }}
            </label><br>
            @if($collection->description)
              {{ $collection->description }}
            @else
              <p><em>No description.</em></p>
            @endif
          </div>
        </div>

        <div class="form-row">
          <div class="col-12 col-md-12">
            <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-primary">
              {{ __('Edit') }}
            </a>
            <button type="submit" class="btn btn-secondary">
              {{ __('Delete') }}
            </button>
          </div>
        </div>
        @foreach ($collection->products->pluck('id') as $id)
        <input 
          type="hidden"
          name="products[]"
          value="{{ $id }}" />
        @endforeach
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const INCLUDE_IDS = {{ Js::from($collection->products->pluck('id')) }};
  </script>
  @vite('resources/js/pages/collections/show.ts')
@endpush
