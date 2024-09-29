// registration-validation.js

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form');
  const submitButton = document.getElementById('submitRegister');

  submitButton.addEventListener('click', validateForm);

  function validateForm(event) {
    event.preventDefault();
    let isValid = true;

    // Regular expressions for validation
    const nameRegex = /^[a-zA-Z]{2,30}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

    // Validation functions
    function validateField(fieldId, regex, errorMessage) {
      const field = document.getElementById(fieldId);
      const value = field.value.trim();
      if (!regex.test(value)) {
        showError(field, errorMessage);
        isValid = false;
      } else {
        clearError(field);
      }
    }

    function showError(field, message) {
      const errorElement = field.nextElementSibling;
      if (!errorElement || !errorElement.classList.contains('error-message')) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = 'red';
        error.textContent = message;
        field.parentNode.insertBefore(error, field.nextSibling);
      } else {
        errorElement.textContent = message;
      }
    }

    function clearError(field) {
      const errorElement = field.nextElementSibling;
      if (errorElement && errorElement.classList.contains('error-message')) {
        errorElement.remove();
      }
    }

    // Validate each field
    validateField('username', nameRegex, 'Please enter a valid first name');
    validateField('email', emailRegex, 'Please enter a valid email address');
    validateField('password', passwordRegex, 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character');

    // Confirm password validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    if (password.value !== confirmPassword.value) {
      showError(confirmPassword, 'Passwords do not match');
      isValid = false;
    } else {
      clearError(confirmPassword);
    }

    // Terms and conditions validation
    const terms = document.getElementById('terms');
    if (!terms.checked) {
      showError(terms, 'You must agree to the terms and conditions');
      isValid = false;
    } else {
      clearError(terms);
    }

    if (isValid) {
      alert('Form submitted successfully!');
      // You can submit the form here if all validations pass
      // form.submit();
    }
  }
});
