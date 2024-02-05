<template>
  <div class="rf-products-gallery">
    <p
      class="text-center"
      v-if="errored && !loading">
      Server Error. Please try again.
    </p>

    <div
      v-if="loading"
      class="is-loading is-loading-lg"></div>

    <p
      class="text-center py-4 m-0"
      v-if="!errored && !hasItems && !loading">
      No items to show
    </p>

    <div
      class="row row-cols-1 row-cols-sm-2 row-cols-md-3 w-100"
      v-if="hasItems && !loading">
      <ProductItem
        v-for="(item, index) in items"
        :currency="currency"
        :item="item"
        :key="index"
        :selected="isSelected(item.id)"
        :selectable="selectable"
        @select="onSelectItem"
      />
    </div>
  </div>

  <nav
    class="d-flex flex-row align-items-center w-100"
    v-if="hasItems && !loading">
    <div class="mr-auto">
      <a href="#" class="btn icon-muted" @click.prevent="back" :class="{ 'disabled': isFirstPage }">
        <i class="material-icons float-left">arrow_backward</i>
      </a>
    </div>

    <div class="ml-auto">
      <span>{{ current_page }}</span>
      <span class="text-muted">
        of <span>{{ total_pages }}</span>
      </span>
      <a href="#" class="btn icon-muted" @click.prevent="next" :class="{ 'disabled': isLastPage }">
        <i class="material-icons float-right">arrow_forward</i>
      </a>
    </div>
  </nav>

  <input
    type="hidden"
    name="products[]"
    v-for="(id, index) in selectedIds"
    :value="id"
    :key="index"
  />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ProductItem from "./ProductItem.vue";
import Product from "../../models/Product";

export default defineComponent({
  inheritAttrs: false,
  emits: [
    'paginate',
    'change'
  ],
  components: {
    ProductItem
  },
  props: {
    currency: {
      type: String
    },
    selected: {
      type: Array
    },
    selectable: {
      type: Boolean
    },
    isLoading: {
      type: Boolean
    },
    paginate: {
      type: Function
    },
    products: {
      type: Array
    },
    currentPage: {
      type: Number
    },
    totalPages: {
      type: Number
    },
    errored: {
      type: Boolean
    }
  },
  data() {
    return {
      loading: true,
      items: [] as Product[],
      current_page: 1 as number,
      total_pages: 1 as number,
      selectedIds: [] as number[],
    };
  },
  created() {
    this.selectedIds = this.selected || [];
    this.current_page = this.currentPage;
    this.total_pages = this.totalPages;
    this.items = this.products;
    this.loading = this.isLoading;
  },
  mounted() {
    this.$watch(
      (vm) => [vm.items, vm.current_page, vm.total_pages],
      (val: Array<any>) => {
        if(!val.includes(null) || !val.includes(undefined)) {
          this.loading = false;
        }
      }, {
        immediate: true,
        deep: true,
    });
  },
  computed: {
    isFirstPage(): boolean {
      return this.current_page === 1;
    },
    isLastPage(): boolean {
      return this.current_page === this.total_pages;
    },
    hasItems(): boolean {
      if(!this.items) {
        return false;
      }
      return (this.items as Product[]).length !== 0;
    }
  },
  watch: {
    products: function(newVal, oldVal) {
      this.items = newVal;
    },
    currentPage: function(newVal, oldVal) {
      this.current_page = newVal;
    },
    totalPages: function(newVal, oldVal) {
      this.total_pages = newVal;
    },
    isLoading: function(newVal, oldVal) {
      this.loading = newVal;
    }
  },
  methods: {
    back() {
      if(this.isFirstPage) {
        return;
      }

      this.current_page--;
      this.loading = true;
      this.$emit("paginate", this.current_page);
    },
    next() {
      if (this.isLastPage) {
        return;
      }

      this.current_page++;
      this.loading = true;
      this.$emit("paginate", this.current_page);
    },
    isSelected(id: number) {
      return this.selectedIds.includes(id);
    },
    onSelectItem(id: number, selected: boolean) {
      if(selected) {
        this.selectedIds.push(id);
      } else {
        this.selectedIds = this.selectedIds.filter(selectedId => selectedId !== id);
      }
      this.$emit("change", this.selectedIds);
    }
  },
});
</script>
