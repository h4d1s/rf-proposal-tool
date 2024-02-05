<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite('resources/sass/app.scss')
  <title>{{ config('app.name') }}</title>
</head>

<body class="layout-default d-flex align-items-center h-100 text-center">
  <div class="wrap container" role="document">
    <div class="content">
      <main class="main">
        @yield('content')
      </main>
    </div>
  </div>
</body>

</html>
