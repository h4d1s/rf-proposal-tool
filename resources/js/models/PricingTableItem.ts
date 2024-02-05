export interface IPriceTableItem {
  id: number;
  name: string;
  description: string;
  qty: number;
  price: number;
  unit: string;
}

export class PriceTableItemDTO implements IPriceTableItem {
  id: number = 0;
  name: string = "";
  description: string = "";
  qty: number = 0;
  price: number = 0;
  unit: string = "";
}

export class PriceTableItem extends PriceTableItemDTO {
  constructor(dto: PriceTableItemDTO) {
      super();

      Object.assign(this, dto);
  }
}