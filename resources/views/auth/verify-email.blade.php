@extends("layouts.auth")

@section("content")

  @section("heading")
    <h4>{{ __('Verify e-mail') }}</h4>

    <p class="mb-5">
      {{ __('Please enter your username or email address. You will receive an email message with instructions on how to reset your password.') }}
    </p>
  @endsection

  <form action="{{ route('password.email') }}" method="POST" class="js-form-login" novalidate>
    @csrf

    <x-form.input id="email" name="email" label="{{ __('Email') }}" type="email"
      placeholder="{{ __('Enter your email') }}" :required="true">
      <x-slot name="prepend">
        <span class="fa fa-envelope"></span>
      </x-slot>
    </x-form.input>

    <div class="form-group text-center">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary" type="submit">
          {{ __('Resend Verification Email') }}
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
            {{ __('Log Out') }}
        </button>
      </form>
    </div>
  </form>
@endsection