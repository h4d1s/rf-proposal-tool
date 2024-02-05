@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('New service template item') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('service-templates.service-template-items.store', ["service_template" => request()->route('service_template')]) }}" method="POST" novalidate>
        @csrf
        @method('POST')

        @include('settings.service-templates.items.parts.form', ['model' => null])

        <div class="form-row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Save') }}
            </button>

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
              {{ __('Back') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection