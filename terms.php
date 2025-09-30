<?php
// terms.php
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
    <title>Terms and Conditions - Woolworths</title>
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
            <a href="index.php">Home</a> / <strong>Terms and Conditions</strong>
        </div>

        <div class="content-area">
            
            <h1>Terms and Conditions</h1>
            
            <div class="terms-info">
                <p>Welcome to Woolworths. By accessing and using our website, you agree to the following terms and conditions:</p>
                <ul>
                    <li>All content on this website is for informational purposes only and may be subject to change without notice.</li>
                    <li>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.</li>
                    <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable.</li>
                </ul>
                <p>For further details, please contact our customer service team.</p>
            </div>
        </div>

    </div>

    <script src="ASSETS/js/menu.js"></script>
</body>
</html>