@extends("layouts.app")

@section("content")
  @include('shared.statuses')
  @include('shared.errors')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <div class="card">
    <div class="card-header card-header-large">
      <div class="row">
        <div class="col-md-6 align-self-center">
          <h5 class="text-dark-gray mb-0">
            {{ __('Collections') }}
          </h5>
        </div>
        <div class="col-md-6">
          <form action="{{ route('collections.index') }}" class="form-inline form-row justify-content-end">
            <div class="form-group col-auto">
              <input
                type="search"
                class="form-control search"
                id="search"
                name="search"
                placeholder="{{ __('Search') }}"
                value="{{ request('search') }}"
              />
            </div>
            <div class="form-group col-auto">
              <button
                type="submit"
                class="btn btn-secondary">
                {{ __("Filter") }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if(!$collections->isEmpty())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
          @foreach($collections as $collection)
            <div class="col rf-item">
              <div class="card stories-card-popular">
                <img
                  src="{{ asset("storage/images/{$collection->image->path}") }}"
                  alt="{{ $collection->name }}"
                  class="card-img"
                />
                <div class="stories-card-popular__content">
                  <div class="stories-card-popular__title card-body text-left">
                    <small class="text-muted text-uppercase">
                      {{ $currency }}<span>{{ $collection->price }}</span>
                    </small>

                    <h4 class="card-title m-0">
                      <a href="{{ route('collections.show', $collection->id) }}">
                        <span>{{ $collection->name }}</span>
                      </a>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <x-table.paginator :paginator="$collections"></x-table.paginator>
      @else
        <p class="text-center py-4 m-0">
          <em>{{ __('No collections to show.') }}</em>
        </p>
      @endif
    </div>
  </div>
@endsection
