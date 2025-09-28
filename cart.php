<?php
// cart.php
session_start();
include 'database.php'; // Reuse your working connection file

// Check if the user is logged in (optional, but good practice)
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

// Initialize cart variables
$cart_items = [];
$cart_total = 0;
$total_items = 0;

// Get the raw cart data from the session
$session_cart = $_SESSION['cart'] ?? [];

if (!empty($session_cart)) {
    // 1. Prepare to fetch product details for all IDs in the cart
    $product_ids = array_keys($session_cart);
    
    // Create placeholders for the SQL IN clause (e.g., ?, ?, ?)
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    // The bind type string: 'i' for each product ID
    $types = str_repeat('i', count($product_ids)); 
    
    // SQL query to fetch product details and main image URL
    $sql = "SELECT 
                p.product_id, p.name, p.price, 
                pi.image_url AS main_image_url
            FROM 
                products p
            JOIN 
                product_images pi ON p.product_id = pi.product_id AND pi.is_main = TRUE
            WHERE 
                p.product_id IN ($placeholders) AND p.is_active = 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    // 2. Dynamically bind parameters
    $stmt->bind_param($types, ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    // 3. Process results and populate the $cart_items array
    while ($product = $result->fetch_assoc()) {
        $product_id = $product['product_id'];
        $quantity = $session_cart[$product_id];
        $item_subtotal = $product['price'] * $quantity;

        $cart_items[] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'image_url' => $product['main_image_url'],
            'quantity' => $quantity,
            'subtotal' => $item_subtotal
        ];

        $cart_total += $item_subtotal;
        $total_items += $quantity;
    }

    $stmt->close();
}

$conn->close();

// Update the cart count in the session for the header badge on reload
$_SESSION['cart_count'] = $total_items;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css">
    <link rel="stylesheet" href="ASSETS/css/cart.css"> 
    <style>
        /* Minimal CSS to define the cart layout, you'll flesh this out in cart.css */
        .cart-container { padding: 15px; max-width: 800px; margin: 0 auto; }
        .cart-item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 15px 0; }
        .item-image img { width: 70px; height: 70px; object-fit: cover; margin-right: 15px; }
        .item-details { flex-grow: 1; }
        .item-details p { margin: 0 0 5px 0; }
        .item-name { font-weight: bold; }
        .item-price, .item-subtotal { font-weight: bold; }
        .item-controls { display: flex; align-items: center; }
        .item-controls select { margin: 0 10px; padding: 5px; }
        .remove-btn { color: #cc0000; cursor: pointer; border: none; background: none; font-size: 0.9em; }
        .cart-summary { border-top: 2px solid #007041; padding-top: 20px; margin-top: 20px; }
        .summary-line { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .grand-total { font-size: 1.2em; font-weight: bold; }
        .checkout-btn { width: 100%; padding: 15px; background-color: #007041; color: white; border: none; font-size: 1.1em; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="app-container">
        
        <header class="main-header">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
            <div class="header-icons">
                <a href="<?php echo $isLoggedIn ? 'profile.php' : 'login.php'; ?>" class="icon-link"><i class="fa-regular fa-user"></i></a>
                <a href="cart.php" class="icon-link shopping-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count"><?php echo $total_items; ?></span> 
                </a>
                <button class="menu-btn"><i class="fa-solid fa-bars"></i></button>
            </div>
        </header>

        <div class="search-bar-container">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" placeholder="Search" class="search-input">
        </div>

        <div class="cart-container">
            <h1>Your Shopping Cart (<?php echo $total_items; ?> Items)</h1>

            <?php if (empty($cart_items)): ?>
    <div class="empty-cart-view">
        <h1 class="cart-title">YOUR CART</h1>
        
        <div class="empty-message-area">
            <p>You have no items in your shopping cart</p>
            </div>

        <div class="empty-footer">
            <a href="index.php" class="continue-shopping-btn">CONTINUE SHOPPING</a>
        </div>
    </div>
    <?php else: ?>    
                <div class="cart-items-list">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item" data-product-id="<?php echo $item['id']; ?>">
                            
                            <div class="item-image">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>

                            <div class="item-details">
                                <p class="item-name"><?php echo htmlspecialchars($item['name']); ?></p>
                                <p class="item-price">R<?php echo number_format($item['price'], 2); ?></p>
                            </div>
                            
                            <div class="item-controls">
                                <select class="item-qty-select" data-product-id="<?php echo $item['id']; ?>">
                                    <?php 
                                        // Generate options up to a reasonable max (e.g., 10)
                                        for ($i = 1; $i <= 10; $i++): 
                                    ?>
                                        <option value="<?php echo $i; ?>" 
                                            <?php echo ($i == $item['quantity'] ? 'selected' : ''); ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <p class="item-subtotal">R<?php echo number_format($item['subtotal'], 2); ?></p>
                                <button class="remove-btn" data-product-id="<?php echo $item['id']; ?>">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <div class="summary-line">
                        <span>Subtotal (<?php echo $total_items; ?> items)</span>
                        <span>R<?php echo number_format($cart_total, 2); ?></span>
                    </div>
                    <div class="summary-line grand-total">
                        <span>Total</span>
                        <span>R<?php echo number_format($cart_total, 2); ?></span>
                    </div>

                    <a href="checkout.php" class="checkout-btn">PROCEED TO CHECKOUT</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="ASSETS/js/menu.js"></script>
    <script src="ASSETS/js/cart.js"></script> 
    <script>
        // Placeholder for any specific cart page JS actions (e.g., quantity update)
        // This will be implemented in the next step.
    </script>
</body>
</html>