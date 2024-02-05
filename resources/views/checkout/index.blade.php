@extends("layouts.blank")

@section("content")
  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  <main class="container">
    <div class="py-5 text-center">
      <x-application-logo :big="true"></x-application-logo>
      <h2>{{ __("Checkout") }}</h2>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <ul class="list-group mb-3">
          @if($proposal->pricingTable)
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">{{ __("Services") }}</h6>
              <small class="text-muted">{{ __("Sum of all services") }}</small>
            </div>
            <span class="text-muted">{{ $currency }}{{ $proposal->pricingTable->total }}</span>
          </li>
          @endif
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">{{ __("Products") }}</h6>
              <small class="text-muted">{{ __("Sum of all products") }}</small>
            </div>
            <span class="text-muted">${{ $proposal->products->sum("price") }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>{{ __("Total") }}</span>
            <strong>{{ $currency }}{{ $sum }}</strong>
          </li>
        </ul>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">{{ __("Billing address") }}</h4>
        <form method="POST" action="{{ route("checkout.process-payment") }}" id="payment-form">
          @csrf
          @method('POST')
          <input type="hidden" name="t" value="{{ request()->get("t") }}" />

          <div class="row g-3">
            @if($customer->getMorphClass() === "App\Models\Client")
              <x-form.input :model="$customer"
                :disabled="true"
                label="{{ __('First name') }}"
                name="first_name"
                class="col-sm-6">
              </x-form.input>

              <x-form.input
                :model="$customer"
                :disabled="true"
                label="{{ __('Last name') }}"
                name="last_name"
                class="col-sm-6">
              </x-form.input>
            @else
              <x-form.input
                :model="$customer"
                :disabled="true"
                label="{{ __('Company Name') }}"
                name="name"
                class="col-sm-12">
              </x-form.input>
            @endif

            <x-form.input
              :model="$customer"
              :disabled="true"
              label="{{ __('Email') }}"
              name="email"
              class="col-12">
            </x-form.input>

            <x-form.input :model="$customer->address"
              :disabled="true"
              label="{{ __('Address') }}"
              name="address"
              class="col-12">
            </x-form.input>

            <x-form.input
              :model="$customer->address"
              :disabled="true"
              label="{{ __('ZIP') }}"
              name="postal_code"
              class="col-md-4">
            </x-form.input>

            <x-form.input :model="$customer->address"
              :disabled="true"
              label="{{ __('City') }}"
              name="city"
              class="col-md-4">
            </x-form.input>

            <div class="col-md-4">
              <x-form.select id="country" name="country_id" label="{{ __('Country') }}" :disabled="true">
                <x-slot:options>
                  <option value="">---</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('country', $customer->address->country->code) === $country->code)>
                      {{ $country->name }}
                    </option>
                  @endforeach
                </x-slot>
              </x-form.select>
            </div>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">{{ __("Payment") }}</h4>
          <div id="card-element" class="mb-3"></div>
          <div id="card-errors" role="alert" class="text-danger"></div>

          <hr class="my-4">
          <button class="w-100 btn btn-primary btn-lg" type="submit">{{ __("Pay") }}</button>
        </form>
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    var stripe = Stripe('{{ $stripe_publishable_key }}');
    var elements = stripe.elements();
    var card = elements.create('card', {
      hidePostalCode: true
    });

    card.mount('#card-element');
    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });
  
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
  
      stripe.confirmCardPayment('{{ $clientSecret }}', {
        payment_method: {
          card: card
        }
      }).then(function(result) {
        if (result.error) {
          console.error(result.error.message);
        } else {
          if (result.paymentIntent.status === 'succeeded') {
            form.submit();
          }
        }
      });
    });
  </script>
@endpush