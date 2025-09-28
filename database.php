<?php
// database.php

$servername = "localhost";
$username = "root"; // CHANGE THIS if you use a different user (like 'user_pma' in your error image)
$password = ''; // CHANGE THIS if your root/pma user has a password
$dbname = "woolworths"; // Based on your PHPMyAdmin structure
$port = '3307';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the connection is set to UTF-8
$conn->set_charset("utf8");

// Function to safely sanitize input (useful for forms, not strictly needed for this file)
function sanitize($conn, $input) {
    return $conn->real_escape_string($input);
}
?>