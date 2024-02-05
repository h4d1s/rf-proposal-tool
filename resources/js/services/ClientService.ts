import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { ClientDTO } from "../models/Client";

export default {
  get(id: number) {
    return axios.get<IRequest<ClientDTO>>(`/ajax/clients/${id}`);
  },

  getAll(page = 1, perPage = 6) {
    return axios.get<IRequest<ClientDTO[]>>('/ajax/clients/', {
      params: {
        page,
        per_page: perPage
      }
    });
  },

  search(q = "") {
    return axios.get<IRequest<ClientDTO[]>>('/ajax/search/clients', {
      params: {
        q
      }
    });
  }
};
