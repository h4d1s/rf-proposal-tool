export interface IClient {
  id: number;
  title: string;
  first_name: string;
  last_name: string;
  email: string;
  company: string;
  description: string;
}

export class ClientDTO implements IClient {
  id: number = 0;
  title: string = "";
  first_name: string = "";
  last_name: string = "";
  email: string = "";
  company: string = "";
  description: string = "";
}

export default class Client extends ClientDTO {
  constructor(dto: ClientDTO){
    super();
    Object.assign(this, dto);
  }
};
