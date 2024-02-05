export {};
import * as _ from "lodash";
import vSelect from "vue-select";
import { createApp } from "vue";
import Company from "../../models/Company";
import CompanyService from "../../services/CompanyService";

declare global {
  var CURRENT_COMPANY_ID: number;
}

const vueSelect = createApp({
    name: 'ClientCompany',
    data: () => ({
      selected: null,
      options: [],
    }),
    mounted() {
      this.fetch();
    },
    methods: {
      async fetch() {
        if(CURRENT_COMPANY_ID == 0) {
          return;
        }

        try {
          const response = await CompanyService.get(CURRENT_COMPANY_ID);
          if(response.data) {
            const responseData = response.data;
            let companies = new Company(responseData.data);
            this.selected = companies[0];
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
          const response = await CompanyService.search(q);
          if(response.data) {
            const responseData = response.data;
            vm.options = responseData.data.map(companyDTO => new Company(companyDTO));
          }
        } catch {
          vm.errored = true;
        }
        loading(false);
      }, 350),
    }
  });
  vueSelect.component("v-select", vSelect);
  vueSelect.mount("#client-company-select");