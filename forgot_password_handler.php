<?php
// forgot_password_handler.php
session_start();
require 'UserModel.php'; 

header('Content-Type: application/json');

if (!isset($_POST['email'])) {
    http_response_code(400); 
    echo json_encode(["success" => false, "message" => "Email is required."]);
    exit();
}

$email = trim($_POST['email']);

try {
    $userModel = new UserModel();
    
    // 1. Check if the user exists
    if (!$userModel->userExists($email)) {
        // IMPORTANT SECURITY NOTE: Do not tell the user if the email does not exist. 
        // Always provide a generic success message to prevent user enumeration attacks.
        // We will still redirect them, but the session flag will prevent verification.
        $exists = false;
    } else {
        $exists = true;
    }
    
    // 2. Generate and store the verification code (Simulated Email Send)
    $verification_code = strval(mt_rand(100000, 999999));
    
    // 3. Store data in the session to carry over to the next step
    $_SESSION['reset_email'] = $email;
    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['code_is_valid'] = $exists; // Only true if email exists in DB

    // In a real app, you would send the $verification_code via email/SMS here.
    error_log("Password Reset initiated for: $email. Code: $verification_code");

    // SUCCESS: Send success response (even if email didn't exist, for security)
    http_response_code(200); 
    echo json_encode([
        "success" => true, 
        "message" => "If an account exists, a verification code has been sent.", 
        "redirect" => "verification_code.php"
    ]);
    
} catch (\PDOException $e) {
    error_log("Forgot Password DB Error: " . $e->getMessage());
    http_response_code(500); 
    echo json_encode(["success" => false, "message" => "A server error occurred. Please try again later."]);
}
?>