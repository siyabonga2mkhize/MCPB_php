<?php
// create_new_password.php
session_start();

// Redirect if verification step was skipped or session expired
if (!isset($_SESSION['code_verified']) || $_SESSION['code_verified'] !== true) {
    header('Location: forgot_password.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/login.css"> 
</head>
<body>

    <div class="app-container login-container">
        
        <form id="newPasswordForm" class="auth-form" action="reset_password_submit.php" method="POST">
            <div class="form-header">
                <h2>Create New Password</h2>
                <a href="login.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <p class="subtitle">Please enter your new password</p>
            </div>

            <div id="messageArea" style="color: red; margin-bottom: 15px;"></div>

            <div class="form-group password-group">
                <label for="new_password">New Password*</label>
                <input type="password" id="new_password" name="new_password" placeholder="••••••••" required>
                <span class="password-toggle"><i class="fa-regular fa-eye-slash"></i></span>
            </div>
            
            <div class="password-tips">
                <p>Your password should include:</p>
                <ul id="passwordTipsList">
                    <li>A minimum of 8 characters</li>
                    <li>At least 1 uppercase character</li>
                    <li>At least 1 lowercase character</li>
                    <li>At least 1 number</li>
                    <li>At least 1 special character (!, @, #, $, %, ^, etc)</li>
                </ul>
            </div>
            
            <button type="submit" class="black-button full-width-btn" id="resetBtn" style="margin-top: 30px;">NEXT</button>

        </form>

    </div>

    <script>
        // Simple client-side validation for demonstration (Full validation should be on the server)
        document.getElementById('newPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const form = e.target;
            const formData = new FormData(form);
            const resetBtn = document.getElementById('resetBtn');
            const messageArea = document.getElementById('messageArea');

            // Basic password requirement check (You need robust regex in JS for full coverage)
            const password = document.getElementById('new_password').value;
            if (password.length < 8) {
                messageArea.innerHTML = 'Password must be at least 8 characters.';
                return;
            }
            
            resetBtn.disabled = true;
            resetBtn.textContent = 'UPDATING...';
            messageArea.innerHTML = ''; 

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Step 4: Confirm Password Change and redirect to login
                    // The backend handler will clear the session variables
                    alert(data.message); // "Password successfully updated!"
                    window.location.href = 'login.php?passwordReset=true'; 
                } else {
                    messageArea.innerHTML = data.message || 'Password reset failed.';
                    resetBtn.disabled = false;
                    resetBtn.textContent = 'NEXT';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageArea.innerHTML = 'A network error occurred.';
                resetBtn.disabled = false;
                resetBtn.textContent = 'NEXT';
            });
        });

        // Password visibility toggle (same as on login.php)
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password');
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