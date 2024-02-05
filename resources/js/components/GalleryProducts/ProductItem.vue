<template>
  <div
    class="col rf-item"
    :class="{ 'is-selected': selected, 'selectable': selectable }"
    @click="onSelect()">
    <div class="card stories-card-popular">
      <img :src="imageUrl" :alt="item.name" class="card-img" />
      <div class="stories-card-popular__content">
        <div class="stories-card-popular__title card-body text-left">
          <small class="text-muted text-uppercase">
            {{ currency }}<span>{{ item.price }}</span>
          </small>

          <h4 class="card-title m-0">
            <a :href="url">
              <span>{{ item.name }}</span>
            </a>
          </h4>
        </div>
      </div>
      <span class="rf-toggle">
        <i class="material-icons">check_circle</i>
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import Product from "../../models/Product";

export default defineComponent({
  data() {
    return {
      isSelected: false,
    }
  },
  props: {
    item: Object as PropType<Product>,
    currency: String,
    selected: Boolean,
    selectable: Boolean,
  },
  mounted() {
    this.isSelected = this.selected;
  },
  computed: {
    imageUrl(): string {
      let image = "";
      if(this.item && this.item.images) {
        const images: [string] = this.item.images;
        image = images[0] || "";
      }
      return image;
    },
    url(): String {
      let id = 0;
      if(this.item && this.item.images) {
        id = this.item.id;
      }
      return "/products/" + id;
    },
  },
  methods: {
    onSelect() {
      if(!this.selectable) {
        return;
      }
      if(this.item) {
        this.isSelected = !this.isSelected;
        this.$emit("select", this.item.id, this.isSelected);
      }
    }
  }
});
</script>
