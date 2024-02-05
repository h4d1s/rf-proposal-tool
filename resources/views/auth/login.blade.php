@extends('layouts.auth')

@section('content')
@section('heading')
  <h4>{{ __('Welcome back!') }}</h4>

  <p class="mb-5">
    {{ __('Login to access your account') }}
  </p>
@endsection

<form action="{{ route('login') }}" class="js-form-login" method="POST" novalidate>
  @csrf
  @method('POST')

  <x-form.input id="email" name="email" label="{{ __('Email Address') }}" type="email"
    placeholder="{{ __('Enter your email') }}" :required="true">
    <x-slot name="prepend">
      <span class="far fa-envelope"></span>
    </x-slot>
  </x-form.input>

  <x-form.input id="password" name="password" label="{{ __('Password') }}" type="password"
    placeholder="{{ __('Enter your email') }}" :required="true">
    <x-slot name="prepend">
      <span class="fa-solid fa-lock"></span>
    </x-slot>
  </x-form.input>
  
  <x-form.checkbox id="remember" name="remember" label="{{ __('Remember me') }}">
  </x-form.checkbox>

  <div class="form-group text-center">
    <button class="btn btn-primary" type="submit">
      {{ __('Login') }}
    </button>
    <br><br>
    <a href="{{ route('password.request') }}">
      {{ __('Forgot password?') }}
    </a>
    <br><br>
    {!! sprintf(
        '%s <a class="text-body text-underline" href="%s">%s</a>',
        __("Don't have an account?"),
        route('register'),
        __('Sign up!'),
    ) !!}
  </div>
</form>
@endsection

@push('scripts')
  @vite('resources/js/pages/auth/login.ts')
@endpush
