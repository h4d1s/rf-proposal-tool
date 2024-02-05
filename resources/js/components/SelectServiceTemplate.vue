<template>
  <div
    class="modal fade"
    id="service-template-modal"
    tabindex="-1"
    aria-labelledby="serviceTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="serviceTemplateModalLabel">Service templates</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="serviceTemplate in serviceTemplates">
                <td>{{ serviceTemplate.name }}</td>
                <td>{{ serviceTemplate.total }}</td>
                <td>
                  <a
                    href="#"
                    @click.prevent="onPick(serviceTemplate)"
                    class="btn btn-sm btn-primary">
                    Pick
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import $ from "jquery";
import { defineComponent } from "vue";
import ServiceTemplateService from "../services/ServiceTemplateService";
import ServiceTemplate from "../models/ServiceTemplate";

export default defineComponent({
  data() {
    return {
      serviceTemplates: [],
      currentPage: 0,
      totalPages: 0,
      isLoading: true,
      errored: false,
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    openModal() {
      $("#service-template-modal").modal('show');
    },
    onPick(template: ServiceTemplate) {
      $("#service-template-modal").modal('hide');
      this.$emit('template-chosen', template);
    },
    async fetch(page = 1) {
      try {
        const response = await ServiceTemplateService.getAll(page, 3);
        if(response.data) {
          const responseData = response.data;
          this.serviceTemplates = responseData.data.map(
            serviceTemplateDTO => new ServiceTemplate(serviceTemplateDTO)
          );
          this.currentPage = responseData.meta.current_page;
          this.totalPages = responseData.meta.last_page;
        }
      } catch {
        this.errored = true;
      }

      this.isLoading = false;
    },
  }
});
</script>
