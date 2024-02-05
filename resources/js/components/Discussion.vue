<template>
  <div class="border-bottom">
    <div class="flex d-flex flex-column discussions">
      <template v-if="this.discussions.length > 0" v-for="discussion in this.discussions">
        <div class="d-flex align-items-center mb-2">
          <div>
            <span class="text-body bold">
              {{ discussion.owner_name }}
            </span>
            <span class="badge badge-secondary ml-1">
              {{ discussion.owner_type }}
            </span>
          </div>
          <div class="ml-auto">
            <small class="text-muted">
              {{ discussion.created_at }}
            </small>
          </div>
        </div>
        <p>{{ discussion.body }}</p>
      </template>
      <div class="alert alert-info" v-if="this.discussions.length === 0">
        No discussions yet.
      </div>
    </div>
  </div>
  <div class="form-group message-box">
    <label for="message-text">Message:</label>
    <textarea class="form-control" id="message-text" v-model="message"></textarea>
  </div>
</template>
  
<script lang="ts">
import { defineComponent } from "vue";
import DiscussionService from "../services/DiscussionService";
import Discussion from "../models/Discussion";

export default defineComponent({
  data() {
    return {
      page: 1,
      perPage: 10,
      totalPages: 1,
      discussions: [] as Discussion[],
      message: "",
      messageInterval: null
    }
  },
  props: {
    proposal_id: {
      type: Number
    },
    customer_id: {
      type: Number
    },
    customer_type: {
      type: String
    },
  },
  mounted() {
    this.fetch();

    this.messageInterval = setInterval(fn => this.fetch(), 10000);
  },
  beforeUnmount() {
    clearInterval(this.messageInterval);
  },
  methods: {
    async send() {
      if(this.message.length === 0) {
        alert("Please write message in the comment body.");
        return;
      }
      
      try {
        await DiscussionService.create(this.message, this.proposal_id, this.customer_id, this.customer_type);
        this.message = "";
        this.fetch();
      } catch(error) {
        console.error(error);
      }
    },
    async fetch() {
      try {
        const response = await DiscussionService.getAll(this.page, this.perPage, this.proposal_id);
        if(response.data) {
          const responseData = response.data;
          this.discussions = responseData.data.map(discussionDTO => new Discussion(discussionDTO));
          this.page = responseData.meta.current_page;
          this.totalPages = responseData.meta.last_page;
        }
      } catch(error) {
        console.error(error);
      }
    }
  }
});
</script>

<style lang="scss" scoped>
  .discussions {
    max-height: 350px;
    overflow-y: auto;
  }
  .message-box {
    padding: 1rem 0 0;
  }
</style>
  