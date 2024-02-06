@extends('layouts.auth')

@section('content')

@section('heading')
  <h4>{{ __('Sign up') }}</h4>
@endsection

<form action="{{ route('register') }}" novalidate class="js-form-sign-up" method="POST">
  @csrf

  <x-form.input id="name" name="name" label="{{ __('Name') }}"
    placeholder="{{ __('Enter name') }}" :required="true">
    <x-slot name="prepend">
      <span class="fa fa-pencil"></span>
    </x-slot>
  </x-form.input>

  <x-form.input id="email" name="email" label="{{ __('Email') }}" type="email"
    placeholder="{{ __('Enter your email') }}" :required="true">
    <x-slot name="prepend">
      <span class="fa fa-envelope"></span>
    </x-slot>
  </x-form.input>

  <x-form.input id="password" name="password" label="{{ __('Password') }}" type="password"
    placeholder="{{ __('Enter your password') }}" :required="true">
    <x-slot name="prepend">
      <span class="fa fa-key"></span>
    </x-slot>
  </x-form.input>

  <div class="form-group mb-5">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" name="terms" id="terms"
        class="custom-control-input @error('terms') is-invalid @enderror" @checked(old('terms')) />
      <label class="custom-control-label" for="terms">
        {!! sprintf('%s <a href="%s">%s</a>', __('I accept'), '#', __('Terms and Conditions')) !!}
      </label>
      @error('terms')
        <div class="invalid-feedback" id="terms-feedback">
          {{ $errors->first('terms') }}
        </div>
      @enderror
    </div>
  </div>

  <div class="form-group text-center">
    <button class="btn btn-primary mb-2" type="submit">
      {{ __('Create Account') }}
    </button>
    <br>
    <a href="{{ route('login') }}" class="text-body text-underline">
      {{ __('Have an account? Login') }}
    </a>
  </div>

</form>
@endsection

@push('scripts')
  @vite('resources/js/pages/auth/sign-up.ts')
@endpush
