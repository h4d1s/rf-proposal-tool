@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Company #:ID', ['id' => $company->id]) }}
      </h5>
    </div>

    <div class="card-form__body card-body bg-white">
      <form action="{{ route('companies.destroy', $company->id) }}" class="js-company-form" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-row">
          <div class="col-12 col-md-4 mb-3">
            <label class="form-label text-label">{{ __('Name') }}</label>
            <p>{{ $company->name }}</p>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label class="form-label text-label">{{ __('Phone') }}</label>
            <p>{{ $company->phone }}</p>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label class="form-label text-label">{{ __('Email') }}</label>
            <p>{{ $company->email }}</p>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label class="form-label text-label">{{ __('Website') }}</label>
            <p>{{ $company->website }}</p>
          </div>

          @if($company->address)
            <div class="form-group col-12 mb-3">
              <label class="form-label text-label d-block">{{ __('Address line') }}</label>
              <p>{{ $company->address->address }}</p>
            </div>

            <div class="form-group col-12 col-md-4 mb-3">
              <label class="form-label text-label d-block">{{ __('Postcode') }}</label>
              <p>{{ $company->address->postal_code }}</p>
            </div>

            <div class="form-group col-12 col-md-4 mb-3">
              <label class="form-label text-label d-block">{{ __('City') }}</label>
              <p>{{ $company->address->city }}</p>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <div class="form-group">
                <label class="form-label text-label">{{ __('Country') }}</label>
                <p>{{ $company->address->country->name }}</p>
              </div>
            </div>
          @endif
        </div>

        <div class="form-row">
          <div class="col-12 col-md-12">
            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">
              {{ __('Edit') }}
            </a>
            <button type="submit" class="btn btn-secondary">
              {{ __('Delete') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
