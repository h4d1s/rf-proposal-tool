import Service from "./Service";

export interface IServiceTemplate {
  id: number;
  name: string;
  total: number;
  services: Service[];
}

export class ServiceTemplateDTO implements IServiceTemplate {
  id: number = 0;
  name: string = "";
  total: number = 0;
  services: Service[] = [];
}

export default class ServiceTemplate extends ServiceTemplateDTO {
  constructor(dto: ServiceTemplateDTO) {
    super();

    Object.assign(this, dto);
  }
};
