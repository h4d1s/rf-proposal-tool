@extends('settings.layout')

@section('tab-content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('User #:id', ['id' => $user->id]) }}
      </h5>
    </div>
    <div class="card-form__body card-body bg-white">
      <form action="{{ route('users.destroy', $user->id) }}" class="js-form-user">
        @csrf
        @method('DELETE')

        <div class="row">
          <div class="col-md-3">
            @if($user->avatar)
              <img src="{{ asset("storage/images/" . $user->avatar->path) }}" class="img-fluid" />
            @else
              <p class="text-center"><em>No avatar found</em></p>
            @endif
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-label">{{ __('Name') }}</label>
                <p>{{ $user->name }}</p>
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-label">{{ __('Email') }}</label>
                <p>{{ $user->email }}</p>
              </div>
              <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-label">{{ __('Role') }}</label>
                @if($user->roles->count() > 0)
                  <p>{{ $user->roles->first()->name }}</p>
                @else
                  <p><em>No roles found</em></p>
                @endif
              </div>
            </div>

            <div class="form-row">
              <div class="col-12">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                  {{ __('Edit') }}
                </a>
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
  @vite('resources/js/pages/users/show.ts')
@endpush
