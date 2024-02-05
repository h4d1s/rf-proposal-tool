export interface IDiscussion {
  id: number;
  body: string;
  owner_name: string;
  owner_type: string;
}

export class DiscussionDTO implements IDiscussion {
  id: number = 0;
  body: string = "";
  owner_name: string = "";
  owner_type: string = "";
}

export default class Discussion extends DiscussionDTO {
  constructor(dto: DiscussionDTO){
    super();
    Object.assign(this, dto);
  }
};
