@extends('layouts.app')

@section('content')

  @include('shared.statuses')
  @include('shared.errors')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Proposals') }}</h5>
    </div>
    <form action="{{ route('proposals.index') }}" method="GET" class="js-form-proposals">
      <div class="table-responsive border-bottom">
        <div class="card-header py-3">
          <input type="hidden" name="orderby" id="_orderby" value="{{ request()->get('orderby') }}" />
          <input type="hidden" name="order" id="_order" value="{{ request()->get('order') }}" />

          <div class="row">
            <div class="col form-inline form-row">
              <div class="form-group col-sm-6 col-md-auto">
                <input type="text" class="form-control w-100" id="date_from" name="date_from"
                  placeholder="{{ __('Date from') }}" value="{{ request('date_from') }}" />
              </div>
              <div class="form-group col-sm-6 col-md-auto">
                <input type="text" class="form-control w-100" id="date_to" name="date_to"
                  placeholder="{{ __('Date to') }}" value="{{ request('date_to') }}" />
              </div>
              <div class="form-group col-sm-12 col-md-auto">
                <input type="search" class="form-control w-100 search" id="search" name="search"
                  placeholder="{{ __('Search') }}" value="{{ request('search') }}" />
              </div>
              <div class="form-group col-sm-12 col-md-auto">
                <button type="submit" class="btn btn-secondary">
                  {{ __('Filter') }}
                </button>
              </div>
            </div>

            <div class="col col-md-auto ml-md-auto form-inline form-row">
              <div class="form-group col-sm-12 col-md-auto">
                <a href="{{ route('proposals.export') }}" class="btn btn-link text-muted">
                  {{ __('Export CSV') }}
                  <i class="material-icons">download</i>
                </a>
              </div>
              <div class="form-group col-sm-12 col-md-auto">
                <a href="{{ route('proposals.create') }}" class="btn btn-primary">
                  {{ __('New proposal') }}
                </a>
              </div>
            </div>
          </div>

          <hr>

          <div class="form-inline form-row">
            @if (count($proposals) > 0)
              <div class="form-group col-sm-4 col-md-auto js-select-bulk-action">
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

            <div class="form-inline form-group col-auto ml-auto">
              <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" name="state[]" class="custom-control-input js-checkbox-state" id="state_sent"
                  value="sent" @checked(request('state') && in_array('sent', request('state'))) />
                <label class="custom-control-label" for="state_sent">
                  {{ __('Sent') }}
                </label>
              </div>
              <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" name="state[]" class="custom-control-input js-checkbox-state" id="state_viewed"
                  value="viewed" @checked(request('state') && in_array('viewed', request('state'))) />
                <label class="custom-control-label" for="state_viewed">
                  {{ __('Viewed') }}
                </label>
              </div>
              <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" name="state[]" class="custom-control-input js-checkbox-state" id="state_approved"
                  value="approved" @checked(request('state') && in_array('approved', request('state'))) />
                <label class="custom-control-label" for="state_approved">
                  {{ __('Approved') }}
                </label>
              </div>
              <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" name="state[]" class="custom-control-input js-checkbox-state" id="state_rejected"
                  value="rejected" @checked(request('state') && in_array('rejected', request('state'))) />
                <label class="custom-control-label" for="state_rejected">
                  {{ __('Rejected') }}
                </label>
              </div>
              <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                <input type="checkbox" name="state[]" class="custom-control-input js-checkbox-state" id="state_draft"
                  value="draft" @checked(request('state') && in_array('draft', request('state'))) />
                <label class="custom-control-label" for="state_draft">
                  {{ __('Draft') }}
                </label>
              </div>
            </div>
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
                <th>{{ __('State') }}</th>
                <th>
                  {{ __('Total') }}
                </th>
                <th>
                  <x-table.sort-link name="created_at" text="{{ __('Created') }}"></x-table.sort-link>
                </th>
                <th style="width: 230px;"></th>
              </tr>
            </thead>
            <tbody>
              @if (count($proposals) > 0)
                @foreach ($proposals as $proposal)
                  <tr>
                    <td style="width: 18px;">
                      <x-table.checkbox-select id="{{ $proposal->id }}" name="proposal"></x-table.checkbox-select>
                    </td>
                    <td>{{ $proposal->name }}</td>
                    <td>
                      <span class="badge badge-secondary">
                        {{ $proposal->state->name }}
                      </span>
                    </td>
                    <td>{{ $currency }}{{ $proposal->total }}</td>
                    <td>{{ $proposal->created_at->diffForHumans() }}</td>
                    <td>
                      <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-primary">
                        {{ __('View') }}
                      </a>
                      <a href="{{ route('proposals.edit', $proposal->id) }}" class="btn btn-secondary">
                        {{ __('Edit') }}
                      </a>
                      <a href="{{ route('proposals.delete', $proposal->id) }}" class="btn btn-link text-muted">
                        <i class="material-icons">delete</i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="7" class="text-center p-4">
                    <em>{{ __('Sorry, no proposals matched your criteria.') }}</em>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <x-table.paginator :paginator="$proposals"></x-table.paginator>
        </div>
      </div>
    </form>
  </div>

@endsection

@push('scripts')
  @vite('resources/js/pages/proposals/index.ts')
@endpush
