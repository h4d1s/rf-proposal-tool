import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { DiscussionDTO } from "../models/Discussion";

export default {
  getAll(page = 1, perPage = 6, proposal_id: number) {
    return axios.get<IRequest<DiscussionDTO[]>>('/ajax/discussion/', {
      params: {
        page,
        per_page: perPage,
        proposal: proposal_id
      }
    });
  },

  create(message: string, proposal_id: number, customer_id: number, customer_type: string) {
    return axios.post('/ajax/discussion/', {
      message: message,
      proposal: proposal_id,
      customer: customer_id,
      customer_type: customer_type
    });
  }
};
