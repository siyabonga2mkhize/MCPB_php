<?php
// update_cart.php
session_start();
header('Content-Type: application/json');

// Get required parameters
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$action = $_POST['action'] ?? ''; // Can be 'update' or 'remove'
$new_quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

// Basic validation
if ($product_id <= 0 || !isset($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid request or cart not found."]);
    exit;
}

$cart = $_SESSION['cart'];
$cart_changed = false;

if ($action === 'remove') {
    // Action 1: Remove the item
    if (isset($cart[$product_id])) {
        unset($cart[$product_id]);
        $cart_changed = true;
    }
} elseif ($action === 'update') {
    // Action 2: Update the quantity
    if (isset($cart[$product_id])) {
        if ($new_quantity > 0) {
            $cart[$product_id] = $new_quantity;
            $cart_changed = true;
        } else {
            // Treat quantity 0 as a removal
            unset($cart[$product_id]);
            $cart_changed = true;
        }
    }
}

// Update the session cart
$_SESSION['cart'] = $cart;

// Calculate the new total item count
$total_items = array_sum($cart);
$_SESSION['cart_count'] = $total_items; // Update the header badge session variable

if ($cart_changed) {
    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "Cart updated successfully.",
        "cart_count" => $total_items
        // We do NOT return the full price data here, we'll let JavaScript recalculate or reload.
    ]);
} else {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "Item not found in cart."]);
}
?>