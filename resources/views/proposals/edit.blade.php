@extends('layouts.app')

@section('content')
  @include('shared.statuses')
  @include('shared.errors')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <form action="{{ route('proposals.update', $proposal) }}" method="POST" novalidate class="js-form-proposals">
    @csrf
    @method('PATCH')

    <div class="card">
      <div class="card-header card-header-large">
        <div class="row">
          <div class="col-md-6 align-self-center">
            <h5 class="mb-0">
              {{ __('Proposal #:id', ['id' => $proposal->id]) }}
            </h5>
          </div>
          <div class="col-md-6 d-flex justify-content-end">
            <div class="form-row">
              <div class="col-auto">
                <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-secondary">
                  {{ __('Preview') }}
                </a>
              </div>
              <div class="col-auto">
                <a href="{{ route('proposals.exportPdf', $proposal->id) }}" class="btn btn-secondary col-auto">
                  {{ __('Download PDF') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-header py-3">
        @include('proposals.parts.form', ['model' => $proposal])
        {{ $proposal->client }}
      </div>
      <div class="card-body">
        <div class="row mb-5">
          <div class="col-md-3 mb-4">
            @include('proposals.parts.tabs')
          </div>

          <div class="col-md-9">
            @empty($tab)
              <div role="tabpanel" aria-labelledby="proposal-{{ $tab }}-tab">
                @include('proposals.cover-letter.edit')
              </div>
            @else
              <div role="tabpanel" aria-labelledby="proposal-{{ $tab }}-tab">
                @include("proposals.{$tab}.edit")
              </div>
            @endempty
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-right">
            <button type="submit" class="btn btn-secondary">
              {{ __('Save') }}
            </button>
            <a class="btn btn-primary" href="{{ route('proposals.send', $proposal->id) }}">
              {{ __('Send by email') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
  <script>
    const CURRENT_PROJECT_ID = {{ Js::from($proposal->project->id) }};
    const CURRENT_EMAIL_TEMPLATE_ID = {{ Js::from($proposal->emailTemplate->id) }};
  </script>
  @vite('resources/js/pages/proposals/edit.ts')
@endpush
