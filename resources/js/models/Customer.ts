export interface ICustomer {
  id: number;
  name: string;
  type: string;
  email: string;
}

export class CustomerDTO implements ICustomer {
  id: number = 0;
  name: string = "";
  type: string = "";
  email: string = "";
}

export default class Customer extends CustomerDTO {
  constructor(dto: CustomerDTO){
    super();
    dto.type = dto.type.split("\\").pop() || "";
    Object.assign(this, dto);
  }
};
