<?php
// login.php (Sign In Page)
session_start();
// If the user is already logged in, redirect them away from the login page
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
    <title>Sign In - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
    </head>
<body>

    <div class="app-container login-container">
        
        <form id="loginForm" class="auth-form" action="login_submit.php" method="POST">
            <div class="form-header">
                <h2>Sign In</h2>
                <a href="index.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">Enter your profile details</p>
            </div>

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Email address" required>
            </div>

            <div class="form-group password-group">
            <label for="password">Password*</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="password-toggle"><i class="fa-regular fa-eye-slash"></i></span>
            </div>
            
            <a href="forgot_password.php" class="forgot-password-link">Forgot Password?</a>
            
            <button type="submit" class="black-button" id="signInBtn">SIGN IN</button>
            
            <div class="login-promo">
                <p>New customer?</p>
                <p>Register and start shopping today!</p>
                <a href="register.php" class="register-button-style" style="margin-top: 15px;">REGISTER</a>
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
    </script>
</body>
</html>