@extends("layouts.blank")

@section("content")
  <div class="text-center py-4">
    <i class="fa-solid fa-circle-xmark text-danger h2 mb-3"></i>
    <p class="h4">{{ __("Payment failure. Please try again.") }}</p>
  </div>
@endsection