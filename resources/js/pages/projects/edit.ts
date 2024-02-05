export {};
import * as _ from "lodash";
import vSelect from "vue-select";
import { createApp } from "vue";
import Customer from "../../models/Customer";
import CustomerService from "../../services/CustomerService";

declare global {
  var CURRENT_CUSTOMER_ID: number;
  var CURRENT_CUSTOMER_TYPE: string;
}

const vueSelect = createApp({
  name: 'ProjectCreate',
  data: () => ({
    selected: null,
    limit: 10,
    currentPage: 1,
    options: [] as Customer[],
  }),
  mounted() {
    this.fetch();
  },
  methods: {
    async fetch() {
      try {
        const response = await CustomerService.get(CURRENT_CUSTOMER_ID, CURRENT_CUSTOMER_TYPE);
        if(response.data) {
          const responseData = response.data;
          const customer = new Customer(responseData.data[0]);
          this.selected = customer;
        }
      } catch(err) {
        console.error(err);
      }
    },
    onSearch(q, loading) {
      if(q.length) {
        loading(true);
        this.search(loading, q, this);
      }
    },
    search: _.debounce(async (loading, q, vm) => {
      try {
        const response = await CustomerService.search(q);
        if(response.data) {
          const responseData = response.data;
          vm.options = responseData.data.map(customerDTO => new Customer(customerDTO));
          vm.currentPage = responseData.meta.current_page;
          vm.totalPages = responseData.meta.last_page;
        }
      } catch {
        vm.errored = true;
      }
      loading(false);
    }, 350),
  }
});
vueSelect.component("v-select", vSelect);
vueSelect.mount("#projects-customer-select");
