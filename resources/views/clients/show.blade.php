@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Client #:id', ['id' => $client->id]) }}
      </h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-row">
          <div class="form-group col-12 col-md-4 mb-3">
            <label class="form-label text-label d-block">{{ __('Title') }}</label>
            @if($client->title)
              <p>{{ $client->title }}</p>
            @else
              <p><em>{{ __("No title") }}</em></p>
            @endif
          </div>

          <div class="form-group col-12 col-md-4 mb-3">
            <label class="form-label text-label d-block">{{ __('First name') }}</label>
            <p>{{ $client->first_name }}</p>
          </div>

          <div class="form-group col-12 col-md-4 mb-3">
            <label class="form-label text-label d-block">{{ __('Last name') }}</label>
            <p>{{ $client->last_name }}</p>
          </div>

          <div class="form-group col-12 col-md-4 mb-3">
            <label class="form-label text-label d-block">{{ __('Email') }}</label>
            <p>{{ $client->email }}</p>
          </div>

          <div class="form-group col-12 col-md-4 mb-3">
            <label class="form-label text-label d-block">{{ __('Phone') }}</label>
            @if($client->phone)
              <p>{{ $client->phone }}</p>
            @else
              <p><em>{{ __("No phone") }}</em></p>
            @endif
          </div>

          @if($client->company)
            <div class="form-group col-12 col-md-4 mb-3">
              <label class="form-label text-label d-block">{{ __('Company') }}</label>
              <p>{{ $client->company->name }}</p>
            </div>
          @endif

          @if($client->address)
            <div class="form-group col-12 mb-3">
              <label class="form-label text-label d-block">{{ __('Address line') }}</label>
              <p>{{ $client->address->address }}</p>
            </div>

            <div class="form-group col-12 col-md-4 mb-3">
              <label class="form-label text-label d-block">{{ __('Postcode') }}</label>
              <p>{{ $client->address->postal_code }}</p>
            </div>

            <div class="form-group col-12 col-md-4 mb-3">
              <label class="form-label text-label d-block">{{ __('City') }}</label>
              <p>{{ $client->address->city }}</p>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <div class="form-group">
                <label class="form-label text-label">{{ __('Country') }}</label>
                <p>{{ $client->address->country->name }}</p>
              </div>
            </div>
          @endif
        </div>

        <div class="form-row">
          <div class="col-12">
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">
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
