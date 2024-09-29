// js for login validation

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const loginForm = document.getElementById('loginForm');

    // Add submit event listener to the form
    loginForm.addEventListener('submit', function(event) {
        // Prevent the form from submitting by default
        event.preventDefault();

        // Get the email and password input elements
        const emailInput = document.getElementById('formEmail');
        const passwordInput = document.getElementById('formPassword');

        // Get the values from the inputs
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        // Validate email and password
        if (validateForm(email, password)) {
            // If validation passes, submit the form
            loginForm.submit();
        }
    });

    // Function to validate the form
    function validateForm(email, password) {
        let isValid = true;

        // Email validation
        if (email === '') {
            setError(emailInput, 'Email is required');
            isValid = false;
        } else if (!isValidEmail(email)) {
            setError(emailInput, 'Please enter a valid email address');
            isValid = false;
        } else {
            setSuccess(emailInput);
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

    // Function to check if email is valid
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
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