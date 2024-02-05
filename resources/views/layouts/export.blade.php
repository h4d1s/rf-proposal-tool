<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>@yield('title')</title>
  <style>
    body {
      font-family: sans-serif;
    }
    table {
      width: 100%;
    }
    table th {
      text-align: left;
    }
    table thead tr {
      border: 1px solid #000;
    }
    .section {
      border-bottom: 1px solid #000;
      padding: 16px 0;
    }
    .section:last-child {
      border-bottom: 0;
    }
    .section-cover {
      padding: 0 0 48px;
      text-align: center;
    }
    .section-cover .heading {
      font-size: 40px;
    }
    .total {
      margin-top: 16px;
      text-align: right;
    }
  </style>
</head>
<body class="export export-format-pdf">
  <div class="page-content">
    @yield('content')
  </div>
</body>
</html>
