export {};
import { createApp } from 'vue';
import ProductService from "../../services/ProductService";
import GalleryProducts from "../../components/GalleryProducts/GalleryProducts.vue";
import Product from '../../models/Product';

declare global {
  var INCLUDE_IDS: Number[];
}

const app = createApp({
  data() {
    return {
      loading: true,
      errored: false,
      products: [],
      currentPage: 0,
      totalPages: 0,
      selectedIds: []
    };
  },
  created() {
    this.selectedIds = INCLUDE_IDS;

    this.onPaginate();
  },
  methods: {
    async onPaginate(page = 1) {
      this.loading = true;

      try {
        const { data } = await ProductService.getAllWithInclude(page, 3, INCLUDE_IDS);
        if(data) {
          this.products = data.data.map(productDTO => new Product(productDTO));
          this.currentPage = data.meta.current_page;
          this.totalPages = data.meta.last_page;
        }
      } catch {
        this.errored = true;
      }

      this.loading = false;
    },
  }
});
app.component('gallery-products', GalleryProducts);
app.mount('#gallery-products');
