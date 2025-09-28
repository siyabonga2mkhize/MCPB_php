<?php
// CRITICAL: Starts the session to allow setting $_SESSION variables
session_start(); 
// Include the database handler
require 'UserModel.php'; 

// Set content type to JSON for the JavaScript (login.js) to handle the response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email']) || !isset($_POST['password'])) {
    http_response_code(400); 
    echo json_encode(["success" => false, "message" => "Email and password are required."]);
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

try {
    // 1. Instantiate the UserModel
    $userModel = new UserModel();

    // 2. Attempt to log in using the database
    $result = $userModel->loginUser($email, $password);

    if ($result['success']) {
        
        // SUCCESS: Set session variables (The application's "cache")
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_email'] = $email;
        $_SESSION['user_firstName'] = $result['first_name'];
        $_SESSION['is_logged_in'] = true;

        // Send success response to the front-end JS (which then performs the redirect)
        http_response_code(200); 
        echo json_encode([
            "success" => true, 
            "message" => $result['message'], 
            "redirect" => "index.php" // Directs the front-end to return to index
        ]);
        
    } else {
        // FAILURE: Send Unauthorized status (401)
        http_response_code(401); 
        echo json_encode(["success" => false, "message" => $result['message']]);
    }
    
} catch (\PDOException $e) {
    error_log("Login DB Error: " . $e->getMessage());
    http_response_code(500); 
    echo json_encode(["success" => false, "message" => "A server error occurred. Please try again later."]);
}
?>  