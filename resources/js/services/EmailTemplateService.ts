import axios from "axios";
import IRequest from "../models/Request";
import EmailTemplate, { EmailTemplateDTO } from "../models/EmailTemplate";

export default {
  get(id: number) {
    return axios.get<IRequest<EmailTemplateDTO>>(`/ajax/email-templates/${id}`);
  },

  search(q) {
    return axios.get<IRequest<EmailTemplateDTO[]>>('/ajax/search/email-templates/', {
      params: {
        q
      }
    });
  }
}
