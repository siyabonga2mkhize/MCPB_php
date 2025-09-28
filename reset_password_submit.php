<?php
// TEMPORARY DEBUGGING LINES
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// END TEMPORARY DEBUGGING LINES
// reset_password_submit.php
session_start();
require 'UserModel.php'; 

header('Content-Type: application/json');

// Check prerequisites: email and verification must be confirmed
if (!isset($_SESSION['reset_email']) || $_SESSION['code_verified'] !== true || !isset($_POST['new_password'])) {
    http_response_code(400); 
    echo json_encode(["success" => false, "message" => "Invalid session or missing password."]);
    exit();
}

$email = $_SESSION['reset_email'];
$new_password = $_POST['new_password'];

// 1. Validate Password Strength (Simple check here, UserModel should have robust check too)
if (strlen($new_password) < 8) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters."]);
    exit();
}

try {
    $userModel = new UserModel();
    
    // 2. Hash the new password and update the database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_success = $userModel->updatePassword($email, $hashed_password);

    if ($update_success) {
        // 3. SUCCESS: Clear all reset session variables
        unset($_SESSION['reset_email']);
        unset($_SESSION['code_verified']);
        
        http_response_code(200); 
        echo json_encode(["success" => true, "message" => "Password successfully updated!"]);
        
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to update password in the database."]);
    }
    
} catch (\PDOException $e) {
    error_log("Password Reset DB Error: " . $e->getMessage());
    http_response_code(500); 
    echo json_encode(["success" => false, "message" => "A server error occurred."]);
}
?>