@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Edit Product') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PATCH')

        @include('products.parts.form', ['model' => $product])

        <div class="form-row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Save') }}
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
              {{ __('Cancel') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/products/edit.ts')
@endpush
