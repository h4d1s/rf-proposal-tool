import axios from "axios";
import IRequest from "../models/Request";
import Proposal, { ProposalDTO } from "../models/Proposal";

export default {
  get(id) {
    return axios.get<IRequest<ProposalDTO[]>>(`/ajax/proposals/${id}`, {});
  },

  getAll(page = 1, perPage = 10) {
    return axios.get<IRequest<ProposalDTO[]>>("/ajax/proposals/", {
      params: {
        page,
        per_page: perPage
      }
    });
  },

  search(q) {
    return axios.get<IRequest<ProposalDTO[]>>('/ajax/search/proposals/', {
      params: {
        q
      }
    });
  }
}
