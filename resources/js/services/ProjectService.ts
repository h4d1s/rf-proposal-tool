import axios from "axios";
import * as _ from "lodash";
import IRequest from "../models/Request";
import Project, { ProjectDTO } from "../models/Project";

export default {

  get(id) {
    return axios.get<IRequest<ProjectDTO[]>>(`/ajax/projects/${id}`, {});
  },

  getAll(page = 1, perPage = 6) {
    return axios.get<IRequest<ProjectDTO[]>>("/ajax/projects/", {
      params: {
        page,
        per_page: perPage
      }
    });
  },

  search(q) {
    return axios.get<IRequest<ProjectDTO[]>>('/ajax/search/projects', {
      params: {
        q
      }
    });
  }
}
