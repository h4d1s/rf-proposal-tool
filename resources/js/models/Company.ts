export interface ICompany {
  id: number;
  name: string;
  phone: string;
  email: string;
}

export class CompanyDTO implements ICompany {
  id: number = 0;
  name: string = "";
  phone: string = "";
  email: string = "";
}

export default class Company extends CompanyDTO {
  constructor(dto: CompanyDTO){
    super();
    Object.assign(this, dto);
  }
};
