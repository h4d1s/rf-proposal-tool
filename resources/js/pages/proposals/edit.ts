export {};
import * as _ from "lodash";
import { createApp } from 'vue'; 
import VueSelect from 'vue-select';
import PricingTable from '../../components/PricingTable/PricingTable.vue';
import SelectProducts from '../../components/SelectProducts.vue';
import flatpickr from "flatpickr";
import ProjectService from "../../services/ProjectService";
import Project from "../../models/Project";
import EmailTemplateService from "../../services/EmailTemplateService";
import EmailTemplate from "../../models/EmailTemplate";

declare global {
  var SELECTED_PRODUCTS: number[];
  var CURRENT_PROJECT_ID: number;
  var CURRENT_EMAIL_TEMPLATE_ID: number;
}

flatpickr('input[name="expiration_date"]');

if(document.querySelector("#proposal-select-project")) {
  const vueSelectAppProject = createApp({
    data: () => ({
      perPage: 10,
      currentPage: 0,
      totalPages: 0,
      options: [],
      selected: null,
    }),
    async mounted() {
      this.fetch();
    },
    methods: {
      async fetch() {
        const response = await ProjectService.get(CURRENT_PROJECT_ID);
        if(response.data) {
          const responseData = response.data;
          const project = new Project(responseData.data[0]);
          this.selected = project;
        }
      },
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
  vueSelectAppProject.component("v-select", VueSelect);
  vueSelectAppProject.mount("#proposal-select-project");
}

if(document.querySelector("#proposal-select-email-template")) {
  const vueSelectAppEmailTemplate = createApp({
    data: () => ({
      perPage: 10,
      currentPage: 0,
      totalPages: 0,
      options: [],
      selected: null,
    }),
    async mounted() {
      this.fetch();
    },
    methods: {
      async fetch() {
        try {
          const response = await EmailTemplateService.get(CURRENT_EMAIL_TEMPLATE_ID);
          if(response.data) {
            const responseData = response.data;
            const emailTemplate = new EmailTemplate(responseData.data[0]);
            this.selected = emailTemplate;
          }
        } catch(error) {
          console.error(error);
        }
      },
      onSearch(search, loading) {
        if(search.length) {
          loading(true);
          this.search(loading, search, this);
        }
      },
      search: _.debounce(async (loading, q, vm) => {
        try {
          const response = await EmailTemplateService.search(q);
          if(response.data) {
            const responseData = response.data;
            vm.options = responseData.data.map(emailTemplateDTO => new EmailTemplate(emailTemplateDTO));
            vm.currentPage = responseData.meta.current_page;
            vm.totalPages = responseData.meta.last_page;
          }
        } catch {
          vm.errored = true;
        }
        loading(false);
      }, 350),
    },
  });
  vueSelectAppEmailTemplate.component("v-select", VueSelect);
  vueSelectAppEmailTemplate.mount("#proposal-select-email-template");
}

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
