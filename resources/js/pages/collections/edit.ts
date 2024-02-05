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
      errored: false,
      isLoading: true,
      products: [] as Product[],
      currentPage: 1,
      totalPages: 1,
      selectedIds: [] as number[]
    };
  },
  created() {
    this.selectedIds = INCLUDE_IDS;

    this.onPaginate();
  },
  methods: {
    async onPaginate(page = 1) {
      this.isLoading = true;

      try {
        const response = await ProductService.getAll(page);
        if(response && response.data) {
          this.products = response.data.data.map(productDTO => new Product(productDTO));
          this.currentPage = response.data.meta.current_page;
          this.totalPages = response.data.meta.last_page;
        }
      } catch {
        this.errored = true;
      }

      this.isLoading = false;
    }
  }
});
app.component("gallery-products", GalleryProducts);
app.mount("#gallery-products");