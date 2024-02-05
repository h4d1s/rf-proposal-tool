import Product from "./Product";

export interface ICollection {
  id: number;
  name: string;
  description: string;
  products: Product[];
}

export class CollectionDTO implements ICollection {
  id: number = 0;
  name: string = "";
  description: string = "";
  products: Product[] = [];
}

export default class Collection extends CollectionDTO {
  constructor(dto: CollectionDTO){
    super();
    Object.assign(this, dto);
  }
};
