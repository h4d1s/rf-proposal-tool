<div class="card js-dashboard-quick-stats">
  <div class="card-header bg-white">
    <h4 class="card-header__title">{{ __("Quick stats") }}</h4>
  </div>
  <div class="card-body">
    <ul class="list-unstyled list-skills">
      <li>
        <div>{{ __("This month") }}</div>
        <div class="quick-stats">
          <div class="quick-stats__item">
            <div class="progress" style="height: 6px;">
              <div
                class="progress-bar bg-approved js-dashboard-quick-stats-this-month-approved"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"></div>
              <div
                class="progress-bar bg-rejected js-dashboard-quick-stats-this-month-rejected"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"></div>
              <div
                class="progress-bar bg-primary js-dashboard-quick-stats-this-month-other"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </li>
      <li>
        <div>{{ __("Last month") }}</div>
        <div class="quick-stats">
          <div class="quick-stats__item">
            <div class="flex">
              <div class="progress" style="height: 6px;">
                <div
                  class="progress-bar bg-approved js-dashboard-quick-stats-last-month-approved"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
                <div
                  class="progress-bar bg-rejected js-dashboard-quick-stats-last-month-rejected"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
                <div
                  class="progress-bar bg-primary js-dashboard-quick-stats-last-month-other"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li>
        <div>{{ __("This year") }}</div>
        <div class="quick-stats">
          <div class="quick-stats__item">
            <div class="flex">
              <div class="progress" style="height: 6px;">
                <div
                  class="progress-bar bg-approved js-dashboard-quick-stats-this-year-approved"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
                <div
                  class="progress-bar bg-rejected js-dashboard-quick-stats-this-year-rejected"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
                <div
                  class="progress-bar bg-primary js-dashboard-quick-stats-this-year-other"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
    <div class="button-list">
      <span class="badge badge-pill text-white badge-light bg-approved">
        {{ __("Approved") }}
      </span>
      <span class="badge badge-pill text-white badge-light bg-rejected">
        {{ __("Rejected") }}
      </span>
      <span class="badge badge-pill text-white badge-light bg-primary">
        {{ __("Other") }}
      </span>
    </div>
  </div>
</div>
