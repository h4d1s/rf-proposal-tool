<template>
  <div class="row mb-5">
    <div class="col-12 mb-3">
      <h5>Selected Products</h5>
    </div>
    <div class="col-12 mb-4">
      <div class="rf-items-sm">
        <gallery-products
          ref="gallerySelectedProducts"
          :currency="currency"
          :selectable="true"
          :current-page="selectedProducts.currentPage"
          :total-pages="selectedProducts.totalPages"
          :products="selectedProducts.products"
          :errored="selectedProducts.errored"
          :is-loading="selectedProducts.isLoading"
          @change="onChangeSelectedProducts"
          @paginate="onPaginateSelectedProducts"
        />
      </div>
    </div>
    <div class="form-row col-12 justify-content-end">
      <div class="col-auto">
        <button
          ref="btnAddNewProducts"
          class="btn btn-primary"
          :class="{ 'disabled': showProducts }"
          @click.prevent="onAddNewProducts">
          Add new products
        </button>
      </div>
      <div class="col-auto">
        <a
          href="#"
          ref="btnDeleteSelectedProducts"
          class="btn btn-primary"
          :class="{ 'disabled': !this.selectedProducts.selected.length }"
          @click.prevent="onDeleteSelectedProducts">
          Delete selected products
        </a>
      </div>
    </div>
  </div>
  
  <input type="hidden" name="products[]" v-for="item in selectedProducts.products" :value="item.id" />

  <template v-if="showProducts">
    <div class="row mb-5">
      <div class="col-12">
        <h5 class="mb-3">Products</h5>
      </div>
      <div class="col-12 mb-3">
        <div class="rf-items-sm">
          <gallery-products
            ref="galleryProducts"
            :currency="currency"
            :selectable="true"
            :is-loading="products.isLoading"
            :current-page="products.currentPage"
            :total-pages="products.totalPages"
            :products="products.products"
            :errored="products.errored"
            @change="onChangeProducts"
            @paginate="onPaginateProducts"
          />
        </div>
      </div>
      <div class="col-12 text-center">
        <div class="form-row justify-content-end">
          <div class="col-auto">
            <a
              href="#"
              ref="btnProductsAddSelectedProducts"
              class="btn btn-secondary"
              :class="{ 'disabled': !this.products.selected.length }"
              @click.prevent="onProductsAddSelectedProducts">
              Add selected products
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <h5 class="mb-3">Collections</h5>
      </div>
      <div class="col-12">
        <vue-select
          label="name"
          :filterable="false"
          :options="collections"
          @search="onSearch"
          @option:selected="onOptionSelected">
          <template #no-options="{ search, searching }">
            <template v-if="searching">
              No results found for <em>{{ search }}</em>.
            </template>
            <template v-else>type to search collections..</template>
          </template>
          <template #option="option">
            {{ option.name }}
          </template>
          <template #selected-option="option">
            <div class="selected d-center">
              {{ option.name }}
            </div>
          </template>
        </vue-select>
      </div>
    </div>
  </template>

  <div class="row" v-if="showCollections">
    <div class="col-12 my-4">
      <div class="rf-items-sm">
        <gallery-products
          ref="galleryProductsCollections"
          :currency="currency"
          :selectable="true"
          :selected="productsCollections.selected"
          :is-loading="productsCollections.isLoading"
          :current-page="productsCollections.currentPage"
          :total-pages="productsCollections.totalPages"
          :products="productsCollections.products"
          :errored="productsCollections.errored"
          @change="onChangeProductsCollections"
          @paginate="onPaginateCollections"
        />
      </div>
    </div>
    <div class="col-12 text-center">
      <div class="form-row justify-content-end">
        <div class="col-auto">
          <button
            class="btn btn-secondary"
            :class="{ 'disabled': !this.productsCollections.selected.length }"
            ref="btnCollectionsAddSelectedProducts"
            @click.prevent="onCollectionsAddSelectedProducts">
            Add selected products
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import * as _ from "lodash";
import { defineComponent } from "vue";
import VueSelect from 'vue-select';
import GalleryProducts from "../components/GalleryProducts/GalleryProducts.vue";
import ProductService from "../services/ProductService";
import CollectionService from "../services/CollectionService";
import Product from "../models/Product";
import Collection from "../models/Collection";

export default defineComponent({
  components: {
    GalleryProducts,
    VueSelect
  },
  props: {
    attributeProducts: {
      type: Array
    },
    currency: {
      type: String
    }
  },
  data() {
    return {
      showProducts: false,
      showCollections: false,

      selectedProducts: {
        products: [] as Product[],
        selected: [],
        includeIds: [],
        currentPage: 0,
        totalPages: 0,
        isLoading: true,
        errored: false,
      },

      products: {
        products: [] as Product[],
        selected: [],
        excludeIds: [],
        currentPage: 0,
        totalPages: 0,
        isLoading: true,
        errored: false,
      },

      collections: [] as Collection[],
      productsCollections: {
        products: [] as Product[],
        selected: [],
        currentPage: 0,
        totalPages: 0,
        isLoading: true,
        errored: false,
      }
    };
  },
  created() {
    this.selectedProducts.includeIds = this.attributeProducts;
    this.onPaginateSelectedProducts();
  },
  methods: {
    async onPaginateSelectedProducts(page = 1) {
      this.selectedProducts.isLoading = true;
      const includeIds = this.selectedProducts.includeIds;
      
      try {
        const response = await ProductService.getAllWithInclude(page, 3, includeIds);
        if(response.data) {
          this.selectedProducts.products = response.data.data.map(productDTO => new Product(productDTO));
          this.selectedProducts.currentPage = response.data.meta.current_page;
          this.selectedProducts.totalPages = response.data.meta.last_page;
        }
      } catch {
        this.selectedProducts.errored = true;
      }

      this.selectedProducts.isLoading = false;
    },
    async onPaginateProducts(page = 1) {
      this.products.isLoading = true;
      const excludeIds = this.products.excludeIds;
      
      try {
        const response = await ProductService.getAllWithExclude(page, 3, excludeIds);
        if(response.data) {
          this.products.products = response.data.data.map(productDTO => new Product(productDTO));
          this.products.currentPage = response.data.meta.current_page;
          this.products.totalPages = response.data.meta.last_page;
        }
      } catch {
        this.products.errored = true;
      }

      this.products.isLoading = false;
    },
    async onPaginateCollections(page = 1) {
      this.productsCollections.isLoading = true;

      try {
        const response = await CollectionService.getAll(page);
        if(response.data) {
          this.productsCollections.products = response.data.data.flatMap((collectionDTO) => collectionDTO.products);
          this.productsCollections.currentPage = response.data.meta.current_page;
          this.productsCollections.totalPages = response.data.meta.last_page;
        }
      } catch {
        this.productsCollections.errored = true;
      }

      this.productsCollections.isLoading = false;
    },
    onAddNewProducts() {
      this.onPaginateProducts();
      this.showProducts = true;
    },
    onProductsAddSelectedProducts() {
      const refProducts = this.$refs.galleryProducts as typeof GalleryProducts;

      this.selectedProducts.includeIds = _.union(this.selectedProducts.includeIds, refProducts.selectedIds);
      this.products.excludeIds = _.union(this.products.excludeIds, refProducts.selectedIds);

      refProducts.selectedIds = [];

      this.showProducts = false;
      this.showCollections = false;

      this.onPaginateSelectedProducts();
      this.onPaginateProducts();
    },
    onDeleteSelectedProducts() {
      const refSelectedProducts = this.$refs.gallerySelectedProducts as typeof GalleryProducts;

      this.selectedProducts.includeIds = _.difference(this.selectedProducts.includeIds, refSelectedProducts.selectedIds);
      this.products.excludeIds = _.difference(this.products.excludeIds, refSelectedProducts.selectedIds);

      this.selectedProducts.selected = [];
      refSelectedProducts.selectedIds = [];

      this.onPaginateSelectedProducts();
      this.onPaginateProducts();
    },
    onCollectionsAddSelectedProducts() {
      this.showProducts = false;
      this.showCollections = false;

      const refProducts = this.$refs.galleryProductsCollections as typeof GalleryProducts;

      this.selectedProducts.includeIds = _.union(this.selectedProducts.includeIds, refProducts.selectedIds);
      this.products.excludeIds = _.union(this.products.excludeIds, refProducts.selectedIds);

      refProducts.selectedIds = [];

      this.onPaginateSelectedProducts();
      this.onPaginateProducts();
    },
    onChangeSelectedProducts(selectedIds) {
      this.selectedProducts.selected = selectedIds;
    },
    onChangeProducts(selectedIds) {
      this.products.selected = selectedIds;
    },
    onChangeProductsCollections(selectedIds) {
      this.productsCollections.selected = selectedIds;
    },
    onSearch(search, loading) {
      if(search.length) {
        loading(true);
        this.search(loading, search, this);
      }
    },
    search: _.debounce(async (loading, q, vm) => {
      try {
        const response = await CollectionService.search(q);
        loading(false);
        if(response.data) {
          const responseData = response.data;
          vm.collections = responseData.data.map(collectionDTO => new Collection(collectionDTO));
        }
      } catch {
        vm.productsCollections.errored = true;
      }
    }, 300),
    async onOptionSelected(option) {
      try {
        const response = await ProductService.getAllFromCollection(1, 3, option.id);
        if(response.data) {
          const responseData = response.data;
          this.productsCollections.products = responseData.data.map(productDTO => new Product(productDTO));
          this.productsCollections.currentPage = responseData.meta.current_page;
          this.productsCollections.totalPages = responseData.meta.last_page;
          this.productsCollections.selected = this.selectedProducts.includeIds;

          this.showCollections = true;
        }
      } catch {
        this.productsCollections.errored = true;
      }
    }
  }
});
</script>
