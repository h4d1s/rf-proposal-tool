export interface IEmailTemplate {
  id: number;
  name: string;
  subject: string;
  body: string;
}

export class EmailTemplateDTO implements IEmailTemplate {
  id: number = 0;
  name: string = "";
  subject: string = "";
  body: string = "";
}

export default class EmailTemplate extends EmailTemplateDTO {
  constructor(dto: EmailTemplateDTO){
    super();
    Object.assign(this, dto);
  }
};
