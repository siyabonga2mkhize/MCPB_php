<?php
// Mock UserModel.php - Used for front-end testing only. 
// It pretends the database connection and operations are successful.

class UserModel {
    private $is_mocking = true; // Flag to indicate we are not using a real DB
    // NOTE: If you switch to a real DB, you would add 'private $db;' here.

    // Constructor: Skips the actual database connection
    public function __construct() {
        if (!$this->is_mocking) {
            // REAL DB LOGIC WOULD GO HERE
        }
        // Success: Do nothing.
    }

    // MOCK Registration Method
    public function registerUser($email, $hashed_password) {
        // We pretend the user was successfully registered.
        if ($email === 'fail@test.com') {
            return ['success' => false, 'message' => 'That email is already registered. (MOCKED ERROR)'];
        }
        
        return ['success' => true, 'message' => 'Registration successful! (MOCKED)'];
    }
    
   // MOCK Login Method
   public function loginUser($email, $password) {
    // We pretend a user named 'test@user.com' exists.
    
    // FIX: Include the exact password from the current payload ('Password!1')
    if ($email === 'test@user.com' && ($password === 'password' || $password === 'Password!!' || $password === 'Password!1')) {
        return ['success' => true, 'message' => 'Login successful! (MOCKED)', 'user_id' => 101];
    } 
    
    // This simulates a failed login attempt for any other credentials
    return ['success' => false, 'message' => 'Invalid email or password. (MOCKED ERROR)'];
}
    // MOCK Personal Details Update Method
    /**
     * Simulates the database update for personal details.
     * @param array $data The user data array sent from the client.
     * @return array Success/failure result.
     */
    public function updatePersonalDetails($data) {
        // --- MOCK LOGIC START ---
        // You could add mock failure logic here, e.g., if first name is 'Error'
        if (isset($data['firstName']) && $data['firstName'] === 'Error') {
             return ['success' => false, 'message' => 'MOCK ERROR: Failed to save details for this name.'];
        }
        
        // We pretend the update was successful for all other cases.
        return ['success' => true, 'message' => 'Details saved successfully! (MOCKED)'];
        // --- MOCK LOGIC END ---
    }

    // Destructor (no action needed in mock)
    public function __destruct() {
        // Connection close skipped.
    }
}