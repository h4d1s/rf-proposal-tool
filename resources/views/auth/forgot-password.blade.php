@extends('layouts.auth')

@section('content')
  @section('heading')
    <h4>{{ __('Reset password') }}</h4>

    <p class="mb-5">
      {{ __('Please enter your username or email address. You will receive an email message with instructions on how to reset your password.') }}
    </p>
  @endsection

  <form action="{{ route('password.email') }}" method="POST" class="js-form-login" novalidate>
    @csrf

    <x-form.input id="email" name="email" label="{{ __('Email Address') }}" type="email"
      placeholder="{{ __('Enter your email') }}" :required="true">
      <x-slot name="prepend">
        <span class="far fa-envelope"></span>
      </x-slot>
    </x-form.input>

    <div class="form-group text-center">
      <button class="btn btn-primary" type="submit">
        {{ __('Get new password') }}
      </button>
      <br><br>
      <a href="{{ route('login') }}">
        {{ __('Login?') }}
      </a>
    </div>
  </form>
@endsection

@push('scripts')
  @vite('resources/js/pages/auth/forgot-password.ts')
@endpush
