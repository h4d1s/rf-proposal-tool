@extends('layouts.app')

@section('content')
  @include('shared.statuses')
  @include('shared.errors')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="card">
    <div class="card-header card-header-large">
      <h5 class="mb-0">{{ __('Products') }}</h5>
    </div>
    <form action="{{ route('products.index') }}" class="js-form-products">
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
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table mb-0 thead-border-top-0">
            <thead>
              <tr>
                <th>
                  <x-table.sort-link name="name" text="{{ __('Name') }}"></x-table.sort-link>
                </th>
                <th>
                  <x-table.sort-link name="price" text="{{ __('Price') }}"></x-table.sort-link>
                </th>
                <th style="width: 230px;"></th>
              </tr>
            </thead>
            <tbody>
              @if (count($products) > 0)
                @foreach ($products as $product)
                  <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $currency }}{{ $product->price }}</td>
                    <td>
                      <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">
                        {{ __('View') }}
                      </a>
                      <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary">
                        {{ __('Edit') }}
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="4" class="text-center p-4">
                    <em>{{ __('Sorry, no products to show.') }}</em>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
          <div class="card-footer text-right">
            <x-table.paginator :paginator="$products"></x-table.paginator>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/pages/products/index.ts')
@endpush
