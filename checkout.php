<?php
// checkout.php - Updated for Click & Collect and PayPal Integration
session_start();
include 'database.php';

// --- SECURITY CHECK: Ensure user is logged in ---
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php?redirect=checkout.php');
    exit;
}

$user_id = $_SESSION['user_id']; 

// --- CART AND SUMMARY LOGIC ---
$cart_items = [];
$cart_total = 0;
$total_items = 0;
$session_cart = $_SESSION['cart'] ?? [];

if (empty($session_cart)) {
    header('Location: cart.php');
    exit;
}

// Fetch detailed product info for items in the cart (Standard Cart Logic)
$product_ids = array_keys($session_cart);
if (!empty($product_ids)) {
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $types = str_repeat('i', count($product_ids)); 
        
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
    $stmt->bind_param($types, ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($product = $result->fetch_assoc()) {
        $product_id = $product['product_id'];
        $quantity = $session_cart[$product_id];
        $price = $product['price'];
        $item_subtotal = $price * $quantity;

        $cart_items[] = [
            'name' => $product['name'],
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $item_subtotal
        ];
        $cart_total += $item_subtotal;
        $total_items += $quantity;
    }
    $stmt->close();
}


// --- FETCH ALL STORE LOCATIONS (Collection Points) ---
$stores = [];
$default_collection_date = date('l, d F Y', strtotime('+1 day')); 

$sql_stores = "SELECT store_id, name, city FROM stores WHERE is_active = 1 ORDER BY city ASC";
$stmt_stores = $conn->prepare($sql_stores);
if (!$stmt_stores) {
    die("SQL Prepare failed for stores: " . $conn->error);
}
$stmt_stores->execute();
$result_stores = $stmt_stores->get_result();

while ($store = $result_stores->fetch_assoc()) {
    $stores[] = $store;
}
$stmt_stores->close();
$conn->close();

// --- Fixed/Calculated Order Amounts for Click & Collect ---
$delivery_fee = 0.00;
$vat_rate = 0.15;
$vat_amount = $cart_total * $vat_rate;
$grand_total = $cart_total + $vat_amount; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    <style>
        .checkout-container { max-width: 600px; margin: 20px auto; padding: 15px; }
        h2 { border-bottom: 2px solid #007041; padding-bottom: 10px; margin-bottom: 20px; }
        .checkout-section { background: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .payment-options { border: 1px solid #ddd; padding: 15px; margin-top: 10px; border-radius: 4px; }
        .payment-options label { display: block; margin-bottom: 8px; } 
        .summary-line { display: flex; justify-content: space-between; padding: 5px 0; }
        .order-total { font-size: 1.4em; font-weight: bold; border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px; }
        .item-list { max-height: 200px; overflow-y: auto; border: 1px solid #eee; padding: 10px; margin-bottom: 15px; background: white; }
        .item-list-row { display: flex; justify-content: space-between; font-size: 0.9em; padding: 3px 0; }
        .place-order-btn { background-color: #007041; color: white; padding: 15px; border: none; width: 100%; font-size: 1.2em; cursor: pointer; margin-top: 20px; }
        .place-order-btn:disabled { background-color: #ccc; cursor: not-allowed; }
        .collection-info-box { border: 1px solid #ddd; padding: 15px; border-radius: 4px; background: white; }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="main-header" style="justify-content: center;">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS CHECKOUT</span></a>
        </header>

        <div class="checkout-container">
            <form id="checkoutForm" action="place_order.php" method="POST">
                
                <div class="checkout-section">
                    <h2>1. Collection Point (Click & Collect)</h2>
                    
                    <div class="collection-info-box">
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <i class="fa-solid fa-bag-shopping" style="font-size: 2em; color: #007041; margin-right: 15px;"></i>
                            <div>
                                <p style="margin: 0; font-size: 0.9em;">Earliest collection</p>
                                <p style="margin: 0; font-weight: bold;"><?php echo $default_collection_date; ?></p>
                            </div>
                        </div>
                        
                        <?php if (empty($stores)): ?>
                            <p style="color: red; margin-top: 10px;">No collection stores available at this time.</p>
                            <button type="submit" disabled class="place-order-btn">PLACE ORDER (No Stores)</button>
                            </form>
                            </div></div></body></html>
                            <?php exit; ?>
                        <?php else: ?>
                            <label for="store_id" style="font-size: 0.9em; display: block; margin-bottom: 5px;">Select Collection Store:</label>
                            <select id="store_id" name="store_id" required 
                                    style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">Select a Store</option>
                                <?php foreach ($stores as $store): ?>
                                    <option value="<?php echo $store['store_id']; ?>">
                                        <?php echo htmlspecialchars($store['name']) . ' - ' . htmlspecialchars($store['city']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="checkout-section">
                    <h2>2. Payment Method</h2>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="payment_method_option" value="card" checked>
                            Credit/Debit Card (Pay Now)
                        </label>
                        <label>
                            <input type="radio" name="payment_method_option" value="eft">
                            EFT (Electronic Funds Transfer)
                        </label>

                        <hr style="margin: 15px 0;">
                        <label style="font-weight: bold; margin-bottom: 10px;">
                            OR Pay with PayPal:
                        </label>
                        <div id="paypal-button-container"></div> 
                        
                        <input type="hidden" id="paypal_transaction_id" name="paypal_transaction_id" value=""> 
                        <input type="hidden" id="final_payment_method" name="payment_method" value="card"> 
                    </div>
                </div>

                <div class="checkout-section">
                    <h2>3. Order Summary</h2>
                    <div class="item-list">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="item-list-row">
                                <span><?php echo $item['quantity']; ?> x <?php echo htmlspecialchars($item['name']); ?></span>
                                <span>R<?php echo number_format($item['subtotal'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-line">
                        <span>Subtotal (<?php echo $total_items; ?> items)</span>
                        <span>R<?php echo number_format($cart_total, 2); ?></span>
                    </div>
                    <div class="summary-line">
                        <span>Delivery Fee (Click & Collect)</span>
                        <span>R<?php echo number_format($delivery_fee, 2); ?></span>
                    </div>
                    <div class="summary-line">
                        <span>VAT (<?php echo ($vat_rate * 100); ?>%)</span>
                        <span>R<?php echo number_format($vat_amount, 2); ?></span>
                    </div>
                    
                    <div class="summary-line order-total">
                        <span>Grand Total</span>
                        <span>R<?php echo number_format($grand_total, 2); ?></span>
                    </div>
                </div>

                <button type="submit" class="place-order-btn">PLACE ORDER (R<?php echo number_format($grand_total, 2); ?>)</button>
            </form>
        </div>
    </div>
    
    <script src="https://www.paypal.com/sdk/js?client-id=AZ6Qyk8Sk3wve-1l7tUScmyFCiWZqUJYbVMrmK0x8ZozCf3sPfrYke22j9zdnSV9ABMBmfJ3IBCGkfqB&currency=USD"></script>

    <script>
        // Get the form elements
        const checkoutForm = document.getElementById('checkoutForm');
        const placeOrderBtn = document.querySelector('.place-order-btn');
        const paypalTransactionIdInput = document.getElementById('paypal_transaction_id');
        const finalPaymentMethodInput = document.getElementById('final_payment_method');
        const storeIdSelect = document.getElementById('store_id');
        // PHP Grand Total converted to a safe JavaScript number
        const grandTotal = <?php echo number_format($grand_total, 2, '.', ''); ?>; 

        // --- Event Listeners for Store Selection and Payment Option ---
        
        // Function to update the main order button state
        function updateOrderButtonState() {
            const isStoreSelected = !!storeIdSelect.value;
            const currentPaymentMethod = finalPaymentMethodInput.value;
            
            if (currentPaymentMethod === 'paypal') {
                // If PayPal is selected, the main button should be hidden, as the PayPal button handles submission
                placeOrderBtn.style.display = 'none';
                placeOrderBtn.disabled = true;
            } else {
                // For Card/EFT, the main button is shown and enabled only if a store is selected
                placeOrderBtn.style.display = 'block';
                placeOrderBtn.disabled = !isStoreSelected;
            }
        }

        // Handle radio button changes for Card/EFT selection
        document.querySelectorAll('input[name="payment_method_option"]').forEach(radio => {
            radio.addEventListener('change', function() {
                finalPaymentMethodInput.value = this.value;
                paypalTransactionIdInput.value = ''; // Clear PayPal ID if switching away
                updateOrderButtonState();
            });
        });

        // Handle store selection changes
        storeIdSelect.addEventListener('change', updateOrderButtonState);
        
        // Force initial state based on default selection and store status
        updateOrderButtonState();


        // --- PayPal Button Rendering ---
        paypal.Buttons({
            // Set up the transaction details
            createOrder: function(data, actions) {
                // Check if store is selected
                if (!storeIdSelect.value) {
                    alert("Please select a collection store location first.");
                    return actions.reject(); 
                }
                
                // CRITICAL FIX: Convert ZAR amount to USD for PayPal sandbox testing
                // Using an example conversion rate (R18 to $1) and rounding to 2 decimals.
                const usdAmount = (grandTotal / 18).toFixed(2); 

                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            // PayPal expects a string for the value
                            value: usdAmount 
                        },
                        description: 'Woolworths Click & Collect Order (USD Test)',
                    }]
                });
            },
            
            // Capture the funds and get the transaction ID after successful approval
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // 1. Mark the payment method as PayPal
                    finalPaymentMethodInput.value = 'paypal';

                    // 2. Save the Transaction ID
                    paypalTransactionIdInput.value = details.id; 
                    
                    // 3. Submit the form to place_order.php
                    checkoutForm.submit(); 
                });
            },
            
            // Handle cancellations or errors
            onCancel: function(data) {
                alert('PayPal payment was cancelled. Please try another method.');
            },
            onError: function(err) {
                console.error(err);
                alert('An error occurred with the PayPal payment. Please try again or select another method.');
            }
        }).render('#paypal-button-container'); // Render the button
    </script>
    
    <script src="ASSETS/js/menu.js"></script>
    <script src="ASSETS/js/cart.js"></script>
</body>
</html>