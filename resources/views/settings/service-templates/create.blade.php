@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('New Service template') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('service-templates.store') }}" method="POST" class="js-form-service-templates">
        @csrf
        @method('POST')

        @include('settings.service-templates.parts.form', ['model' => null])

        <div class="form-row">
          <div class="col-12">
            <button class="btn btn-primary" type="submit">
              {{ __('Save') }}
            </button>
            <a href="{{ route('service-templates.index') }}" class="btn btn-secondary">
              {{ __('Back') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
