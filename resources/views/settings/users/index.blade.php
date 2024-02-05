@extends('settings.layout')

@section('tab-content')
  @include('shared.statuses')
  @include('shared.errors')

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Users') }}</h5>
    </div>
    <form action="{{ route('users.index') }}" class="js-form-users" method="GET">
      <div class="table-responsive border-bottom">
        <div class="card-header py-3">
          <div class="form-inline form-row">
            <div class="form-group col-sm-6 col-md-auto">
              <input type="search" class="form-control w-100 search" id="search" name="search"
                placeholder="{{ __('Search') }}" value="{{ request('search') }}" />
            </div>
            <div class="form-group col-sm-12 col-md-auto">
              <button type="submit" class="btn btn-secondary">
                {{ __('Filter') }}
              </button>
            </div>
            <div class="form-group col-sm-6 col-md-auto ml-md-auto">
              <a href="{{ route('users.create') }}" class="btn btn-primary">
                {{ __('New user') }}
              </a>
            </div>
          </div>

          <hr>

          <div class="form-inline form-row">
            @if (count($users) > 0)
              <div class="form-group col-sm-8 col-md-auto">
                <select class="form-control" name="action">
                  <option value="-1">{{ __('Bulk actions') }}</option>
                  <option value="delete">{{ __('Delete') }}</option>
                </select>
              </div>
              <div class="form-group col-sm-4 col-md-auto js-select-bulk-action">
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
                  <x-table.sort-link name="name" text="{{ __('Name') }}"></x-table.sort-link>
                </th>
                <th>
                  <x-table.sort-link name="email" text="{{ __('Email') }}"></x-table.sort-link>
                </th>
                <th>
                  {{ __('Role') }}
                </th>
                <th style="width: 230px;"></th>
              </tr>
            </thead>
            <tbody>
              @if (count($users) > 0)
                @foreach ($users as $user)
                  <tr>
                    <td style="width: 18px;">
                      <x-form.checkbox id="checkbox-select-{{ $user->id }}" name="user[]"
                        value="{{ $user->id }}" class="mb-0" classInput="js-checkbox-select-row">
                        <slot name="label">
                          <span class="text-hide">
                            {{ __('Check') }}
                          </span>
                        </slot>
                      </x-form.checkbox>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                      @forelse ($user->roles as $role)
                        {{ $role->name }}
                        @if ($loop->iteration && !$loop->last)
                          ,
                        @endif
                      @empty
                        {{ __('No roles') }}
                      @endforelse
                    </td>
                    <td>
                      <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">
                        {{ __('View') }}
                      </a>
                      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary">
                        {{ __('Edit') }}
                      </a>
                      <a href="{{ route('users.delete', $user->id) }}" class="btn btn-link text-muted">
                        <i class="material-icons">delete</i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5" class="text-center p-4">
                    {{ __('Sorry, no users to show.') }}
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
          <div class="card-footer text-right">
            <x-table.paginator :paginator="$users"></x-table.paginator>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/users/index.ts')
@endpush
