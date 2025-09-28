<?php
// place_order.php - Updated for Click & Collect and PayPal payment method
session_start();
include 'database.php';

// 1. SECURITY & PREREQUISITE CHECKS
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['is_logged_in']) || empty($_SESSION['cart'])) {
    header('Location: cart.php'); 
    exit;
}

$user_id = $_SESSION['user_id'];
$session_cart = $_SESSION['cart'];

// --- Re-calculate totals and fetch item details ---
$cart_total = 0.00; // FIX: Initialize cart_total to 0 before the loop
$cart_items_details = [];
$product_ids = array_keys($session_cart);

if (empty($product_ids)) {
    header('Location: cart.php');
    exit;
}

$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$types = str_repeat('i', count($product_ids)); 
    
$sql = "SELECT product_id, price FROM products WHERE product_id IN ($placeholders) AND is_active = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$product_ids);
$stmt->execute();
$result = $stmt->get_result();

while ($product = $result->fetch_assoc()) {
    $product_id = $product['product_id'];
    $quantity = $session_cart[$product_id];
    $price = $product['price'];
    
    $cart_items_details[] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price
    ];
    $cart_total += $price * $quantity;
}
$stmt->close();

// --- Fixed/Calculated Order Amounts ---
$delivery_fee = 0.00; // Click & Collect
$vat_rate = 0.15;
$vat_amount = $cart_total * $vat_rate;
$grand_total = $cart_total + $vat_amount;
$order_date = date('Y-m-d H:i:s');
$order_status = "PENDING_PAYMENT"; // Default status

// --- Form Data Validation ---
$store_id = $_POST['store_id'] ?? null;
$payment_method = $_POST['payment_method'] ?? 'card'; 

if (!$store_id) {
    header('Location: checkout.php?error=no_store_selected');
    exit;
}

// --- 🌟 PAYPAL PAYMENT STATUS HANDLER 🌟 ---
$paypal_transaction_id = null;
$payment_status = $order_status; // Initialize $payment_status here

if ($payment_method === 'paypal' && !empty($_POST['paypal_transaction_id'])) {
    $paypal_transaction_id = $_POST['paypal_transaction_id'];
    
    // Payment confirmed by PayPal client-side approval
    $order_status = "PAYMENT_COMPLETED";
    $payment_status = "PAYMENT_COMPLETED"; // Update $payment_status
}
// ---------------------------------------------


// 2. START DATABASE TRANSACTION
$conn->begin_transaction();

try {
    // A. INSERT INTO ORDERS TABLE 
    // FIX 1: Column name is 'shipping_address_id'
    $sql_order = "INSERT INTO orders (user_id, order_date, total_amount, order_status, shipping_address_id, payment_method) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    
    // FIX 1: Corrected bind_param types to "isdsis"
    $stmt_order->bind_param("isdsis", $user_id, $order_date, $grand_total, $order_status, $store_id, $payment_method);
    $stmt_order->execute();
    
    $new_order_id = $conn->insert_id; 
    $stmt_order->close();

    // B. INSERT INTO ORDER_ITEMS TABLE
    $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price_at_time_of_order) VALUES (?, ?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);

    foreach ($cart_items_details as $item) {
        $stmt_item->bind_param("iiid", 
            $new_order_id, 
            $item['product_id'], 
            $item['quantity'], 
            $item['price']
        );
        $stmt_item->execute();
    }
    $stmt_item->close();

    // C. INSERT INTO PAYMENTS TABLE 
    // FIX 2: Column name is 'status'
    $sql_payment = "INSERT INTO payments (order_id, payment_method, amount, status, transaction_date, transaction_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_payment = $conn->prepare($sql_payment);
    
    // FIX 3: Changed $status to the correctly defined variable $payment_status
    $stmt_payment->bind_param("isdsss", 
        $new_order_id, 
        $payment_method, 
        $grand_total, 
        $payment_status, // 👈 CRITICAL FIX HERE: Changed from $status to $payment_status
        $order_date, 
        $paypal_transaction_id
    );
    $stmt_payment->execute();
    $stmt_payment->close();


    // 3. COMMIT TRANSACTION & CLEAR CART
    $conn->commit();
    
    unset($_SESSION['cart']);
    unset($_SESSION['cart_count']);

    // 4. REDIRECT TO SUCCESS PAGE
    // Ensure the failure redirect is NOT active here!
    header("Location: order_success.php?order_id=" . $new_order_id);
    exit;

} catch (Exception $e) {
    // 5. ROLLBACK ON ERROR
    $conn->rollback();
    error_log("Order Placement Error: " . $e->getMessage());
    
    // ⚠️ KEEP THIS FAILURE REDIRECT ACTIVE FOR PRODUCTION/TESTING ⚠️
    header("Location: order_failure.php?error=" . urlencode("Failed to process order. Please try again."));
    exit;
    
    /* // ⚠️ REMOVE TEMPORARY DEBUG CODE ⚠️
    echo "<h1>CRITICAL ORDER ERROR:</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    */
} finally {
    $conn->close();
}
?>