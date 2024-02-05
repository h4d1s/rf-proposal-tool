export {};
import { createApp } from 'vue';
import ProductService from "../../services/ProductService";
import GalleryProducts from "../../components/GalleryProducts/GalleryProducts.vue";
import Product from '../../models/Product';

const app = createApp({
  name: 'CollectionCreate',
  data() {
    return {
      errored: false,
      isLoading: true,
      products: [] as Product[],
      currentPage: 1,
      totalPages: 1,
    };
  },
  created() {
    this.onPaginate();
  },
  methods: {
    async onPaginate(page = 1) {
      try {
        this.isLoading = true;

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