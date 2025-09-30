<?php
// men.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
</head>
<body>

    <div class="app-container">
        
        <header class="main-header">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a> 
            <div class="header-icons">
                <a href="login.php" class="icon-link"><i class="fa-regular fa-user"></i></a>
                <a href="cart.php" class="icon-link shopping-cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count">0</span> 
                </a>
                <button class="menu-btn"><i class="fa-solid fa-bars"></i></button>
            </div>
        </header>
        
        <div class="breadcrumb-container">
            <a href="index.php">Home</a> / <strong>Men</strong>
        </div>

        <div class="content-area">
            
            <h1>Men</h1>
            
            <div class="info-message">
                <p>Currently, this section is not available. Please note that you can only purchase food items from our store.</p>
                <p>Explore the following pages to find food items:</p>
                <ul>
                    <li><a href="meat_poultry.php">Meat & Poultry</a></li>
                    <li><a href="ready_meals.php">Ready Meals</a></li>
                    <li><a href="meat_beef.php">Meat & Beef</a></li>
                </ul>
            </div>
        </div>

    </div>

    <script src="ASSETS/js/menu.js"></script>
</body>
</html>