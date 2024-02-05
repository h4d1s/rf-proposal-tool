export const showFieldError = (inputEl, errorEl) => {
  errorEl.innerHTML = '';
  let labelEl = inputEl.closest('.form-group').querySelector('label');
  let labelText = 'Field';
  if(labelEl) {
    labelText = labelEl.textContent;
  }
  if(inputEl.validity.valueMissing) {
    labelText = labelText.toLowerCase();
    errorEl.textContent = `${labelText} is required.`;
  } else if(inputEl.validity.typeMismatch) {
    errorEl.textContent = `${labelText} is not a valid.`;
  }
  inputEl.classList.remove('is-valid');
  inputEl.classList.add('is-invalid');
};

export const showFieldValid = (inputEl, errorEl) => {
  errorEl.innerHTML = '';
  inputEl.classList.remove('is-invalid');
  inputEl.classList.add('is-valid');
};
