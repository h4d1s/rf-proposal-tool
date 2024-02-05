@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Edit User') }}</h5>
    </div>
    <div class="card-form__body card-body bg-white">
      @include('shared.statuses')
      @include('shared.errors')

      <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')

        <div class="row">
          <div class="col-md-3">
            @include('settings.users.parts.avatar', ['model' => $user])
          </div>
          <div class="col-md-9">
            @include('settings.users.parts.form', ['model' => $user])

            <div class="form-row">
              <div class="col-12">
                <button class="btn btn-primary" type="submit">
                  {{ __('Update') }}
                </button>

                @if (!request()->routeIs('profile'))
                  <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    {{ __('Back') }}
                  </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/users/edit.ts')
@endpush
