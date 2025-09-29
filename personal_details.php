<?php
// Start session to hold registration data across steps
session_start();

// Ensure email and password are collected from GET parameters
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$password = isset($_GET['password']) ? htmlspecialchars($_GET['password']) : '';

// Validate that email and password are provided
if (empty($email) || empty($password)) {
    header('Location: register.php'); // Redirect back to step 1 if missing
    exit();
}

// Store the login credentials in the session to be used on final submit
$_SESSION['reg_email'] = $email;
$_SESSION['reg_password'] = $password; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Step 2</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="app-container login-container"> 
        <form id="registrationStep2Form" action="register_handler.php" method="POST" class="auth-form">
            <div class="form-header">
                <h2>Personal Details</h2>
                <a href="register.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">Please enter your details to finish your Woolies online registration</p>
            </div>

            <input type="hidden" name="email" value="<?php echo $_SESSION['reg_email']; ?>">
            <input type="hidden" name="password" value="<?php echo $_SESSION['reg_password']; ?>">

            <div class="form-group">
                <label for="title">Title*</label>
                <select id="title" name="title" required>
                    <option value="" disabled selected>Select your Title</option>
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Dr">Dr</option>
                </select>
            </div>

            <div class="form-group">
                <label for="firstName">First Name*</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your First Name" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name*</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
            </div>

            <div class="form-group">
                <label for="contactNumber">Contact Number*</label>
                <input type="tel" id="contactNumber" name="contactNumber" placeholder="Eg. 0407002211, 407002211" required>
            </div>

            <div class="opt-in-section">
                <p class="subtitle">DONT MISS OUT!</p>
                <p>Be the first to know about great savings, exclusive events and deals.</p>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="promoWoolies" name="promoWoolies" checked>
                    <label for="promoWoolies" class="inline-label">Woolworths</label>
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="promoFinancial" name="promoFinancial" checked>
                    <label for="promoFinancial" class="inline-label">Woolworths Financial Services</label>
                </div>
            </div>

            <p style="text-align: center; font-size: 0.8em; margin-top: 20px;">By registering you agree to our <a href="#" style="color: black; text-decoration: underline;">Terms and Conditions</a></p>

            <button type="submit" class="black-button" id="registerBtn">REGISTER</button>
        </form>
    </div>

    <script src="ASSETS/js/login.js"></script> 
</body>
</html>