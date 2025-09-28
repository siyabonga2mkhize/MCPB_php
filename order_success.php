<?php
// order_success.php
session_start();
// No database connection needed here unless you want to fetch specific user/order details,
// but for simplicity, we rely on the order_id in the URL.

$order_id = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'N/A';
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

// Ensure cart is cleared (though it should have been cleared in place_order.php)
// It's safe to run these regardless
unset($_SESSION['cart']);
unset($_SESSION['cart_count']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    <style>
        .success-container { max-width: 600px; margin: 50px auto; padding: 30px; text-align: center; border: 1px solid #007041; border-radius: 8px; background-color: #f7fff7; }
        .success-icon { color: #007041; font-size: 4em; margin-bottom: 20px; }
        h1 { color: #007041; margin-bottom: 15px; }
        .order-ref { font-size: 1.2em; font-weight: bold; margin: 20px 0; padding: 10px; background: #e0f2e0; border-radius: 4px; display: inline-block; }
        .continue-btn { background-color: #007041; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="main-header" style="justify-content: center;">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
        </header>

        <div class="success-container">
            <i class="fa-solid fa-check-circle success-icon"></i>
            <h1>Order Placed Successfully!</h1>
            <p>Thank you for shopping with us. Your order has been placed and is now being processed.</p>
            <p>Your Order Reference Number is:</p>
            <div class="order-ref">#<?php echo $order_id; ?></div>
            <p>You will receive an email confirmation shortly.</p>
            
            <a href="profile.php?section=orders" class="continue-btn" style="background-color: #333;">VIEW MY ORDERS</a>
            <a href="index.php" class="continue-btn">CONTINUE SHOPPING</a>
        </div>
    </div>
    </body>
</html>