<?php
// This file contains the HTML structure for all multi-level side menus.
// It relies on $isLoggedIn being defined in the calling file (e.g., profile.php).

// Ensure $isLoggedIn is set (default to false if not)
$isLoggedIn = $isLoggedIn ?? false;
?>

<div id="mainMenuOverlay" class="side-menu-overlay">
    <div class="side-menu-content">
        <div class="menu-header">
            <span class="logo">WOOLWORTHS</span>
            <button id="closeMainMenuBtn" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <nav class="menu-nav">
            <a href="#" id="foodLink" class="menu-item">FOOD <i class="fa-solid fa-angle-right"></i></a> 
            <a href="wcellar.php" class="menu-item">WCELLAR <i class="fa-solid fa-angle-right"></i></a>
            <a href="women.php" class="menu-item">WOMEN <i class="fa-solid fa-angle-right"></i></a>
            <a href="men.php" class="menu-item">MEN <i class="fa-solid fa-angle-right"></i></a>
            <a href="kids.php" class="menu-item">KIDS <i class="fa-solid fa-angle-right"></i></a>
            <a href="baby.php" class="menu-item">BABY <i class="fa-solid fa-angle-right"></i></a>
            <a href="home.php" class="menu-item">HOME <i class="fa-solid fa-angle-right"></i></a>
            
            <?php if ($isLoggedIn): ?>
                <hr class="menu-divider">
                <a href="profile.php" class="menu-item">MY ACCOUNT</a>
                <a href="logout.php" class="menu-item">LOGOUT</a>
            <?php else: ?>
                <hr class="menu-divider">
                <a href="login.php" class="menu-item">SIGN IN</a>
                <a href="register.php" class="menu-item">REGISTER</a>
            <?php endif; ?>
        </nav>
    </div>
</div>

<div id="foodMenuOverlay" class="side-menu-overlay second-level">
    <div class="side-menu-content">
        <div class="menu-header sub-menu-header">
            <button id="backToMainMenuBtn" class="back-btn"><i class="fa-solid fa-angle-left"></i> FOOD</button>
            <button id="closeFoodMenuBtn" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <nav class="menu-nav sub-menu-nav">
            <a href="food_homepage.php" class="menu-item food-homepage">FOOD HOMEPAGE</a>
            
            <hr class="menu-divider-thin">

            <a href="new_in.php" class="menu-item link-with-tag">NEW IN <span class="new-tag">NEW</span></a>
            
            <a href="promotions.php" class="menu-item dropdown-toggle">PROMOTIONS <i class="fa-solid fa-angle-down"></i></a>
            <a href="daily_difference.php" class="menu-item">DAILY DIFFERENCE</a>

            <a href="fruit.php" class="menu-item dropdown-toggle">FRUIT, VEGETABLES & SALADS <i class="fa-solid fa-angle-down"></i></a>
            <a href="#" id="meatLink" class="menu-item dropdown-toggle">MEAT, POULTRY & FISH <i class="fa-solid fa-angle-right"></i></a> 
            <a href="milk.php" class="menu-item dropdown-toggle">MILK, DAIRY & EGGS <i class="fa-solid fa-angle-down"></i></a>
            <a href="ready_meals.php" class="menu-item dropdown-toggle">READY MEALS <i class="fa-solid fa-angle-down"></i></a>
            <a href="deli.php" class="menu-item dropdown-toggle">DELI & ENTERTAINING <i class="fa-solid fa-angle-down"></i></a>
            <a href="food_to_go.php" class="menu-item dropdown-toggle">FOOD TO GO <i class="fa-solid fa-angle-down"></i></a>
            <a href="bakery.php" class="menu-item dropdown-toggle">BAKERY <i class="fa-solid fa-angle-down"></i></a>
        </nav>
    </div>
</div>

<div id="meatMenuOverlay" class="side-menu-overlay third-level">
    <div class="side-menu-content">
        <div class="menu-header sub-menu-header">
            <button id="backToFoodMenuBtn" class="back-btn"><i class="fa-solid fa-angle-left"></i> MEAT, POULTRY & FISH</button>
            <button id="closeMeatMenuBtn" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <nav class="menu-nav sub-menu-nav">
            <a href="meat_all.php" class="menu-item sub-category-link">All Meat, Poultry & Fish</a>
            
            <hr class="menu-divider-thin">
            
            <a href="meat_poultry.php" class="menu-item sub-category-link">Poultry</a>
            <a href="meat_beef.php" class="menu-item sub-category-link">Beef</a>
            <a href="meat_pork.php" class="menu-item sub-category-link">Pork</a>
            <a href="meat_lamb.php" class="menu-item sub-category-link">Lamb</a>
            <a href="meat_halaal.php" class="menu-item sub-category-link">Halaal Fresh Meat</a>
        </nav>
    </div>
</div>