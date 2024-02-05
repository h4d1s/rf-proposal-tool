@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Edit Service template item #:id', ['id' => $service_template_item->id]) }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('service-templates.service-template-items.update', ["service_template" => request()->route('service_template'), "service_template_item" => $service_template_item->id]) }}" method="POST" novalidate>
        @csrf
        @method('PATCH')

        @include('settings.service-templates.items.parts.form', ['model' => $service_template_item])

        <div class="form-row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Update') }}
            </button>

            <a href="{{ route('service-templates.show', ["service_template" => request()->route('service_template')]) }}" class="btn btn-secondary">
              {{ __('Back') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection