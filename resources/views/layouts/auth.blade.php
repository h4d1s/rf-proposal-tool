<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @vite('resources/sass/app.scss')
  <title>{{ config('app.name') }}</title>
</head>

<body class="layout-fluid layout-sticky-subnav layout-login">
  <div class="layout-login">
    <div class="layout-login__overlay"></div>

    <div class="layout-login__form bg-white">
      <div class="d-flex justify-content-center mt-2 mb-5 navbar-light">
        <a href="{{ url('/') }}" class="navbar-brand" style="min-width: 0;">
          <x-application-logo></x-application-logo>
          <span>{{ config('app.name') }}</span>
        </a>
      </div>

      @yield('heading')

      @include('shared.statuses')
      @include('shared.errors')

      @error('common')
        <div class="alert alert-danger">
          <ul class="list-unstyled mb-0">
            @foreach ($errors->get('common') as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @enderror

      @yield('content')
    </div>
  </div>

  @vite('resources/js/app.ts')
  @yield('scripts')
</body>

</html>
