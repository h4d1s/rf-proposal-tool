@extends('settings.layout')

@section('tab-content')
  @php 
  $service_template = !isset($service_template) ? 
    App\Models\ServiceTemplate::find(request()->route('service_template'))->first() :
    $service_template;
  @endphp

  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Service Template #:id', ['id' => $service_template->id]) }}
      </h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('service-templates.update', $service_template->id) }}" method="POST" class="js-form-service-templates">
        @csrf
        @method('PATCH')

        @include('settings.service-templates.parts.form', ['model' => $service_template])

        <div class="form-row">
          <div class="col-12">
            <button class="btn btn-primary" type="submit">
              {{ __('Update') }}
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
