import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { PriceTableItemDTO } from "../models/PricingTableItem";

export default {
  get(pricing_table_id: number) {
    return axios.get<IRequest<PriceTableItemDTO[]>>('/ajax/pricing-table-items/', {
      params: {
        pricing_table_id
      }
    });
  },
  
  delete(id: number) {
    return axios.delete<IRequest<PriceTableItemDTO[]>>(`/ajax/pricing-table-items/${id}`);
  },
};
