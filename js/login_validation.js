// js for login validation

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
  // Get the form element
  const loginForm = document.getElementById('loginForm');

  // Add submit event listener to the form
  loginForm.addEventListener('submit', function (event) {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Get the username and password input elements
    const usernameInput = document.getElementById('formUsername');
    const passwordInput = document.getElementById('formPassword');

    // Get the values from the inputs
    const username = usernameInput.value.trim();
    const password = passwordInput.value.trim();

    // Validate username and password
    if (validateForm(username, password)) {
      // If validation passes, submit the form
      loginForm.submit();
    }
  });

  // Function to validate the form
  function validateForm(username, password) {
    let isValid = true;

    // username validation
    if (username === '') {
      setError(usernameInput, 'Username is required');
      isValid = false;
    } else {
      setSuccess(usernameInput);
    }

    // Password validation
    if (password === '') {
      setError(passwordInput, 'Password is required');
      isValid = false;
    } else {
      setSuccess(passwordInput);
    }

    return isValid;
  }

  // Function to set error message
  function setError(input, message) {
    const formControl = input.parentElement;
    const errorDisplay = formControl.querySelector('.error-message');

    // Create error message element if it doesn't exist
    if (!errorDisplay) {
      const errorElement = document.createElement('div');
      errorElement.className = 'error-message';
      errorElement.textContent = message;
      formControl.appendChild(errorElement);
    } else {
      errorDisplay.textContent = message;
    }

    // Add error class to input
    input.classList.add('error');
  }

  // Function to set success state
  function setSuccess(input) {
    const formControl = input.parentElement;
    const errorDisplay = formControl.querySelector('.error-message');

    // Remove error message if it exists
    if (errorDisplay) {
      formControl.removeChild(errorDisplay);
    }

    // Remove error class from input
    input.classList.remove('error');
  }
});
