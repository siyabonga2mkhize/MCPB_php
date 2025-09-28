<?php
// forgot_password.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="app-container login-container">
        
        <form id="forgotPasswordForm" class="auth-form" action="forgot_password_handler.php" method="POST">
            <div class="form-header">
                <h2>Forgot Your Password?</h2>
                <a href="login.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">Enter the email address associated with your Woolworths profile.</p>
            </div>

            <div id="messageArea" style="color: red; margin-bottom: 15px;"></div>

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            
            <div class="button-group space-between">
                <button type="submit" class="grey-button half-width-btn" id="nextBtn">NEXT</button>
            </div>

            <a href="login.php" class="white-button full-width-btn" style="margin-top: 15px;">BACK TO SIGN IN</a>
        </form>

    </div>

    <script>
        // Use AJAX to submit the form and handle the response without a page refresh
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const form = e.target;
            const formData = new FormData(form);
            const nextBtn = document.getElementById('nextBtn');
            const messageArea = document.getElementById('messageArea');

            nextBtn.disabled = true;
            nextBtn.textContent = 'PROCESSING...';
            messageArea.innerHTML = ''; // Clear previous messages

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success: Redirect to the verification page
                    window.location.href = 'verification_code.php';
                } else {
                    // Failure: Display error message
                    messageArea.innerHTML = data.message || 'Error processing request.';
                    nextBtn.disabled = false;
                    nextBtn.textContent = 'NEXT';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageArea.innerHTML = 'A network error occurred. Please try again.';
                nextBtn.disabled = false;
                nextBtn.textContent = 'NEXT';
            });
        });
    </script>
</body>
</html>