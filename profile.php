<?php
// profile.php

// 1. START SESSION AND CHECK AUTHENTICATION
session_start();

$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

// If the user is NOT logged in, redirect them to the index page (or login page)
if (!$isLoggedIn) {
    // For a better UX, redirect to login page with a message, but index.php is fine too
    header("Location: index.php"); 
    exit();
}

// 2. RETRIEVE USER DATA FROM SESSION
$user = [
    'firstName' => htmlspecialchars($_SESSION['user_firstName'] ?? 'Siyabonga'),
    'lastName' => htmlspecialchars($_SESSION['user_lastName'] ?? 'Zulu'),
    'email' => htmlspecialchars($_SESSION['user_email'] ?? 'siyabonga.zulu@example.com'),
    'phone' => htmlspecialchars($_SESSION['user_phone'] ?? '083 123 4567'),
    'address' => htmlspecialchars($_SESSION['user_address'] ?? '100 Main Road, Cape Town, 8001'),
];

// Determine the greeting
$userName = $user['firstName'];

// Check for successful update message passed via session flash (optional)
$successMessage = $_SESSION['update_success_message'] ?? '';
unset($_SESSION['update_success_message']); // Clear the message after displaying
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - <?php echo $userName; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
</head>
<body>

    <div class="page-wrapper">
        <div class="app-container">
            
            <header class="main-header">
                <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
                <div class="header-icons">
                    <a href="profile.php" class="icon-link"><i class="fa-solid fa-user"></i></a>
                    <a href="cart.php" class="icon-link shopping-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count">3</span>
                    </a>
                    <button id="openMenuBtn" class="menu-btn"><i class="fa-solid fa-bars"></i></button>
                </div>
            </header>
            
            <div class="content-area profile-area">
                
                <h1 class="page-title">My Account</h1>
                <p class="page-subtitle">Welcome, **<?php echo $userName; ?>**! Manage your profile details below.</p>
                
                <?php if ($successMessage): ?>
                    <div class="alert success-alert">
                        <?php echo $successMessage; ?>
                    </div>
                <?php endif; ?>

                <form id="profileUpdateForm" action="API/update_profile.php" method="POST" class="form-container profile-form">
                    
                    <h2 class="section-heading">Personal Details</h2>

                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>" required>

                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>" required>

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
                    <p class="input-hint">To change your email, please contact customer service.</p>

                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
                    
                    <div class="form-action-group">
                        <button type="submit" id="updateDetailsBtn" class="black-button-style profile-update-btn">
                            SAVE DETAILS
                        </button>
                    </div>
                </form>

                <hr class="profile-divider">

                <div class="profile-link-group">
                    <h2 class="section-heading">Security & Address</h2>
                    
                    <a href="change_password.php" class="profile-management-link">
                        Change Password <i class="fa-solid fa-angle-right"></i>
                    </a>

                    <a href="manage_addresses.php" class="profile-management-link">
                        Manage Addresses <i class="fa-solid fa-angle-right"></i>
                    </a>
                </div>

                <hr class="profile-divider">

                <div class="profile-logout-area">
                    <a href="logout.php" class="white-button logout-button">LOGOUT</a>
                </div>

            </div>
            
        </div>
        
        <?php include 'partials/side_menus.php'; ?>
        
    </div>

    <footer class="site-footer">
        <div class="container footer-content-wrapper">
            <div class="footer-sections">
                
                <div class="footer-column">
                    <h4 class="footer-heading">MY ACCOUNT</h4>
                    <ul class="footer-links">
                        <li><a href="profile.php">My Account</a></li>
                        <li><a href="orders.php">Orders</a></li>
                        <li><a href="shopping_list.php">Shopping Lists</a></li>
                        <li><a href="account_details.php">Account Details</a></li>
                        <li><a href="link_card.php">Link a Card</a></li> </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-heading">CUSTOMER SERVICE</h4>
                    <ul class="footer-links">
                        <li><a href="faq.php">FAQ's</a></li>
                        <li><a href="using_woolworths.php">Using Woolworths</a></li>
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
    <script>
        // Profile Update Form Logic
        document.getElementById('profileUpdateForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitButton = document.getElementById('updateDetailsBtn');

            submitButton.disabled = true;
            submitButton.textContent = 'SAVING...';

            // Send data to server endpoint
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profile updated successfully!');
                    // Reload to update the PHP session variables and the greeting on the page
                    window.location.reload(); 
                } else {
                    alert('Update failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Update Error:', error);
                alert('A network error occurred during the update.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'SAVE DETAILS';
            });
        });


        // ===========================================
        // Multi-Level Side Menu Logic (Replicated from index.php)
        // ===========================================
        const mainMenuOverlay = document.getElementById('mainMenuOverlay'); 
        const foodMenuOverlay = document.getElementById('foodMenuOverlay');   
        const meatMenuOverlay = document.getElementById('meatMenuOverlay');   
        const openMenuBtn = document.getElementById('openMenuBtn');          
        const body = document.body;

        const closeMainMenuBtn = document.getElementById('closeMainMenuBtn');
        const foodLinkInMainMenu = document.getElementById('foodLink'); 

        const backToMainMenuBtn = document.getElementById('backToMainMenuBtn');
        const closeFoodMenuBtn = document.getElementById('closeFoodMenuBtn');
        const meatLinkInFoodMenu = document.getElementById('meatLink');

        const backToFoodMenuBtn = document.getElementById('backToFoodMenuBtn');
        const closeMeatMenuBtn = document.getElementById('closeMeatMenuBtn');
        
        const allMenuLinks = document.querySelectorAll('.menu-nav a[href]:not([href="#"])');

        function closeAllMenus() {
            mainMenuOverlay?.classList.remove('active');
            foodMenuOverlay?.classList.remove('active');
            meatMenuOverlay?.classList.remove('active');
            body.classList.remove('menu-open'); 
        }

        function openMainMenu() {
            closeAllMenus(); 
            mainMenuOverlay?.classList.add('active');
            body.classList.add('menu-open'); 
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

        // 1. Level 1 (Main Menu) Controls
        openMenuBtn?.addEventListener('click', openMainMenu);
        closeMainMenuBtn?.addEventListener('click', closeAllMenus);

        // Close when clicking the semi-transparent overlay (L1)
        mainMenuOverlay?.addEventListener('click', function(e) {
            if (e.target === mainMenuOverlay) { closeAllMenus(); }
        });

        // 2. Level 2 (Food Menu) Controls
        foodLinkInMainMenu?.addEventListener('click', function(e) {
            e.preventDefault(); 
            openFoodMenu();
        });

        backToMainMenuBtn?.addEventListener('click', function() {
            openMainMenu();
        });

        closeFoodMenuBtn?.addEventListener('click', closeAllMenus);

        foodMenuOverlay?.addEventListener('click', function(e) {
            if (e.target === foodMenuOverlay) { closeAllMenus(); }
        });

        // 3. Level 3 (Meat Menu) Controls
        meatLinkInFoodMenu?.addEventListener('click', function(e) {
            e.preventDefault(); 
            openMeatMenu();
        });
        
        backToFoodMenuBtn?.addEventListener('click', function() {
            openFoodMenu(); 
        });

        closeMeatMenuBtn?.addEventListener('click', closeAllMenus);

        meatMenuOverlay?.addEventListener('click', function(e) {
            if (e.target === meatMenuOverlay) { closeAllMenus(); }
        });

        // D. Handle Clicks on all final Category links to ensure menus close
        allMenuLinks.forEach(link => {
            link.addEventListener('click', closeAllMenus);
        });
        
        // Close on ESC key for any menu
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeAllMenus(); }
        });
    </script>
</body>
</html> 