<div class="card js-dashboard-pie-chart">
  <div class="card-header card-header-tabs-basic nav" role="tablist">
    <a
      href="#active_proposals"
      class="active"
      data-toggle="tab"
      role="tab"
      aria-controls="active_proposals"
      aria-selected="true">
      {{ __("Proposals") }}
    </a>
  </div>
  <div class="list-group tab-content list-group-flush">
    <div class="card-body">
      <div class="chart">
        <canvas id="pieChart" class="chart-canvas"></canvas>
      </div>
    </div>
  </div>
</div>