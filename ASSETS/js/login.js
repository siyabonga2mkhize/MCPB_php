// ASSETS/js/login.js

// =================================================================
// 1. SIGN IN FORM SUBMISSION (Your Existing Logic)
// =================================================================
document.getElementById('loginForm')?.addEventListener('submit', function (e) {
    e.preventDefault(); // Stop the default form submission

    const form = e.target;
    const formData = new FormData(form);
    const submitButton = document.getElementById('signInBtn');

    // Check if the button exists before proceeding
    if (!submitButton) return;

    // Disable button to prevent double-click
    submitButton.disabled = true;
    submitButton.textContent = 'SIGNING IN...';

    // Send the data using Fetch API
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            // If status is 200 (OK), proceed to parse JSON
            if (response.ok) {
                return response.json();
            }
            // If status is 401 (Unauthorized) or another error, throw an error
            return response.json().then(error => {
                throw new Error(error.message || `Server returned status ${response.status}`);
            });
        })
        .then(data => {
            if (data.success) {
                // SUCCESS: Redirect to the index page
                window.location.href = data.redirect;
            } else {
                // FAILURE 
                alert('Sign In Failed: ' + data.message);
            }
        })
        .catch(error => {
            // Handle network errors or errors thrown from the response block
            console.error('Login Error:', error);
            alert('Sign In Failed: ' + error.message);
        })
        .finally(() => {
            // Re-enable the button regardless of success or failure
            submitButton.disabled = false;
            submitButton.textContent = 'SIGN IN';
        });
});

// -----------------------------------------------------------------
// 1.5. REGISTRATION FORM SUBMISSION (NEW LOGIC)
// -----------------------------------------------------------------
document.getElementById('registerForm')?.addEventListener('submit', function (e) {
    e.preventDefault(); // Stop the default form submission

    const form = e.target;
    const formData = new FormData(form);
    const submitButton = document.getElementById('nextButton'); // Using 'nextButton' as the submit button

    // Check if the button exists before proceeding
    if (!submitButton) return;

    // Disable button and update text
    submitButton.disabled = true;
    submitButton.textContent = 'REGISTERING...';

    // Send the data using Fetch API
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => {
            // If status is 200 (OK), proceed to parse JSON
            if (response.ok) {
                return response.json();
            }
            // If status is an error, throw an error with the message from the response
            return response.json().then(error => {
                throw new Error(error.message || `Server returned status ${response.status}`);
            });
        })
        .then(data => {
            if (data.success) {
                // SUCCESS: Redirect to the index page or success page
                window.location.href = data.redirect;
            } else {
                // FAILURE
                alert('Registration Failed: ' + data.message);
            }
        })
        .catch(error => {
            // Handle network errors or errors thrown from the response block
            console.error('Registration Error:', error);
            alert('Registration Failed: ' + error.message);
        })
        .finally(() => {
            // Re-enable the button regardless of success or failure
            // Note: We'll re-run validation to restore the correct style/text
            if (typeof validateRegistrationForm === 'function') {
                validateRegistrationForm();
            } else {
                submitButton.disabled = false;
                submitButton.textContent = 'NEXT'; // Default text if validation is not yet defined
            }
        });
});


// =================================================================
// 2. DOM CONTENT LOADED - Menu and Registration Logic
// =================================================================
// NOTE: I've lifted validateRegistrationForm out of the DOMContentLoaded block
// so it can be called in the finally() block of the registration form submission.
let validateRegistrationForm;

document.addEventListener('DOMContentLoaded', function () {

    // --- SIDE MENU LOGIC (FIXED SELECTOR) ---

    // 1. Get references to the elements
    const menuBtn = document.querySelector('.menu-btn');       // The hamburger icon in the header
    const sideMenu = document.getElementById('side-menu');     // The <nav> element

    // FIX: Updated selector to look for the button inside the element with the ID 'side-menu'
    const closeBtn = document.querySelector('#side-menu .close-btn'); // The 'X' button inside the menu

    // 2. Function to open/close the menu
    function openMenu() {
        sideMenu.classList.add('is-open');
        document.body.classList.add('menu-open');
    }

    function closeMenu() {
        sideMenu.classList.remove('is-open');
        document.body.classList.remove('menu-open');
    }

    // 3. Attach event listeners
    if (menuBtn && sideMenu) {
        menuBtn.addEventListener('click', openMenu);
    }

    if (closeBtn && sideMenu) {
        closeBtn.addEventListener('click', closeMenu);
    }

    // Optional: Close menu when clicking outside (on the body/overlay)
    document.body.addEventListener('click', function (event) {
        if (sideMenu?.classList.contains('is-open') &&
            !sideMenu.contains(event.target) &&
            !menuBtn?.contains(event.target)) {
            closeMenu();
        }
    });

    // --- REGISTRATION BUTTON LOGIC (EXISTING) ---
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const nextButton = document.getElementById('nextButton');
    const validationList = document.getElementById('passwordValidationList');

    // Check if we are on the registration page before proceeding with reg logic
    if (!nextButton || !emailInput || !passwordInput) return;


    // --- Utility Function to Check Password Requirements ---
    function checkPassword(password) {
        // This array of checks must match the requirements list in Register.php
        const checks = [
            password.length >= 8,                              // A minimum of 8 characters
            /[A-Z]/.test(password),                            // At least 1 uppercase character
            /[a-z]/.test(password),                            // At least 1 lowercase character
            /\d/.test(password),                               // At least 1 number
            /[!@#$%^&*\\,.]/.test(password)                    // At least 1 special character
        ];

        // Return an array of booleans for feedback, and check if all are true
        return {
            results: checks,
            allPassed: checks.every(check => check === true)
        };
    }

    // --- Main Validation Function (NOW ACCESSIBLE OUTSIDE) ---
    // Assigning the function to the variable declared above the DOMContentLoaded
    validateRegistrationForm = function () {
        const isEmailValid = emailInput.value.length > 0 && emailInput.checkValidity();
        const passwordCheck = checkPassword(passwordInput.value);

        const isFormReady = isEmailValid && passwordCheck.allPassed;

        // 1. Update NEXT button state
        if (isFormReady) {
            // Change to the enabled black style
            nextButton.classList.remove('next-button-grey');
            nextButton.classList.add('next-button-black');
            nextButton.disabled = false;
            nextButton.textContent = 'NEXT'; // Ensure text is 'NEXT' when enabled
        } else {
            // Revert to the disabled grey style
            nextButton.classList.remove('next-button-black');
            nextButton.classList.add('next-button-grey');
            nextButton.disabled = true;
            nextButton.textContent = 'NEXT'; // Ensure text is 'NEXT' when disabled
        }

        // 2. Update UI feedback for password requirements
        if (validationList) {
            const passwordItems = validationList.querySelectorAll('li');

            passwordItems.forEach((li, index) => {
                const icon = li.querySelector('i');
                const passed = passwordCheck.results[index] || false;

                if (icon) {
                    // Change icon color based on check result (purple for pass, medium grey for fail)
                    icon.style.color = passed ? 'var(--woolies-purple)' : 'var(--text-medium)';
                }
            });
        }
    }

    // --- Attach Event Listeners for Registration Form ---
    emailInput.addEventListener('input', validateRegistrationForm);
    passwordInput.addEventListener('input', validateRegistrationForm);

    // --- Password Toggle Visibility ---
    const passwordToggle = document.getElementById('passwordToggle');
    if (passwordToggle) {
        passwordToggle.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle the eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye-slash');
            icon.classList.toggle('fa-eye');
        });
    }

    // Run on load to set initial state (e.g., if fields are pre-filled)
    validateRegistrationForm();
});