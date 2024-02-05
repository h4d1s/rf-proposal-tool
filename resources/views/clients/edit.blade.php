@extends("layouts.app")

@section("content")
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Client #:id', ["id" => $client->id]) }}
      </h5>
    </div>
    <div class="row no-gutters">
      <div class="col-lg-12 card-body">
        @include('shared.statuses')
        @include('shared.errors')

        <form action="{{ route('clients.update', $client->id) }}" method="POST">
          @csrf
          @method('PATCH')

          @include("clients.parts.form", ["model" => $client])

          <div class="form-row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
              </button>
              <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                {{ __("Cancel") }}
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const CURRENT_COMPANY_ID = {{ $client->company ? $client->company->id : 0 }};
  </script>
  @vite('resources/js/pages/clients/edit.ts')
@endpush