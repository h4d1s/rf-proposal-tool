<div class="card">
  <div class="card-form__body card-body">
    <form action="{{ route('dashboard') }}" class="js-form-fubc" method="GET">
      <div class="form-row">

        <div class="col-12 col-md-4 mb-4">
          <label for="date_from">{{ __("Date from") }}</label>
          <input
            type="text"
            class="form-control"
            id="date_from"
            name="date_from"
            placeholder="{{ __('Date from') }}"
            value="{{ request()->get('date_from') }}"
          />
        </div>

        <div class="col-12 col-md-4 mb-4">
          <label for="date_to">{{ __("Date to") }}</label>
          <input
            type="text"
            class="form-control"
            id="date_to"
            name="date_to"
            placeholder="{{ __('Date to') }}"
            value="{{ request()->get('date_to') }}" />
        </div>
        <div class="col-12 col-md-4 mb-4">
          <label for="periodicity">
            {{ __("Weekly, Monthly") }}
          </label>
          <select
            id="periodicity"
            name="periodicity"
            class="form-control">
            <option
              value="weekly"
              @if(request()->get('weekly_monthly') && request()->get('weekly_monthly') === 'weekly') {{ "selected" }} @endif
            >
              {{ __("Weekly") }}
            </option>
            <option
              value="monthly"
              @if(request()->get('periodicity') && request()->get('periodicity') === 'monthly') {{ "selected" }} @endif
            >
              {{ __("Monthly") }}
            </option>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>

