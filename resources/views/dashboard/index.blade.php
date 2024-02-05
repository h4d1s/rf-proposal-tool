@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        @include('dashboard.quick-stats')
        @include('dashboard.pie-chart')
      </div>
      <div class="col-lg-8">
        @include('dashboard.bar-chart')
        @include('dashboard.filter-under-bar-chart')
        <div class="row">
          <div class="col-lg">@include('dashboard.client-activity')</div>
          <div class="col-lg">@include('dashboard.proposals')</div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const PROPOSALS_CHART = {!! json_encode($proposals_chart) !!};
    const QUICK_STATS = {!! json_encode($quick_stats) !!};
    const BAR_CHART = {!! json_encode($bar_chart) !!};
  </script>
  @vite('resources/js/pages/dashboard/dashboard.ts')
@endpush
