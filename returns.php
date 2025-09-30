<?php
// returns.php
session_start();

// Check if the user is logged in (for personalized header)
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['user_firstName']) : 'Customer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns Policy - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
</head>
<body>

    <div class="app-container">
        
        <header class="main-header">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a> 
            <div class="header-icons">
                <a href="<?php echo $isLoggedIn ? 'profile.php' : 'login.php'; ?>" class="icon-link"><i class="fa-regular fa-user"></i></a>
                <a href="cart.php" class="icon-link shopping-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count">0</span> 
                </a>
                <button class="menu-btn"><i class="fa-solid fa-bars"></i></button>
            </div>
        </header>
        
        <div class="breadcrumb-container">
            <a href="index.php">Home</a> / <strong>Returns Policy</strong>
        </div>

        <div class="content-area">
            
            <h1>Returns Policy</h1>
            
            <div class="returns-info">
                <p>At Woolworths, we strive to ensure customer satisfaction. If you are not completely satisfied with your purchase, you may return the item under the following conditions:</p>
                <ul>
                    <li>The item must be returned within 30 days of purchase.</li>
                    <li>The item must be in its original condition, with all tags and packaging intact.</li>
                    <li>A valid proof of purchase (receipt or invoice) is required.</li>
                </ul>
                <p>For more information, please contact our customer service team or visit your nearest Woolworths store.</p>
            </div>
        </div>

    </div>

    <script src="ASSETS/js/menu.js"></script>
</body>
</html>