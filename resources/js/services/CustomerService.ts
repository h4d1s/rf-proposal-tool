import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { CustomerDTO } from "../models/Customer";

export default {
  get(id: number, type: string) {
    return axios.get<IRequest<CustomerDTO>>(`/ajax/customers/${id}`, {
        params: {
          type: type
        }
    });
  },

  search(q = "") {
    return axios.get<IRequest<CustomerDTO[]>>('/ajax/search/customers', {
      params: {
        q
      }
    });
  }
};
