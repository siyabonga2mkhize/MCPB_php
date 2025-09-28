<?php
// Start session to hold registration data across steps
session_start();

// Get data from Step 1 (Passed via URL parameters in this simple version)
// In a real app, you would validate and store this in $_SESSION here.
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$password = isset($_GET['password']) ? htmlspecialchars($_GET['password']) : '';

// Simple validation to ensure Step 1 was completed
if (empty($email) || empty($password)) {
    // Optionally redirect back to step 1 or show an error
    // header('Location: registration.php');
    // exit();
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
        <div class="form-header">
            <a href="register.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
            <h2>Personal Details</h2>
            <p class="subtitle">Please enter your details to finish your Woolies online registration</p>
        </div>

        <form id="registrationStep2Form" action="register_handler.php" method="POST" class="auth-form">
            
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
                <h3>DONT MISS OUT!</h3>
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

            <div class="button-group space-between">
                <a href="register.php" class="white-button full-width-btn half-width-btn">CANCEL</a>
                <button type="submit" class="black-button full-width-btn half-width-btn">REGISTER</button>
            </div>
        </form>
        
    </div>

    <script src="ASSETS/js/login.js"></script> 
</body>
</html>