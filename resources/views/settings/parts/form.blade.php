<div class="card card-form">
  <div class="row no-gutters">
    <div class="col-lg-4 card-body">
      <p><strong class="headings-color">Currency</strong></p>
      <p class="text-muted">Set default currency.</p>
    </div>
    <div class="col-lg-8 card-form__body card-body">
      @php
        $currency_setting = null;
        $currency_setting_query = $settings->where("key", "currency");
        if($currency_setting_query->count()) {
          $currency_setting = $currency_setting_query->first()->value;
        }
      @endphp
      <x-form.input
        value="{{ $currency_setting }}"
        label="{{ __('Currency') }}"
        name="currency"
        :required="true">
      </x-form.input>
    </div>
  </div>
</div>

<div class="card card-form">
  <div class="row no-gutters">
    <div class="col-lg-4 card-body">
      <p><strong class="headings-color">Stripe</strong></p>
      <p class="text-muted">Credentials for accepting payments. More on <a href="https://support.stripe.com/questions/locate-api-keys-in-the-dashboard">docs</a>.</p>
    </div>
    <div class="col-lg-8 card-form__body card-body">
      @php
        $stripe_publishable_key = null;
        $stripe_publishable_key_query = $settings->where("key", "stripe_publishable_key");
        if($stripe_publishable_key_query->count()) {
          $stripe_publishable_key = $stripe_publishable_key_query->first()->value;
        }
      @endphp
      <x-form.input
        value="{{ $stripe_publishable_key }}"
        label="{{ __('Publishable key') }}"
        name="stripe_publishable_key">
      </x-form.input>
      @php
        $stripe_secret_key = null;
        $stripe_secret_key_query = $settings->where("key", "stripe_secret_key");
        if($stripe_secret_key_query->count()) {
          $stripe_secret_key = $stripe_secret_key_query->first()->value;
        }
      @endphp
      <x-form.input
        value="{{ $stripe_secret_key }}"
        label="{{ __('Secret key') }}"
        name="stripe_secret_key">
      </x-form.input>
    </div>
  </div>
</div>