@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Edit Email Template #:id', ['id' => $email_template->id]) }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('email-templates.update', $email_template->id) }}" method="POST" novalidate>
        @csrf
        @method('PATCH')

        @include('settings.email-templates.parts.accordion-tokens')
        @include('settings.email-templates.parts.form', ['model' => $email_template])

        <div class="form-row">
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
  @vite('resources/js/pages/email-templates/edit.ts')
@endpush
