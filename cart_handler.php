<?php
// cart_handler.php
session_start();
// Include your database connection if you need to fetch fresh product data,
// but for a simple cart, we primarily use the session.
// include 'database.php'; 

// Set the response header to JSON so JavaScript can easily process the result
header('Content-Type: application/json');

// 1. Check if the required data is present
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['product_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}

$product_id = intval($_POST['product_id']);
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default to 1 if not specified

// Basic validation
if ($product_id <= 0 || $quantity <= 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Product or quantity data is invalid."]);
    exit;
}

// 2. Initialize the cart session array if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 3. Add or update the item in the cart
// The cart format will be: $_SESSION['cart'] = [ product_id => quantity, ... ]
if (array_key_exists($product_id, $_SESSION['cart'])) {
    // Item already in cart, increment quantity
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    // New item, add it to the cart
    $_SESSION['cart'][$product_id] = $quantity;
}

// 4. Calculate the total item count in the cart (for the header icon badge)
$total_items = array_sum($_SESSION['cart']);

// 5. Send success response
http_response_code(200);
echo json_encode([
    "success" => true, 
    "message" => "Product added to cart successfully!",
    "cart_count" => $total_items
]);

// Optionally, for debugging:
// error_log("Cart contents: " . print_r($_SESSION['cart'], true));
?>