@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Create Client') }}</h5>
    </div>

    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        @method('POST')

        @include('clients.parts.form', ['model' => null])

        <div class="form-row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Save') }}
            </button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
              {{ __('Cancel') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/clients/create.ts')
@endpush
