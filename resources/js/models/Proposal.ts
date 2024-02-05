export interface IProposal {
  id: number;
  name: string;
  price: string;
  images: string;
}

export class ProposalDTO implements IProposal {
  id: number = 0;
  name: string = "";
  price: string = "";
  images: string = "";
}

export default class Proposal extends ProposalDTO {
  constructor(dto: ProposalDTO){
    super();
    Object.assign(this, dto);
  }
};
