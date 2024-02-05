export {};
import Chart from 'chart.js/auto';
type ProposalsChart = {
    labels?: [];
    data?: [];
};
declare global {
    var PROPOSALS_CHART: ProposalsChart;
}

const ctx = (document.getElementById('pieChart') as HTMLCanvasElement).getContext('2d');
if(ctx) {
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: PROPOSALS_CHART.labels,
      datasets: [{
        data: PROPOSALS_CHART.data,
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(235, 205, 86)',
          'rgb(255, 162, 132)',
          'rgb(132, 162, 235)',
        ],
        hoverOffset: 4
      }]
    }
  });
}
