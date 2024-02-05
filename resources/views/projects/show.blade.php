@extends('layouts.app')

@section('content')
  <div class="card card-form">
    <div class="card-header card-header-large">
      <h5 class="mb-0">
        {{ __('Project #:ID', ['id' => $project->id]) }}
      </h5>
    </div>

    <div class="card-form__body card-body bg-white">
      <form action="{{ route('projects.destroy', $project->id) }}" class="js-project-form" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-row">
          <div class="col-12 col-md-12 mb-3">
            <label class="form-label text-label">{{ __('Name') }}</label>
            <p>{{ $project->name }}</p>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label class="form-label text-label">{{ __('Description') }}</label>
            <p>{{ $project->description }}</p>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label class="form-label text-label">{{ __('Customer') }}</label>
            @if($project->projectable)
              @if($project->projectable->getMorphClass() === "App\Models\Client")
                <p>
                  <a href="{{ route('clients.show', $project->projectable) }}">
                    {{ $project->projectable->full_name }}
                  </a>
                </p>
              @else
                <p>
                  <a href="{{ route('companies.show', $project->projectable) }}">
                    {{ $project->projectable->name }}
                  </a>
                </p>
              @endif
            @else
                <p><em>{{ __("No customer.") }}</em></p>
            @endif
          </div>
        </div>

        <div class="form-row">
          <div class="col-12 col-md-12">
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">
              {{ __('Edit') }}
            </a>
            <button type="submit" class="btn btn-secondary">
              {{ __('Delete') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
