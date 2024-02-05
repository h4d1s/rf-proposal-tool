@extends("layouts.app")

@section("content")
  <div class="row">
    <div class="col-md-3">
      @include("settings.parts.sidebar")
    </div>
    <div class="col-md-9">
      @yield('tab-content')
    </div>
  </div>
@endsection
