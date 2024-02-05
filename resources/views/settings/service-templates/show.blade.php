@extends('settings.layout')

@section('tab-content')
  @php 
  $service_template = !isset($service_template) ? 
    App\Models\ServiceTemplate::find(request()->route('service_template'))->first() :
    $service_template;
  @endphp

  <div class="card card-form">
    <div class="card-header card-header-large">
      <div class="row">
        <div class="col-sm-6 col-12 d-flex align-items-center">
          <h5 class="mb-0">{{ __('Edit Service Template #:id', ['id' => $service_template->id]) }}</h5>
        </div>

        <div class="col-sm-6 col-md-auto ml-md-auto d-flex align-items-center">
          <a href="{{ route('service-templates.service-template-items.create', ["service_template" => $service_template->id]) }}" class="btn btn-primary">
            {{ __('New item') }}
          </a>
        </div>
      </div>
    </div>
    <div class="card-form__body card-body bg-white p-0">
      @include('shared.statuses')
      @include('shared.errors')

      @php
        $currency = $settings->where("key", "currency")->first()->value;
      @endphp

      <form action="{{ route('service-templates.update', $service_template->id) }}" method="POST" novalidate>
        @csrf
        @method('PATCH')

          <table class="table mb-0 thead-border-top-0">
            <thead>
              <tr>
                <th scope="col">{{ __("Name") }}</th>
                <th scope="col">{{ __("Description") }}</th>
                <th scope="col">{{ __("Qty") }}</th>
                <th scope="col">{{ __("Unit") }}</th>
                <th scope="col">{{ __("Price") }}</th>
                <th style="width: 140px;"></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($service_template->items as $item)
              <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $currency }}{{ $item->price }}</td>
                <td>
                  <a href="{{ route("service-templates.service-template-items.edit", ["service_template" => $service_template->id, "service_template_item" => $item->id]) }}" class="btn btn-secondary">
                    {{ __("Edit") }}
                  </a>
                  <a href="{{ route("service-templates.service-template-items.delete", ["service_template" => $service_template->id, "service_template_item" => $item->id]) }}" class="btn btn-link text-muted">
                    <i class="material-icons">delete</i>
                  </a>
                </td>
              </tr>
              @empty
                <tr class="text-center">
                  <td colspan="6" class="py-3"><em>{{ __("No items found") }}</em></td>
                </tr>
              @endforelse
            </tbody>
          </table>
      </form>
    </div>
  </div>
@endsection