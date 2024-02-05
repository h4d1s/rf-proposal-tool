@extends('layouts.app')

@section('content')

  @include('shared.statuses')
  @include('shared.errors')

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Projects') }}</h5>
    </div>
    <form action="{{ route('projects.index') }}" class="js-form-projects">
      <div class="table-responsive border-bottom">
        <div class="card-header py-3">
          <div class="form-inline form-row">
            <div class="form-group col-sm-6 col-md-auto">
              <input type="text" class="form-control w-100" id="date_from" name="date_from"
                placeholder="{{ __('Date from') }}" value="{{ request()->get('date_from') }}" />
            </div>
            <div class="form-group col-sm-6 col-md-auto">
              <input type="text" class="form-control w-100" id="date_to" name="date_to"
                placeholder="{{ __('Date to') }}" value="{{ request()->get('date_to') }}" />
            </div>
            <div class="form-group col-sm-12 col-md-auto">
              <input type="search" class="form-control w-100 search" id="search" name="search"
                placeholder="{{ __('Search') }}" value="{{ request()->get('search') }}" />
            </div>
            <div class="form-group col-sm-12 col-md-auto">
              <button type="submit" class="btn btn-secondary">
                {{ __('Filter') }}
              </button>
            </div>
            <div class="form-group col-sm-12 col-md-auto ml-md-auto">
              <a href="{{ route('projects.create') }}" class="btn btn-primary">
                {{ __('New project') }}
              </a>
            </div>
          </div>

          <hr>

          <div class="form-inline form-row">
            @if (count($projects) > 0)
              <div class="form-group col-sm-8 col-md-auto">
                <select class="form-control" name="action">
                  <option value="-1">{{ __('Bulk actions') }}</option>
                  <option value="delete">{{ __('Delete') }}</option>
                </select>
              </div>
              <div class="form-group col-sm-4 col-md-auto">
                <button type="submit" class="btn btn-secondary">
                  {{ __('Apply') }}
                </button>
              </div>
            @endif
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive border-bottom">
            <table class="table mb-0 thead-border-top-0">
              <thead>
                <tr>
                  <th>
                    <x-table.checkbox-toggle-all></x-table.checkbox-toggle-all>
                  </th>
                  <th>
                    <x-table.sort-link name="name" text="{{ __('Name') }}"></x-table.sort-link>
                  </th>
                  <th>{{ __('Proposals') }}</th>
                  <th>
                    <x-table.sort-link name="created_at" text="{{ __('Created') }}"></x-table.sort-link>
                  </th>
                  <th style="width: 230px;"></th>
                </tr>
              </thead>
              <tbody>
                @if (count($projects) > 0)
                  @foreach ($projects as $project)
                    <tr>
                      <td style="width: 18px;">
                        <x-table.checkbox-select id="{{ $project->id }}" name="project"></x-table.checkbox-select>
                      </td>
                      <td>{{ $project->name }}</td>
                      <td>
                        <a href="{{ route('proposals.index', ['project' => $project->id]) }}">
                          {{ $project->proposals()->count() }}
                        </a>
                      </td>
                      <td>{{ $project->created_at->diffForHumans() }}</td>
                      <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">
                          {{ __('View') }}
                        </a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-secondary">
                          {{ __('Edit') }}
                        </a>
                        <a href="{{ route('projects.delete', $project) }}" class="btn btn-link text-muted">
                          <i class="material-icons">delete</i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7" class="text-center p-4">
                      <em>{{ __('Sorry, no projects matched your criteria.') }}</em>
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-right">
          <x-table.paginator :paginator="$projects"></x-table.paginator>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/projects/index.ts')
@endpush
