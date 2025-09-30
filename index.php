<?php
// index.php - Complete file
// Start the session at the very top of the page
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['user_firstName']) : 'Woolworths Customer';

// Check for the registration success flag in the URL
$showSuccessModal = isset($_GET['showSuccess']) && $_GET['showSuccess'] === 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Assets/CSS/style.css"> 
</head>
<body>

    <div class="page-wrapper">
        <div class="app-container">
            
            <header class="main-header">
                <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
                <div class="header-icons">
                    <a href="<?php echo $isLoggedIn ? 'profile.php' : 'login.php'; ?>" class="icon-link"><i class="fa-regular fa-user"></i></a>
                    <a href="cart.php" class="icon-link shopping-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count">3</span>
                    </a>
                    <button id="openMenuBtn" class="menu-btn"><i class="fa-solid fa-bars"></i></button>
                </div>
            </header>
            
            <div class="search-bar-container">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" placeholder="Search" class="search-input">
            </div>
            
            <div class="content-area">
    <div class="welcome-area">
        <?php if ($isLoggedIn): ?>
            <h1 class="welcome-heading">Hello, Welcome Back, <?php echo $userName; ?>!</h1>
            
            <p class="welcome-text">Manage your account, view your orders, or continue shopping.</p>
            
            <div class="welcome-actions">
                <a href="profile.php" class="account-button black-button-style">MY ACCOUNT</a>
                
                <a href="logout.php" class="logout-button-index white-button">LOGOUT</a>
            </div>
        <?php else: ?>
            <h1 class="welcome-heading">Hello, Welcome to Woolworths!</h1>
            
            <p class="welcome-text">Please sign in or register to manage your account details.</p>
            
            <div class="guest-auth-actions">
                <a href="login.php" class="black-button-style">SIGN IN</a>
                
                <a href="register.php" class="black-button-style white-button">REGISTER</a>
            </div>
        <?php endif; ?>
    </div>
    
    </div>
            
        </div>
        
        <?php if ($showSuccessModal): ?>
        <div id="successModal" class="modal-overlay">
            <div class="modal-content">
                <a href="index.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <h2>Successful Registration</h2>
                <p>You can link Woolworth store and credit cards to your profile in the My Account section for quick and simple payments and to earn discounts on your purchases.</p>
                
                <div class="modal-footer button-group space-between">
                    <a href="index.php" class="white-button half-width-btn">CONTINUE SHOPPING</a>
                    <a href="profile.php" class="black-button half-width-btn">GO TO MY ACCOUNTS</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div id="mainMenuOverlay" class="side-menu-overlay">
            <div class="side-menu-content">
                <div class="menu-header">
                    <span class="logo">WOOLWORTHS</span>
                    <button id="closeMainMenuBtn" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
                </div>
                
                <nav class="menu-nav">
                    <a href="#" id="foodLink" class="menu-item">FOOD <i class="fa-solid fa-angle-right"></i></a> 
                    <a href="women.php" class="menu-item">WOMEN <i class="fa-solid fa-angle-right"></i></a>
                    <a href="men.php" class="menu-item">MEN <i class="fa-solid fa-angle-right"></i></a>
                    
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

                    <a href="#" id="meatLink" class="menu-item dropdown-toggle">MEAT, POULTRY & FISH <i class="fa-solid fa-angle-right"></i></a>
                    <a href="ready_meals.php" class="menu-item dropdown-toggle">READY MEALS <i class="fa-solid fa-angle-down"></i></a>
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
                </nav>
            </div>
        </div>

        <script>
            // ===========================================
            // Multi-Level Side Menu Logic (L1, L2, L3)
            // ===========================================

            // --- COMMON ELEMENTS ---
            const mainMenuOverlay = document.getElementById('mainMenuOverlay'); // L1 Main Overlay
            const foodMenuOverlay = document.getElementById('foodMenuOverlay');   // L2 Food Overlay
            const meatMenuOverlay = document.getElementById('meatMenuOverlay');   // L3 Meat Overlay
            const openMenuBtn = document.getElementById('openMenuBtn');        // The hamburger icon in the header
            const body = document.body;

            // --- L1 CONTROLS ---
            const closeMainMenuBtn = document.getElementById('closeMainMenuBtn');
            const foodLinkInMainMenu = document.getElementById('foodLink'); 

            // --- L2 CONTROLS (FOOD) ---
            const backToMainMenuBtn = document.getElementById('backToMainMenuBtn');
            const closeFoodMenuBtn = document.getElementById('closeFoodMenuBtn');
            const meatLinkInFoodMenu = document.getElementById('meatLink');

            // --- L3 CONTROLS (MEAT) ---
            const backToFoodMenuBtn = document.getElementById('backToFoodMenuBtn');
            const closeMeatMenuBtn = document.getElementById('closeMeatMenuBtn');
            
            // Get all final links across all menus (to close menu upon navigation)
            const allMenuLinks = document.querySelectorAll('.menu-nav a[href]:not([href="#"])');

            // --- TOGGLE FUNCTIONS ---

            function closeAllMenus() {
                mainMenuOverlay?.classList.remove('active');
                foodMenuOverlay?.classList.remove('active');
                meatMenuOverlay?.classList.remove('active');
                body.classList.remove('menu-open'); // Remove body overflow lock
            }

            function openMainMenu() {
                closeAllMenus(); // Ensure others are closed
                mainMenuOverlay?.classList.add('active');
                body.classList.add('menu-open'); // Add body overflow lock
            }

            function openFoodMenu() {
                mainMenuOverlay?.classList.remove('active'); 
                meatMenuOverlay?.classList.remove('active'); 
                foodMenuOverlay?.classList.add('active'); 
                body.classList.add('menu-open');
            }
            
            function openMeatMenu() {
                foodMenuOverlay?.classList.remove('active'); 
                meatMenuOverlay?.classList.add('active'); 
                body.classList.add('menu-open');
            }

            // --- EVENT LISTENERS ---
            
            // 1. Level 1 (Main Menu) Controls
            openMenuBtn?.addEventListener('click', openMainMenu);
            closeMainMenuBtn?.addEventListener('click', closeAllMenus);

            // Close when clicking the semi-transparent overlay (L1)
            mainMenuOverlay?.addEventListener('click', function(e) {
                if (e.target === mainMenuOverlay) {
                    closeAllMenus();
                }
            });

            // 2. Level 2 (Food Menu) Controls
            
            // A. Open Food menu from Main Menu
            foodLinkInMainMenu?.addEventListener('click', function(e) {
                e.preventDefault(); 
                openFoodMenu();
            });

            // B. Back button on Food Menu (L2 -> L1)
            backToMainMenuBtn?.addEventListener('click', function() {
                openMainMenu();
            });

            // C. Close button on Food Menu (L2 -> Close All)
            closeFoodMenuBtn?.addEventListener('click', closeAllMenus);

            // Close when clicking the semi-transparent overlay (L2)
            foodMenuOverlay?.addEventListener('click', function(e) {
                if (e.target === foodMenuOverlay) {
                    closeAllMenus();
                }
            });

            // 3. Level 3 (Meat Menu) Controls
            
            // A. Open Meat menu from Food Menu
            meatLinkInFoodMenu?.addEventListener('click', function(e) {
                e.preventDefault(); 
                openMeatMenu();
            });
            
            // B. Back button on Meat Menu (L3 -> L2)
            backToFoodMenuBtn?.addEventListener('click', function() {
                openFoodMenu(); 
            });

            // C. Close button on Meat Menu (L3 -> Close All)
            closeMeatMenuBtn?.addEventListener('click', closeAllMenus);

            // Close when clicking the semi-transparent overlay (L3)
            meatMenuOverlay?.addEventListener('click', function(e) {
                if (e.target === meatMenuOverlay) {
                    closeAllMenus();
                }
            });

            // D. Handle Clicks on all final Category links to ensure menus close
            allMenuLinks.forEach(link => {
                link.addEventListener('click', closeAllMenus);
            });
            
            // Optional: Close on ESC key for any menu
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllMenus();
                }
            });
            
            // --- SUCCESS MODAL LOGIC (Existing) ---
            const modal = document.getElementById('successModal');
            if (modal) {
                // Clean up URL to remove ?showSuccess=true after a short delay
                setTimeout(() => {
                    if (window.history.replaceState) {
                        const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                        window.history.replaceState({path: cleanUrl}, '', cleanUrl);
                    }
                }, 500);
                
                // Close modal if clicking outside the content
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        // Use location.replace for cleaner history on close
                        window.location.replace('index.php'); 
                    }
                });
            }
        </script>
    </div> <footer class="site-footer">
        <div class="container footer-content-wrapper">
            <div class="footer-sections">
                
                <div class="footer-column">
                    <h4 class="footer-heading">MY ACCOUNT</h4>
                    <ul class="footer-links">
                        <li><a href="login.php">Sign in/Register</a></li>
                        <li><a href="orders.php">Orders</a></li>
                        <li><a href="shopping_list.php">Shopping Lists</a></li>
                        <li><a href="profile.php">Account Details</a></li>
                        <li><a href="link_card.php">Link a Card</a></li> </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-heading">CUSTOMER SERVICE</h4>
                    <ul class="footer-links">
                        <li><a href="faq.php">FAQ's</a></li>
                        <li><a href="delivery_options.php">Delivery Options</a></li>
                        <li><a href="returns.php">Returns and Exchanges</a></li>
                        <li><a href="terms.php">Terms & Conditions</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-heading">ABOUT WOOLWORTHS</h4>
                    <ul class="footer-links">
                        <li><a href="stores.php">Stores</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="about.php">About Us</a></li>
                    </ul>
                </div>

                <div class="footer-column footer-cards-social">
                    <h4 class="footer-heading">GET THE CARD</h4>
                    <div class="card-logos">
                        <img src="assets/images/card_w.png" alt="Card W" class="card-img">
                        <img src="assets/images/card_revolving.png" alt="Revolving Card" class="card-img">
                    </div>
                    
                    <h4 class="footer-heading rewards-heading">GET REWARDED WITH</h4>
                    <div class="reward-logo">
                        <img src="assets/images/my_difference.png" alt="My Difference Logo" class="my-difference-img">
                    </div>

                    <h4 class="footer-heading social-heading">FOLLOW US ON</h4>
                    <div class="social-links">
                        <a href="https://facebook.com/woolworths" target="_blank">F</a>
                        <a href="https://twitter.com/woolworths" target="_blank">T</a>
                        <a href="https://pinterest.com/woolworths" target="_blank">P</a>
                        <a href="https://instagram.com/woolworths" target="_blank">I</a>
                        <a href="https://youtube.com/woolworths" target="_blank">Y</a>
                        <a href="https://tiktok.com/woolworths" target="_blank">K</a>
                    </div>
                </div>

            </div>

            <div class="footer-legal">
                <p>&copy; <?php echo date("Y"); ?> Woolworths. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>