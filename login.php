<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    </head>
<body>

    <div class="app-container login-container"> 
        <div class="form-header">
            <a href="index.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
            <h2>Sign In</h2>
            <p class="subtitle">Enter your profile details</p>
        </div>

        <form id="signInForm" class="auth-form">
            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Email address" required>
            </div>

            <div class="form-group password-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="password-toggle" id="passwordToggle">
                    <i class="fa-regular fa-eye-slash"></i>
                </span>
            </div>

            <div class="password-tips">
                <p>Tips to remember your password</p>
                <ul>
                    <li><i class="fas fa-check-circle"></i> A minimum of 8 characters</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 uppercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 lowercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 number</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 special character (\!@#$%^&\*, etc)</li>
                </ul>
            </div>
            
            <a href="forgot_password.html" class="forgot-password-link">Forgot Password?</a>

            <button type="submit" class="black-button full-width-btn">SIGN IN</button>
        </form>

        <div class="divider"></div>

        <div class="register-promo">
            <p>New customer?</p>
            <p>Register and start shopping today!</p>
            <a href="register.php" class="white-button full-width-btn" id="registerBtn">REGISTER</a>
        </div>
    </div>

    <script src="ASSETS/js/login.js"></script>
</body>
</html>