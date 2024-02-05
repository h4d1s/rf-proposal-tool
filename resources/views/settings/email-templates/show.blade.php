@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Email Template #:id', ['id' => $email_template->id]) }}
      </h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('email-templates.destroy', $email_template->id) }}" class="js-form-email-templates">
        @csrf
        @method('DELETE')

        @include('settings.email-templates.parts.accordion-tokens')

        <div class="form-row">
          <div class="col-md-6 col-12 mb-3">
            <label class="form-label text-label">{{ __('Name') }}</label>
            <p>{{ $email_template->name }}</p>
          </div>
          <div class="col-md-6 col-12 mb-3">
            <label class="form-label text-label">{{ __('Subject') }}</label>
            <p>{{ $email_template->subject }}</p>
          </div>
        </div>

        <div class="form-row">
          <div class="col-12 mb-3">
            <label class="form-label text-label">{{ __('Body') }}</label>
            <p>{{ $email_template->body }}</p>
          </div>
        </div>

        <div class="form-row">
          <div class="col-12">
            <a href="{{ route('email-templates.edit', $email_template->id) }}" class="btn btn-primary">
              {{ __('Edit') }}
            </a>
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
  @vite('resources/js/pages/users/show.ts')
@endpush
