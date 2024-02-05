import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { ServiceTemplateDTO } from "../models/ServiceTemplate";

export default {
  getAll(page = 1, perPage = 10) {
    return axios.get<IRequest<ServiceTemplateDTO[]>>('/ajax/service-templates/', {
      params: {
        page,
        per_page: perPage
      }
    });
  },
};
