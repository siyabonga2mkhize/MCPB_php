<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Step 1</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="login-dialog-wrapper"> 
        
        <a href="index.php" class="close-btn" aria-label="Close Registration">
            <i class="fa-solid fa-xmark"></i>
        </a>

        <div class="header-section">
            <h1>Register</h1> 
            <p class="instruction-text">Create your login credentials. These will be used for both the Woolies website and app</p>
        </div>

        <form id="registrationStep1Form" action="personal_details.php" method="GET" class="auth-form"> 

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group password-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" placeholder="Create your password" required>
                <span class="password-toggle" id="passwordToggle">
                    <i class="fa-regular fa-eye-slash"></i>
                </span>
            </div>
            
            <div class="password-requirements">
                <p>Your password should include:</p>
                <ul id="passwordValidationList">
                    <li><i class="fas fa-check-circle"></i> A minimum of 8 characters</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 uppercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 lowercase character</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 number</li>
                    <li><i class="fas fa-check-circle"></i> At least 1 special character (\!@#$%^&amp;\*, etc)</li>
                </ul>
            </div>
            
            <div class="register-button-group">
                <a href="index.php" class="cancel-button-text">CANCEL</a>
                
                <button type="submit" class="next-button-grey" id="nextButton" disabled>NEXT</button>
            </div>
        </form>

        <div class="sign-in-link-text">
            <p>Already a customer? <a href="login.php">Sign In</a></p>
        </div>
        
    </div>

    <script src="ASSETS/js/login.js"></script> 
</body>
</html>