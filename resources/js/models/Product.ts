export interface IProduct {
  id: number;
  name: string;
  price: string;
  images: string;
}

export class ProductDTO implements IProduct {
  id: number = 0;
  name: string = "";
  price: string = "";
  images: string = "";
}

export default class Product extends ProductDTO {
  constructor(dto: ProductDTO){
    super();
    Object.assign(this, dto);
  }
};
