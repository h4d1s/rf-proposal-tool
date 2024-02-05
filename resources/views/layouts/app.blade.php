<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  @vite('resources/sass/app.scss')
  <title>{{ config('app.name') }}</title>
</head>

<body class="layout-default">
  @include('partials.navigation')

  <div class="wrap container" role="document">
    <div class="content">
      <main class="main">
        @yield('content')
      </main>
    </div>
  </div>

  @vite('resources/js/app.ts')
  @stack('scripts')
</body>

</html>
