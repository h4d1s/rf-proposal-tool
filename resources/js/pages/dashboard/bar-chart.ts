export {};
import Chart from 'chart.js/auto';
import { merge } from 'chart.js/helpers';
import flatpickr from "flatpickr";
import rangePlugin from "flatpickr/dist/plugins/rangePlugin";
import weekSelectPlugin from "flatpickr/dist/plugins/weekSelect/weekSelect";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect";
import { Plugin } from "flatpickr/dist/types/options";

type BarChart = {
    labels?: string[];
    data?: [];
};
declare global {
    var BAR_CHART: BarChart;
}

const ctx = (document.getElementById('barChart') as HTMLCanvasElement).getContext('2d');
const form = document.querySelector<HTMLFormElement>('.js-form-fubc');
const inputDateFrom = document.querySelector<HTMLInputElement>('#date_from');
const inputDateTo = document.querySelector<HTMLInputElement>('#date_to');
const selectPeriodicity = document.querySelector<HTMLInputElement>('#periodicity');

if(ctx && inputDateFrom && inputDateTo && form && selectPeriodicity) {
  const barChartLabels = BAR_CHART.labels;
  const sent_data = BAR_CHART.data ?? [];

  const barChartDataSets = [{
      label: "Sent",
      data: sent_data["sent"],
      backgroundColor: '#4fa9d2'
    }, {
      label: "Viewed",
      data: sent_data["viewed"],
      backgroundColor: '#f89406'
    }, {
      label: "Approved",
      data: sent_data["approved"],
      backgroundColor: '#43c512'
    }, {
      label: "Rejected",
      data: sent_data["rejected"],
      backgroundColor: '#e82250'
  }];

  const options = merge({
    barRoundness: 1.2
  }, {});

  const data = {
    labels: barChartLabels,
    datasets: barChartDataSets
  };

  new Chart(ctx, {
    type: 'bar',
    data: data
  });
}

function initFlatpickr(from: HTMLInputElement, to: HTMLInputElement, form: HTMLFormElement, type) {
    let plugins: Plugin<any>[] = [
        rangePlugin({ input: `#${to.id}`})
    ];
    const formatDate = (type === "weekly" ? "Y-W" : "Y-m");
    let config = {
        locale: {
            firstDayOfWeek: 1
        },
        onChange: (selectedDates, dateStr, instance) => {
            if (selectedDates.length === 2) {
                form.submit();
            }
        },
        parseDate: (datestr, format) => {
            return flatpickr.parseDate(datestr, formatDate);
        },
        formatDate: (date, format, locale) => {
            return flatpickr.formatDate(date, formatDate);
        }
    };
    if(type === "monthly") {
        plugins.push(monthSelectPlugin());
    } else {
        plugins.push(weekSelectPlugin());
        config['weekNumbers'] = true;
    }
    config['plugins'] = plugins;
    if(from["_flatpickr"]) {
        from["_flatpickr"].clear();
        from["_flatpickr"].destroy();
        from.value = "";
        from.defaultValue = "";
    }
    if(to["_flatpickr"]) {
        to["_flatpickr"].clear();
        to["_flatpickr"].destroy();
        to.value = "";
        to.defaultValue = "";
    }
    // @ts-ignore
    flatpickr(`#${from.id}`, config);
}

if(inputDateFrom && inputDateTo && form && selectPeriodicity) {
    initFlatpickr(inputDateFrom, inputDateTo, form, selectPeriodicity.value);
    selectPeriodicity.addEventListener("change", (e) => {
        initFlatpickr(inputDateFrom, inputDateTo, form, selectPeriodicity.value);
    });
}
