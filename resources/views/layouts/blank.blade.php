<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>
  @vite('resources/sass/app.scss')
</head>
<body class="proposal-page">
  <div class="page-content">
    @yield('content')
  </div>

  @vite('resources/js/app.ts')
  @stack('scripts')
</body>
</html>
