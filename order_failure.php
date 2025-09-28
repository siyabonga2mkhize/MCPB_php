<?php
// order_failure.php
session_start();
$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : 'An unexpected error occurred during checkout.';
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Failed - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    <style>
        .failure-container { max-width: 600px; margin: 50px auto; padding: 30px; text-align: center; border: 1px solid #cc0000; border-radius: 8px; background-color: #fff7f7; }
        .failure-icon { color: #cc0000; font-size: 4em; margin-bottom: 20px; }
        h1 { color: #cc0000; margin-bottom: 15px; }
        .error-details { background: #fcebeb; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .retry-btn { background-color: #007041; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 20px; font-weight: bold; }
        .cart-btn { background-color: #333; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 20px; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="main-header" style="justify-content: center;">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
        </header>

        <div class="failure-container">
            <i class="fa-solid fa-times-circle failure-icon"></i>
            <h1>Order Failed</h1>
            <p>We encountered a problem while trying to place your order. Your cart items have been saved.</p>
            <div class="error-details">
                **Error Details:** <?php echo $error_message; ?>
            </div>
            <p>Please review your cart or try the checkout process again.</p>
            
            <a href="checkout.php" class="retry-btn">RETRY CHECKOUT</a>
            <a href="cart.php" class="cart-btn">BACK TO CART</a>
        </div>
    </div>
</body>
</html>