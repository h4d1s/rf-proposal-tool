@extends("layouts.auth")

@section("content")

  @section("heading")
    <h4>{{ __('Reset password') }}</h4>
  @endsection

  <form action="{{ route('password.update') }}" method="POST">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}" />

    <x-form.input id="email" name="email" label="{{ __('Email Address') }}" type="email"
      placeholder="{{ __('Enter your email') }}" :required="true" value="{{ $request->query('email') }}">
      <x-slot name="prepend">
        <span class="fa-solid fa-lock"></span>
      </x-slot>
    </x-form.input>

    <x-form.input id="password" name="password" label="{{ __('New Password') }}" type="password"
      placeholder="{{ __('Enter your password') }}" :required="true">
      <x-slot name="prepend">
        <span class="fa-solid fa-lock"></span>
      </x-slot>
    </x-form.input>

    <x-form.input id="password_confirmation" name="password_confirmation" label="{{ __('New Password again') }}" type="password"
      placeholder="{{ __('Enter your password again') }}" :required="true">
      <x-slot name="prepend">
        <span class="fa-solid fa-lock"></span>
      </x-slot>
    </x-form.input>

    <div class="form-group text-center">
      <button class="btn btn-primary mb-2" type="submit">
        {{ __("Reset") }}
      </button>
    </div>
  </form>
@endsection