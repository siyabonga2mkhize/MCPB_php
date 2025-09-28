<?php
// verification_code.php
session_start();

// Redirect back to email input if they haven't started the process
if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot_password.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Code - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="app-container login-container">
        
        <form id="verificationForm" class="auth-form" action="verification_handler.php" method="POST">
            <div class="form-header">
                <h2>Enter Your Verification Code</h2>
                <a href="login.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">We've sent a 6-digit code to your registered number and/or your registered email.</p>
            </div>

            <div id="messageArea" style="color: red; margin-bottom: 15px;"></div>

            <div class="form-group">
                <label for="code">Verification code*</label>
                <input type="text" id="code" name="code" placeholder="Enter your code" maxlength="6" required>
            </div>
            
            <a href="#" class="forgot-password-link">Not receiving your code?</a>
            
            <button type="submit" class="grey-button full-width-btn" id="verifyBtn" style="margin-top: 30px;">NEXT</button>

        </form>

    </div>

    <script>
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const form = e.target;
            const formData = new FormData(form);
            const verifyBtn = document.getElementById('verifyBtn');
            const messageArea = document.getElementById('messageArea');

            verifyBtn.disabled = true;
            verifyBtn.textContent = 'VERIFYING...';
            messageArea.innerHTML = ''; 

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success: Code matches, move to create new password
                    window.location.href = 'create_new_password.php';
                } else {
                    messageArea.innerHTML = data.message || 'Invalid verification code.';
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'NEXT';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageArea.innerHTML = 'A network error occurred.';
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'NEXT';
            });
        });
    </script>
</body>
</html>