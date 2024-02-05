import axios from 'axios';
import IRequest from "../models/Request";
import { ProductDTO } from "../models/Product";

export default {
  get(id: Number) {
    return axios.get(`/ajax/products/${id}`);
  },

  getAll(page = 1, perPage = 6) {
    return axios.get<IRequest<ProductDTO[]>>('/ajax/products/', {
      params: {
        page,
        per_page: perPage
      }
    });
  },

  getAllFromCollection(page = 1, perPage = 6, collection_id: number) {
    return axios.get<IRequest<ProductDTO[]>>('/ajax/products/', {
      params: {
        page,
        per_page: perPage,
        collection: collection_id
      }
    });
  },

  getAllWithExclude(page = 1, perPage = 6, exclude = [0] as Number[]) {
    if(exclude.length === 0) {
      exclude = [0];
    }

    return axios.get<IRequest<ProductDTO[]>>('/ajax/products/', {
      params: {
        page,
        per_page: perPage,
        exclude: exclude
      }
    });
  },

  getAllWithInclude(page = 1, perPage = 6, include = [0] as Number[]) {
    if(include.length === 0) {
      include = [0];
    }

    return axios.get<IRequest<ProductDTO[]>>("/ajax/products/", {
      params: {
        page,
        per_page: perPage,
        include: include
      }
    });
  },
};
