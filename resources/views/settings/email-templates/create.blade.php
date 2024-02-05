@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('New Email template') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('email-templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        @include('settings.email-templates.parts.accordion-tokens')
        @include('settings.email-templates.parts.form', ['model' => null])

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              {{ __('Update') }}
            </button>

            <a href="{{ route('email-templates.index') }}" class="btn btn-secondary">
              {{ __('Back') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/email-templates/create.ts')
@endpush
