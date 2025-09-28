<?php
// verification_handler.php
session_start();

header('Content-Type: application/json');

// Check prerequisites
if (!isset($_SESSION['verification_code']) || !isset($_POST['code'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Session expired or missing data. Please restart the process."]);
    exit();
}

$user_code = trim($_POST['code']);
$session_code = $_SESSION['verification_code'];
$code_valid = $_SESSION['code_is_valid'] ?? false; // Check if the email actually existed

if ($code_valid && $user_code === $session_code) {
    // 1. Success: Mark this step as complete in the session
    $_SESSION['code_verified'] = true;
    
    // 2. Clear the verification code (it's no longer needed)
    unset($_SESSION['verification_code']);

    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Code verified."]);
} else {
    // Failure: Either the email didn't exist, or the code was wrong
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "The code you entered is incorrect. Please try again."]);
}
?>