@extends('layouts.export')

@section('content')
  @php
    $currency = $settings->where("key", "currency")->first()->value;

    $name = "";
    $projectable = $proposal->project->projectable;
    if($projectable->getMorphClass() === "App\Models\Client") {
      $name = $projectable->full_name;
    } else {
      $name = $projectable->name;
    }
  @endphp

  <div class="section section-cover">
    <h1 class="heading">{{ $proposal->name }}</h1>
    <p>{{ __('Prepared for:') }} {{ $proposal->project->projectable->fullname }}</p>
    <p>{{ __('Created by:') }} {{ $proposal->user->name }}</p>
  </div>

  @isset($proposal->cover_letter)
    <div class="section">
      <h2>{{ __("Cover letter") }}</h3>
      <p>{{ $proposal->cover_letter }}</p>
    </div>
  @endisset

  @isset($proposal->products)
    <div class="section">
      <h2>{{ __('Products') }}</h3>

      <table class="table mb-0">
          <thead>
              <tr>
                  <th scope="col">{{ __("Name") }}</th>
                  <th scope="col">{{ __("Description<") }}/th>
                  <th scope="col">{{ __("Price") }}</th>
              </tr>
          </thead>
          <tbody>
              @foreach($proposal->products as $product)
              <tr>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->description }}</td>
                  <td>{{ $currency }}{{ $product->price }}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
      
      <div class="total">
        {{ __("Total:") }} {{ $currency }}{{ $proposal->products->sum('price') }}
      </div>
    </div>
  @endisset

  @isset($proposal->pricingTable)
  <div class="section">
    <h2>{{ __("Services") }}</h2>

    <table class="table mb-0">
      <thead>
        <tr>
          <th scope="col">{{ __("Name") }}</th>
          <th scope="col">{{ __("Description") }}</th>
          <th scope="col">{{ __("Qty") }}</th>
          <th scope="col">{{ __("Price") }}</th>
          <th scope="col">{{ __("Unit") }}</th>
          <th scope="col">{{ __("Total") }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($proposal->pricingTable->items as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->description }}</td>
          <td>{{ $item->qty }}</td>
          <td>{{ $currency }}{{ $item->price }}</td>
          <td>{{ $item->unit }}</td>
          <td>{{ $currency }}{{ $item->qty * $item->price }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="total">
      {{ __("Total:") }} {{ $currency }}{{ $proposal->pricingTable->total }}
    </div>
  </div>
  @endisset

  @isset($proposal->conclusion)
    <div class="section">
      <h3>{{ __("Conclusion") }}</h3>
      <p>{{ $proposal->conclusion }}</p>
    <div>
  @endisset
@endsection
