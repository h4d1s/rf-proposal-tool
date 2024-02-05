@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Edit Collection') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('collections.update', $collection->id) }}" method="POST">
        @csrf
        @method('PATCH')

        @include('collections.parts.form', ['model' => $collection, 'selectable' => true])

        <div class="form-row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary js-btn-collection-primary">
              {{ __('Save') }}
            </button>

            <a href="{{ route('collections.index') }}" class="btn btn-secondary js-btn-collection-secondary">
              {{ __('Cancel') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    INCLUDE_IDS = {{ Js::from($collection->products->pluck('id')) }};
  </script>
  @vite('resources/js/pages/collections/edit.ts')
@endpush
