import axios from 'axios';
import IRequest from "../models/Request";
import * as _ from "lodash";
import { PriceTableItem } from "../models/PricingTableItem";

export default {
  get(id: number) {
    return axios.get<IRequest<PriceTableItem>>(`/ajax/pricing-tables/${id}`);
  },
};
