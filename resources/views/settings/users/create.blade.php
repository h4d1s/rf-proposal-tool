@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('New User') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('POST')

        <div class="row">
          <div class="col-md-3">
            @include('settings.users.parts.avatar', ['model' => null])
          </div>
          <div class="col-md-9">
            @include('settings.users.parts.form', ['model' => null])

            <div class="form-row">
              <div class="col-12">
                <button class="btn btn-primary">
                  {{ __('Create') }}
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                  {{ __('Back') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/users/create.ts')
@endpush
