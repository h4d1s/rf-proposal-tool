<template>
  <div class="pricing-table">
    <SelectServiceTemplate
      ref="selectServiceTemplate"
      @template-chosen="onPickTemplate"
    />
    <div class="form-row form-inline justify-content-md-end mb-3">
      <div class="form-group col-auto">
        <button
          class="btn btn-sm btn-primary"
          @click.prevent="onAddServiceTemplate">
          Add Service Template
        </button>
      </div>
      <div class="form-group col-auto">
        <button
          class="btn btn-sm btn-primary"
          @click.prevent="onAdd">
          Add Item
        </button>
      </div>
    </div>
    <div class="table table-services">
      <div class="row">
        <div class="th col-1"></div>
        <div class="th col cell name">Name</div>
        <div class="th col cell quantity">Quantity</div>
        <div class="th col cell price">Price</div>
        <div class="th col cell unit">Unit</div>
        <div class="th col cell total">Total</div>
        <div class="th col"></div>
      </div>
      <div v-for="(item, index) in items" :key="index" v-if="items.length">
        <PricingTableRow>
          <template #first-row="{ onToggle, isActive }">
            <div class="row">
              <div class="td cell col-1">
                <a href="#" @click.prevent="onToggle" class="toggle" :class="{ 'is-active': isActive }">
                  <i class="fa-solid fa-chevron-down"></i>
                </a>
                <input type="hidden" :name="'pricing_table['+ index +'][id]'" :value="item.id">
              </div>
              <div class="td cell col-12 col-sm name">
                <input
                  type="text"
                  placeholder="Name"
                  :value="item.name"
                  @change="onChange(index, 'name', $event.target.value)"
                  :name="'pricing_table['+ index +'][name]'"
                />
              </div>
              <div class="td cell col-12 col-sm quantity">
                <input
                  type="text"
                  :value="item.qty"
                  @change="onChange(index, 'qty', $event.target.value)"
                  :name="'pricing_table['+ index +'][qty]'"
                />
              </div>
              <div class="td cell col-12 col-sm price">
                <input
                  type="text"
                  :value="item.price"
                  @change="onChange(index, 'price', $event.target.value)"
                  :name="'pricing_table['+ index +'][price]'"
                />
              </div>
              <div class="td cell col unit">
                <input
                  type="text"
                  :value="item.unit"
                  @change="onChange(index, 'unit', $event.target.value)"
                  :name="'pricing_table['+ index +'][unit]'"
                />
              </div>
              <div class="td cell col-12 col-sm total">
                {{ currency }}{{ calculateItemTotal(index) }}
              </div>
              <div class="td cell actions col-12 col-sm">
                <a href="#" @click.prevent="onDelete(index)">
                  <i class="fa-solid fa-trash-can"></i>
                </a>
              </div>
            </div>
          </template>
          <template #second-row>
            <div class="row row-secondary">
              <div class="td col-1"></div>
              <div class="td cell col-11 col-sm">
                <textarea
                  placeholder="Enter description"
                  class="form-control"
                  :name="'pricing_table['+ index +'][description]'"
                >{{ item.description }}</textarea>
              </div>
            </div>
          </template>
        </PricingTableRow>
      </div>
      <div class="row" v-else>
        <div class="col-12 text-center p-4">
          No services, <a href="#" @click.prevent="onAdd">add new</a> one.
        </div>
      </div>
      <div class="row justify-content-end" v-if="items.length">
        <div class="td col-12 col-sm-8"></div>
        <div class="td col font-weight-bold">Total</div>
        <div class="td col font-weight-bold">{{ currency }}{{ total }}</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRaw } from "vue";
import { PriceTableItemDTO, PriceTableItem } from "../../models/PricingTableItem";
import PricingTableItemService from "../../services/PricingTableItemService";
import SelectServiceTemplate from "../SelectServiceTemplate.vue";
import ServiceTemplate from "../../models/ServiceTemplate";
import PricingTableRow from "./PricingTableRow.vue";
import * as _ from "lodash";

export default defineComponent({
  data() {
    return {
      items: [] as PriceTableItem[]
    }
  },
  props: {
    id: {
      type: Number
    },
    currency: {
      type: String
    }
  },
  async mounted() {
    this.fetch();
  },
  components: {
    PricingTableRow,
    SelectServiceTemplate
  },
  computed: {
    total() {
      const total = _.sum(this.items.map((service, index) => Number(this.calculateItemTotal(index))));
      return total.toFixed(2);
    }
  },
  methods: {
    async fetch() {
      try {
        const response = await PricingTableItemService.get(this.id);
        if(response.data) {
          const responseData = response.data;
          this.items = responseData.data.map(pricingTableItemDTO => new PriceTableItem(pricingTableItemDTO));
        }
      } catch(error) {
        console.error(error);
      }
    },
    onAdd() {
      const newPriceTableItemDTO = new PriceTableItemDTO();
      const newPriceTableItem = new PriceTableItem(newPriceTableItemDTO);
      this.items.push(newPriceTableItem);
    },
    onAddServiceTemplate() {
      const selectServiceTemplate = this.$refs.selectServiceTemplate as typeof SelectServiceTemplate;
      selectServiceTemplate.openModal();
    },
    async onDelete(index: number) {
      const item = this.items.find((item, i) => i === index);
      if(item.id === 0) {
        this.items = this.items.filter((item, i) => i !== index);
        return;
      }
      
      try {
        await PricingTableItemService.delete(item.id);
      } catch(error) {
        console.error(error);
      }
      this.items = this.items.filter((item, i) => i !== index);
    },
    onChange(index: number, prop: string, value) {
      this.items[index][prop] = value;
    },
    calculateItemTotal(index: number) {
      const item = this.items[index];
      const total = item.qty * item.price;
      return total.toFixed(2);
    },
    onPickTemplate(template: ServiceTemplate) {
      const items = toRaw(template.services.map(item => { 
        item.id = 0;
        return item;
      }));
      this.items.push(...items);
    },
  }
});
</script>

<style lang="scss" scoped>
.table-services {
  tbody {
    tr:hover {
      background-color: rgba(0, 0, 0, 0.05);
    }
  }
  tfoot td {
    border-top: 2px solid #efefef;
  }
  .cell {
    &:hover {
      input,
      textarea {
        border: 1px solid #ccc;
        background-color: white;
      }
    }
  }
  textarea,
  input {
    width: 100%;
    border: 1px solid transparent;
    background: none;
    transition: .3s all;
    box-shadow: none;
    padding: 2px;
  }
  .cell .toggle i {
    transition: .3s all;
  }
  .cell .toggle.is-active i {
    transform: rotate(-180deg);
  }
}
</style>
