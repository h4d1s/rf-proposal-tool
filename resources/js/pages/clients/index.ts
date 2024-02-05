export {};

const checkboxToggleAll = document.querySelector<HTMLInputElement>(".js-checkbox-toggle-all");
const checkboxSelectRow = document.querySelectorAll<HTMLInputElement>(".js-checkbox-select-row");

checkboxToggleAll?.addEventListener("change", function (this: HTMLInputElement, e: Event) {
  e.preventDefault();

  const cToggleAll = this;

  checkboxSelectRow.forEach((c) => {
    c.checked = cToggleAll.checked;
  });
});