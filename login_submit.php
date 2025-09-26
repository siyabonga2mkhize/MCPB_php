<?php
// FINAL login_submit.php (Controller)

// CRITICAL STEP 1: Start Output Buffering to catch any unwanted output (like stray spaces or characters)
ob_start();

// CRITICAL: Force PHP to display all errors (for debugging and ensuring no stray output)
ini_set('display_errors', 1); // <-- SET TO 0
ini_set('log_errors', 1);     // <-- LOG ERRORS INSTEAD OF DISPLAYING

// Load the Model Class
require_once 'UserModel.php'; 

// CORS Headers and Content-Type - MUST come before any output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Handle Pre-Flight (OPTIONS) Request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// --- Controller Logic Starts Here ---

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    $response = ['success' => false, 'message' => 'Invalid request method.'];
} else {
    // Get and validate input
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400); 
        $response = ['success' => false, 'message' => 'Email and Password are required.'];
    } else {
        // 1. Instantiate the Model (Connects to the DB/Mocks)
        $userModel = new UserModel();

        // 2. Call the Model's method
        $result = $userModel->loginUser($email, $password);

        // 3. Respond based on the Model's result
        if ($result['success']) {
            http_response_code(200); // OK
        } else {
            // Use 401 Unauthorized for failed login attempts
            http_response_code(401); 
        }
        $response = $result;
    }
}

// CRITICAL STEP 2: Clean the buffer to discard any stray output captured
ob_clean();

// CRITICAL STEP 3: Output the final, clean JSON response
echo json_encode($response);

// NO closing PHP tag (?)and NO trailing whitespace or newlines.