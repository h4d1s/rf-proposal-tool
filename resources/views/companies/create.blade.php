@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Create Company') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('companies.store') }}" method="POST" class="js-project-form">
        @csrf
        @method('POST')

        @include('companies.parts.form', ['model' => null])

        <div class="form-row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Save') }}
            </button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">
              {{ __('Cancel') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/companies/create.ts')
@endpush
