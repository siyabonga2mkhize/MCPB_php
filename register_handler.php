<?php
session_start();
// Include the UserModel class instead of the old database.php
require 'UserModel.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    
    // 1. Collect all form data
    $email = trim($_POST['email']);
    $password = $_POST['password']; 
    $title = $_POST['title'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $contactNumber = trim($_POST['contactNumber']);
    
    // --- Validation (Simplified) ---
    if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
        header('Location: registration.php?error=missing_fields');
        exit();
    }

    // 2. Instantiate the UserModel
    $userModel = new UserModel();

    // 3. Register the user
    $result = $userModel->registerUser($email, $password, $title, $firstName, $lastName, $contactNumber);

    if ($result['success']) {
        
        // SUCCESS: Set session variables
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_email'] = $email;
        $_SESSION['user_firstName'] = $firstName;
        $_SESSION['is_logged_in'] = true;

        // Redirect to the home page, triggering the registration success modal
        header('Location: index.php?showSuccess=true');
        exit();
        
    } else {
        // FAILURE: Redirect with error message
        header('Location: personal_details.php?error=' . urlencode($result['message']));
        exit();
    }
    
} else {
    // If accessed directly without POST data
    header('Location: registration.php');
    exit();
}
?>