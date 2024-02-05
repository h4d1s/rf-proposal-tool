export interface IService {
  id: number;
  created_at: string;
  name: string;
  description: string;
  unit: string;
  price: number;
}

export class ServiceDTO implements IService {
  id: number = 0;
  created_at = "";
  name: string = "";
  description: string = "";
  unit: string = "";
  price: number = 0;
}

export default class Service extends ServiceDTO {
  constructor(dto: ServiceDTO) {
    super();

    Object.assign(this, dto);
  }
}
