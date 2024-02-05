import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { CompanyDTO } from "../models/Company";

export default {
  get(id: number) {
    return axios.get<IRequest<CompanyDTO>>(`/ajax/companies/${id}`);
  },

  search(q = "") {
    return axios.get<IRequest<CompanyDTO[]>>('/ajax/search/companies', {
      params: {
        q
      }
    });
  }
};
