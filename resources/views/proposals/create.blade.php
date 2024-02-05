@extends('layouts.app')

@section('content')
  @include('shared.statuses')
  @include('shared.errors')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <form action="{{ route('proposals.store') }}" method="POST" novalidate class="js-form-proposals">
    @csrf
    @method('POST')

    <div class="card">
      <div class="card-header card-header-large">
        <div class="row">
          <div class="col-md-6 align-self-center">
            <h5 class="mb-0">
              {{ __('New proposal') }}
            </h5>
          </div>
        </div>
      </div>
      <div class="card-header py-3">
        @include('proposals.parts.form', ['model' => null])
      </div>
      <div class="card-body">
        <div class="row mb-5">
          <div class="col-md-3 mb-4">
            @include('proposals.parts.tabs-create')
          </div>

          <div class="col-md-9">
            @empty($tab)
              <div role="tabpanel" aria-labelledby="proposal-{{ $tab }}-tab">
                @include('proposals.cover-letter.create')
              </div>
            @else
              <div role="tabpanel" aria-labelledby="proposal-{{ $tab }}-tab">
                @include("proposals.{$tab}.create")
              </div>
            @endempty
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-right">
            <button type="submit" class="btn btn-secondary">
              {{ __('Save') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  @vite('resources/js/pages/proposals/create.ts')
@endpush
