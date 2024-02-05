export {};
import flatpickr from "flatpickr";
import rangePlugin from "flatpickr/dist/plugins/rangePlugin";

const form = document.querySelector<HTMLFormElement>('.js-form-proposals');
const checkboxStates = document.querySelectorAll<HTMLInputElement>(".js-checkbox-state");
const checkboxToggleAll = document.querySelector<HTMLInputElement>(".js-checkbox-toggle-all");
const checkboxSelectRow = document.querySelectorAll<HTMLInputElement>(".js-checkbox-select-row");

checkboxStates.forEach((checkbox) => {
  checkbox.addEventListener("change", function (this: HTMLInputElement, e: Event) {
    e.preventDefault();
    
    checkbox.removeEventListener("click", () => {}, {});
    
    checkboxStates.forEach((s) => {
      s.removeEventListener("change", () => {}, {});
    });
  
    form?.submit();
  });
});

checkboxToggleAll?.addEventListener("change", function (this: HTMLInputElement, e: Event) {
  e.preventDefault();

  const cToggleAll = this;

  checkboxSelectRow.forEach((c) => {
    c.checked = cToggleAll.checked;
  });
});

flatpickr('input[name="date_from"]', {
  'maxDate': Date.now(),
  'plugins': [rangePlugin({ input: 'input[name="date_to"]'})],
});