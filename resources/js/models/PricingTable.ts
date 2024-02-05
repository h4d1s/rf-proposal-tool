export interface IPriceTableItem {
  id: number;
  name: string;
}

export class PriceTableItemDTO implements IPriceTableItem {
  id: number = 0;
  name: string = "";
}

export class PriceTableItem extends PriceTableItemDTO {
  constructor(dto: PriceTableItemDTO) {
      super();

      Object.assign(this, dto);
  }
}