export {};
import * as _ from "lodash";
import { createApp } from 'vue';
import VueSelect from 'vue-select';
import PricingTable from '../../components/PricingTable/PricingTable.vue';
import SelectProducts from '../../components/SelectProducts.vue';
import flatpickr from "flatpickr";
import ProjectService from "../../services/ProjectService";
import Project from "../../models/Project";

flatpickr('input[name="expiration_date"]');

const vueSelectApp = createApp({
  data: () => ({
    perPage: 10,
    currentPage: 0,
    totalPages: 0,
    options: [],
    selected: null,
  }),
  methods: {
    onSearch(search, loading) {
      if(search.length) {
        loading(true);
        this.search(loading, search, this);
      }
    },
    search: _.debounce(async (loading, q, vm) => {
      try {
        const response = await ProjectService.search(q);
        if(response.data) {
          vm.options = response.data.data.map(projectDTO => new Project(projectDTO));
          vm.currentPage = response.data.meta.current_page;
          vm.totalPages = response.data.meta.last_page;
        }
      } catch {
        vm.errored = true;
      }
      loading(false);
    }, 350),
  },
});
vueSelectApp.component("v-select", VueSelect);
vueSelectApp.mount("#proposal-select-project");

if(document.querySelector("#proposal-services")) {
  const servicesTable = createApp({});
  servicesTable.component("pricing-table", PricingTable);
  servicesTable.mount("#proposal-services");
}

if(document.querySelector("#proposal-create-products")) {
  const selectProducts = createApp({});
  selectProducts.component("select-products", SelectProducts);
  selectProducts.mount("#proposal-create-products");
}
