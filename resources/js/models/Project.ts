export interface IProject {
  id: number;
  name: string;
}

export class ProjectDTO implements IProject {
  id: number = 0;
  name: string = "";
}

export default class Project extends ProjectDTO {
  constructor(dto: ProjectDTO){
    super();
    Object.assign(this, dto);
  }
};
