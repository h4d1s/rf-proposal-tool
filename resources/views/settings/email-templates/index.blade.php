@extends('settings.layout')

@section('tab-content')
  @include('shared.statuses')
  @include('shared.errors')

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Email templates') }}</h5>
    </div>
    <form action="{{ route('email-templates.index') }}" class="js-form-email-templates" method="GET">
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
              <a href="{{ route('email-templates.create') }}" class="btn btn-primary">
                {{ __('New email template') }}
              </a>
            </div>
          </div>

          <hr>

          <div class="form-inline form-row">
            @if (count($email_templates) > 0)
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
                <th style="width: 230px;"></th>
              </tr>
            </thead>
            <tbody>
              @if (count($email_templates) > 0)
                @foreach ($email_templates as $email_template)
                  <tr>
                    <td style="width: 18px;">
                      <x-table.checkbox-select id="{{ $email_template->id }}" name="email_template"></x-table.checkbox-select>
                    </td>
                    <td>{{ $email_template->name }}</td>
                    <td>
                      <a href="{{ route('email-templates.show', $email_template) }}" class="btn btn-primary">
                        {{ __('View') }}
                      </a>
                      <a href="{{ route('email-templates.edit', $email_template) }}" class="btn btn-secondary">
                        {{ __('Edit') }}
                      </a>
                      <a href="{{ route('email-templates.delete', $email_template) }}" class="btn btn-link text-muted">
                        <i class="material-icons">delete</i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5" class="text-center p-4">
                    {{ __('Sorry, no email templates to show.') }}
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
          <div class="card-footer text-right">
            <x-table.paginator :paginator="$email_templates"></x-table.paginator>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/email-templates/index.ts')
@endpush
