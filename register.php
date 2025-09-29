<?php
// register.php (Registration Page)
session_start();
// If the user is already logged in, redirect them away from the registration page
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="app-container login-container">
        
        <form id="registrationForm" class="auth-form" action="personal_details.php" method="GET">
            <div class="form-header">
                <h2>Register</h2>
                <a href="index.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">Create your login credentials</p>
            </div>

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group password-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" placeholder="Create your password" required>
                <span class="password-toggle"><i class="fa-regular fa-eye-slash"></i></span>
            </div>

            <div class="password-requirements">
                <p>Your password should include:</p>
                <ul>
                    <li><i class="fas fa-check-circle"></i> A minimum of 8 characters</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 uppercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 lowercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 number</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 special character (\!@#$%^&*, etc)</li>
                </ul>
            </div>

            <button type="submit" class="black-button" id="registerBtn">REGISTER</button>

            <div class="login-promo">
                <p>Already a customer?</p>
                <p>Sign in to start shopping today!</p>
                <a href="login.php" class="register-button-style" style="margin-top: 15px;">SIGN IN</a>
            </div>
        </form>

    </div>

    <script src="ASSETS/js/login.js"></script>
    <script>
        // JS for password toggle (optional, but good for UX)
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // JavaScript logic to toggle button state
        const registerForm = document.getElementById('registrationForm');
        const registerBtn = document.getElementById('registerBtn');

        registerForm.addEventListener('input', function() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (email && password) {
                registerBtn.classList.add('enabled');
            } else {
                registerBtn.classList.remove('enabled');
            }
        });
    </script>
</body>
</html>