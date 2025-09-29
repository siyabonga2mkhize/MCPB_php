<?php
// FINAL register_submit.php (Controller)
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

// Get and validate input
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Email and Password are required.']);
    exit;
}

// Collect additional fields from the form submission
$title = $_POST['title'] ?? null;
$firstName = $_POST['first_name'] ?? null;
$lastName = $_POST['last_name'] ?? null;
$contactNumber = $_POST['contact_number'] ?? null;

// 2. Prepare Data
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 3. Instantiate the Model (Connects to the DB)
$userModel = new UserModel();

// 4. Call the Model's method
$result = $userModel->registerUser($email, $hashed_password, $title, $firstName, $lastName, $contactNumber);

// 5. Respond based on the Model's result
if ($result['success']) {
    http_response_code(201); // Created
} else {
    // Custom HTTP codes for known failures
    $http_code = ($result['message'] === 'That email is already registered.') ? 409 : 500;
    http_response_code($http_code);
}

echo json_encode($result);

// Omit the closing PHP tag (?) for safety against whitespace.
