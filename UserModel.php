<?php
class UserModel {
    
    private $db;
    private $is_mocking = false; // Flag set to false: We are using a real DB now

    // Constructor: Establishes the real database connection
    public function __construct() {
        // --- XAMPP / WOOLWORTHS DB CONFIGURATION ---
        $host = '127.0.0.1'; 
        $db   = 'WOOLWORTHS'; // The database name (uppercase W)
        $user = 'root';     
        $pass = '';         // IMPORTANT: Use your MySQL password if you set one
        $port = '3307';     // IMPORTANT: Use the port you configured (e.g., 3307)
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->db = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
             // Throw error if connection fails (useful for debugging)
             // In a production app, you would log this and show a generic message.
             throw new \PDOException("DB Connection Failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    // REAL Registration Method
    public function registerUser($email, $password, $title, $firstName, $lastName, $contactNumber) {
        
        // 1. Check if the user already exists
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'That email is already registered.'];
        }
        
        // 2. Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // 3. Prepare and execute the SQL INSERT statement
        $sql = "INSERT INTO users (email, password_hash, title, first_name, last_name, phone_number, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, 1)";
                
        $stmt = $this->db->prepare($sql);
        
        try {
            $stmt->execute([
                $email, 
                $password_hash, 
                $title, 
                $firstName, 
                $lastName, 
                $contactNumber
            ]);

            // Get the ID of the newly created user
            $user_id = $this->db->lastInsertId();

            return [
                'success' => true, 
                'message' => 'Registration successful!', 
                'user_id' => $user_id
            ];
            
        } catch (\PDOException $e) {
            error_log("DB Registration Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'A database error occurred during registration.'];
        }
    }
    
    // REAL Login Method
    public function loginUser($email, $password) {
        
        // 1. Fetch user data
        $stmt = $this->db->prepare("SELECT user_id, first_name, password_hash, is_active FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }
        
        // 2. Verify the password hash
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // 3. Check account status (Optional, but good practice)
        if (!$user['is_active']) {
            return ['success' => false, 'message' => 'Your account is currently inactive.'];
        }

        // 4. Update last login time
        $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
        $stmt->execute([$user['user_id']]);

        // 5. Success
        return [
            'success' => true, 
            'message' => 'Login successful!', 
            'user_id' => $user['user_id'],
            'first_name' => $user['first_name']
        ];
    }
    
    // MOCK/Placeholder for Personal Details Update Method
    public function updatePersonalDetails($data) {
        // --- REAL LOGIC WOULD GO HERE ---
        // For now, we will leave this as a mock to keep focus on auth flow
        // The implementation would be very similar to registerUser but use UPDATE.

        if (isset($data['firstName']) && $data['firstName'] === 'Error') {
             return ['success' => false, 'message' => 'MOCK ERROR: Failed to save details for this name.'];
        }
        
        return ['success' => true, 'message' => 'Details saved successfully! (MOCKED)'];
    }
     // Add this new method inside your UserModel class
    public function updatePassword(string $email, string $hashedPassword): bool
{
    try {
        // FIX: Change 'password' to 'password_hash' to match your registration/login logic
        $stmt = $this->db->prepare("UPDATE users SET password_hash = :password WHERE email = :email");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();

    } catch (\PDOException $e) {
        error_log("Update Password Error: " . $e->getMessage());
        return false;
    }
}
     // Also ensure you have this method from the handler above:
    public function userExists(string $email): bool 
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            // Log error but return false to prevent application failure
            error_log("User Exists Check Error: " . $e->getMessage());
            return false;
        }
    }

    // Destructor
    public function __destruct() {
        // Explicitly set the connection to null to close it
        $this->db = null;
    }
}
?>