export {};
import {showFieldValid, showFieldError} from '../../util/forms';

const form = document.querySelector<HTMLFormElement>('.js-form-login');
const emailInput = form?.querySelector<HTMLInputElement>('input[name="email"]');
const emailError = emailInput?.closest<HTMLDivElement>('.input-group')?.querySelector<HTMLDivElement>('.invalid-feedback');
const passwordInput = form?.querySelector<HTMLInputElement>('input[name="password"]');
const passwordError = passwordInput?.closest<HTMLDivElement>('.input-group')?.querySelector<HTMLDivElement>('.invalid-feedback');
const rememberCheckbox = form?.querySelector<HTMLInputElement>('input[name="remember"]');

const isFormValid = () => {
  return !(
    emailInput?.validity.valid ||
    passwordInput?.validity.valid
  );
};

const validateEmailInput = () => {
    if (emailInput?.validity.valid) {
        showFieldValid(emailInput, emailError);
    } else {
        showFieldError(emailInput, emailError);
    }
};
const validatePasswordInput = () => {
    if (passwordInput?.validity.valid) {
        showFieldValid(passwordInput, passwordError);
    } else {
        showFieldError(passwordInput, passwordError);
    }
};

emailInput?.addEventListener('input', () => {
  validateEmailInput();
});
passwordInput?.addEventListener('input', () => {
  validatePasswordInput();
});

rememberCheckbox?.addEventListener('change', function (this: HTMLInputElement, e: Event) {
  this.value = this.checked ? "1" : "0";
});

form?.addEventListener('submit', function (this: HTMLFormElement, e: Event) {
  e.stopPropagation();
  e.preventDefault();

  validateEmailInput();
  validatePasswordInput();

  if (isFormValid()) {
      return;
  }

  this.submit();
});