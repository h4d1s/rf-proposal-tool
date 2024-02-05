export {};
import * as _ from "lodash";
import { createApp } from 'vue';
import vSelect from "vue-select";
import Customer from "../../models/Customer";
import CustomerService from "../../services/CustomerService";

const vueSelect = createApp({
  name: 'ProjectCreate',
  data: () => ({
    selected: null,
    limit: 10,
    currentPage: 1,
    options: [],
  }),
  mounted() {
  },
  methods: {
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