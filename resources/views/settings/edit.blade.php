@extends('settings.layout')

@section('tab-content')
  @include('shared.statuses')
  @include('shared.errors')

  <form action="{{ route('settings.update') }}" method="POST">
    @csrf
    @method('PATCH')

    @include('settings.parts.form', ['settings' => $settings])

    <div class="form-row">
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">
          {{ __('Save') }}
        </button>
      </div>
    </div>
  </form>
@endsection