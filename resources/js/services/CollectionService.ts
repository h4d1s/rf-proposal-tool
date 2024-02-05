import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { CollectionDTO } from "../models/Collection";

export default {
  getAll(page = 1, perPage = 6) {
    return axios.get<IRequest<CollectionDTO[]>>('/ajax/collections/', {
      params: {
        page,
        per_page: perPage
      }
    });
  },

  search(q = "") {
    return axios.get<IRequest<CollectionDTO[]>>('/ajax/search/collections', {
      params: {
        q
      }
    });
  }
};
