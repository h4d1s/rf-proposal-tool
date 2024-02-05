@extends('layouts.app')

@section('content')
  @include('shared.statuses')
  @include('shared.errors')

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Clients') }}</h5>
    </div>
    <form action="{{ route('clients.index') }}" class="js-form-clients">
      <div class="table-responsive border-bottom">
        <div class="card-header py-3">
          <div class="form-inline form-row">
            <div class="form-group col-sm-12 col-md-auto">
              <input type="search" class="form-control w-100 search" id="search" name="search"
                placeholder="{{ __('Search') }}" value="{{ request('search') }}" />
            </div>
            <div class="form-group col-sm-12 col-md-auto">
              <button type="submit" class="btn btn-secondary">
                {{ __('Filter') }}
              </button>
            </div>
            <div class="form-group col-sm-12 col-md-auto ml-md-auto">
              <a href="{{ route('clients.create') }}" class="btn btn-primary">
                {{ __('New client') }}
              </a>
            </div>
          </div>

          <hr>

          <div class="form-inline form-row">
            @if (count($clients) > 0)
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
          <table class="table mb-0 thead-border-top-0">
            <thead>
              <tr>
                <th>
                  <x-table.checkbox-toggle-all></x-table.checkbox-toggle-all>
                </th>
                <th>
                  <x-table.sort-link name="first_name" text="{{ __('Name') }}"></x-table.sort-link>
                </th>
                <th>
                  <x-table.sort-link name="company" text="{{ __('Company') }}"></x-table.sort-link>
                </th>
                <th>
                  <x-table.sort-link name="email" text="{{ __('Email') }}"></x-table.sort-link>
                </th>
                <th>
                  <x-table.sort-link name="phone" text="{{ __('Phone number') }}"></x-table.sort-link>
                </th>
                <th>{{ __('Projects') }}</th>
                <th style="width: 230px;"></th>
              </tr>
            </thead>
            <tbody>
              @if (count($clients) > 0)
                @foreach ($clients as $client)
                  <tr>
                    <td style="width: 18px;">
                      <x-table.checkbox-select id="{{ $client->id }}" name="client"></x-table.checkbox-select>
                    </td>
                    <td>{{ $client->fullname }}</td>
                    <td>
                      @if($client->company)
                        {{ $client->company->name }}
                      @endif
                    </td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
                      <a href="{{ route('projects.index', ['client' => $client->id]) }}">
                        {{ $client->projects()->count() }}
                      </a>
                    </td>
                    <td>
                      <a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary">
                        {{ __('View') }}
                      </a>
                      <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-secondary">
                        {{ __('Edit') }}
                      </a>
                      <a href="{{ route('clients.delete', $client) }}" class="btn btn-link text-muted">
                        <i class="material-icons">delete</i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="7" class="text-center p-4">
                    <em>{{ __('Sorry, no clients matched your criteria.') }}</em>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
          <div class="card-footer text-right">
            <x-table.paginator :paginator="$clients"></x-table.paginator>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/clients/index.ts')
@endpush
