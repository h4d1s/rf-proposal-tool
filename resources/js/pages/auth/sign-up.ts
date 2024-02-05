export {};
import {showFieldValid, showFieldError} from '../../util/forms';

const form = document.querySelector<HTMLFormElement>('.js-form-sign-up');

const usernameInput = form?.querySelector<HTMLInputElement>('input[name="username"]');
const usernameError = usernameInput?.closest<HTMLDivElement>('.input-group')?.querySelector<HTMLFormElement>('.invalid-feedback');
const emailInput = form?.querySelector<HTMLInputElement>('input[name="email"]');
const emailError = emailInput?.closest<HTMLDivElement>('.input-group')?.querySelector<HTMLDivElement>('.invalid-feedback');
const passwordInput = form?.querySelector<HTMLInputElement>('input[name="password"]');
const passwordError = passwordInput?.closest<HTMLDivElement>('.input-group')?.querySelector<HTMLDivElement>('.invalid-feedback');
const termsCheckbox = form?.querySelector<HTMLInputElement>('input[name="terms"]');

const isFormValid = () => {
  return !(
    usernameInput?.validity.valid ||
    emailInput?.validity.valid ||
    passwordInput?.validity.valid
  );
};

const validateUsernameInput = () => {
  if(usernameInput?.validity.valid) {
    showFieldValid(usernameInput, usernameError);
  } else {
    showFieldError(usernameInput, usernameError);
  }
};
const validateEmailInput = () => {
  if(emailInput?.validity.valid) {
    showFieldValid(emailInput, emailError);
  } else {
    showFieldError(emailInput, emailError);
  }
};
const validatePasswordInput = () => {
  if(passwordInput?.validity.valid) {
    showFieldValid(passwordInput, passwordError);
  } else {
    showFieldError(passwordInput, passwordError);
  }
};

usernameInput?.addEventListener('input', () => {
  validateUsernameInput();
});
emailInput?.addEventListener('input', () => {
  validateEmailInput();
});
passwordInput?.addEventListener('input', () => {
  validatePasswordInput();
});

termsCheckbox?.addEventListener('change', function (this: HTMLInputElement, e: Event) {
  this.value = this.checked ? "1" : "0";
});

form?.addEventListener('submit', function (this: HTMLFormElement, e: Event) {
  e.stopPropagation();
  e.preventDefault();

  validateUsernameInput();
  validateEmailInput();
  validatePasswordInput();

  if(isFormValid()) {
    return;
  }

  this.submit();
});