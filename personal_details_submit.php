<?php
// FINAL personal_details_submit.php (Controller)

// CRITICAL: Force PHP to display all errors, including fatal ones.
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// 1. Load the Model Class
require_once 'UserModel.php'; 

// --- Controller Logic Starts Here ---

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); 
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Get and validate input (full payload from login.js)
$data = json_decode(file_get_contents("php://input"), true);

// BASIC Validation: Check for essential fields
if (empty($data['email']) || empty($data['firstName']) || empty($data['lastName'])) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Missing required personal details: email, first name, and last name are essential.']);
    exit;
}

// 2. Instantiate the Model (Connects to the DB)
$userModel = new UserModel();

// 3. Call the Model's method to update the user record
// Pass the entire data array, as the Model will handle the DB column mapping
$result = $userModel->updatePersonalDetails($data);

// 4. Respond based on the Model's result
if ($result['success']) {
    http_response_code(200); // OK
} else {
    // General server error for update failure
    http_response_code(500); 
}

echo json_encode($result);

// Omit the closing PHP tag (?) for safety against whitespace.