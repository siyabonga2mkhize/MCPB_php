<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolworths - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
</head>
<body>

    <div class="app-container">
        
        <header class="app-header">
            <div class="logo-text">WOOLWORTHS</div>
            <nav class="header-icons">
                
                <a href="login.php" id="headerProfileLink" class="icon-link">
                    <i class="fa-solid fa-user"></i>
                </a>
                
                <a href="#" class="icon-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count">3</span> 
                </a>
                
                <a href="#" class="icon-link">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </nav>
        </header>

        <div class="search-bar-container">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for groceries or products">
        </div>

        <main class="home-page-content">
            
            <section class="home-content">
                <h1 id="welcomeMessage">Hello, Welcome to Woolworths!</h1>
                <p id="callToAction">Please sign in or register to manage your account details.</p>
                
                <div id="authButtons" class="button-group">
                    <a href="login.php" class="black-button">SIGN IN</a>
                    <a href="register.php" class="grey-button">REGISTER</a>
                </div>
                
                <div id="loggedInContent" class="hidden-content">
                    <p>Welcome back! Check out today's personalized specials.</p>
                    <button class="black-button" onclick="window.location.href='profile.html'">View My Profile</button>
                </div>
            </section>
            
            <section class="promo-banner">
                <img src="ASSETS/images/banner-placeholder.jpg" alt="Spring Sale Banner" class="banner-image">
                <div class="banner-overlay">
                    <h2 class="promo-text">BIG Spring Savings!</h2>
                    <button class="promo-button">Shop Now</button>
                </div>
                <div class="dot-indicators">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </section>

            <section class="category-section">
                <h3 class="section-title">Shop by Category</h3>
                <div class="category-scroll-container">
                    <a href="#" class="category-item">
                        <div class="category-circle"><i class="fa-solid fa-apple-whole"></i></div>
                        <span class="category-label">Fresh Produce</span>
                    </a>
                    <a href="#" class="category-item">
                        <div class="category-circle"><i class="fa-solid fa-bread-slice"></i></div>
                        <span class="category-label">Bakery</span>
                    </a>
                    <a href="#" class="category-item">
                        <div class="category-circle"><i class="fa-solid fa-mug-hot"></i></div>
                        <span class="category-label">Drinks</span>
                    </a>
                    <a href="#" class="category-item">
                        <div class="category-circle"><i class="fa-solid fa-plate-wheat"></i></div>
                        <span class="category-label">Ready Meals</span>
                    </a>
                    <a href="#" class="category-item">
                        <div class="category-circle"><i class="fa-solid fa-shirt"></i></div>
                        <span class="category-label">Clothing</span>
                    </a>
                </div>
            </section>
            
            <footer class="app-footer">
                <div class="footer-accordion">
                    <div class="accordion-item">
                        <h3 class="accordion-header">MY ACCOUNT</h3>
                        <div class="accordion-content">
                            <ul>
                                <li><a href="login.php">Sign in/Register</a></li>
                                <li><a href="#">Orders</a></li>
                                <li><a href="#">Shopping Lists</a></li>
                                <li><a href="profile.html">Account Details</a></li>
                                <li><a href="#">Link a Card</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header">CUSTOMER SERVICE</h3>
                        <div class="accordion-content">
                            <ul>
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Using Woolworths Online</a></li>
                                <li><a href="#">Delivery Options</a></li>
                                <li><a href="#">Returns and Exchanges</a></li>
                                <li><a href="#">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header">ABOUT WOOLWORTHS</h3>
                        <div class="accordion-content">
                            <ul>
                                <li><a href="#">Store Locator</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="footer-static-section">
                    <h4>GET REWARDED WITH MYDIFFERENCE</h4>
                    <p>Placeholder for reward program details.</p>
                </div>

                <div class="footer-static-section">
                    <h4>FOLLOW US ON</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <p class="copyright">&copy; 2025 Woolworths App</p>
            </footer>
        
        </main> 
    </div> 

    <div id="registrationSuccessModal" class="modal-overlay hidden-content">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Successful Registration</h2>
                <a href="#" class="close-btn" onclick="hideSuccessModal()"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <div class="modal-body">
                <p>You can link Woolworths store and credit cards to your profile in the My Account section for quick and simple payments and to earn discounts on your purchases.</p>
            </div>
            <div class="modal-footer">
                <button id="continueShoppingBtn" class="white-button">CONTINUE SHOPPING</button>
                <button id="goToMyAccountsBtn" class="black-button">GO TO MY ACCOUNTS</button>
            </div>
        </div>
    </div>
    
    <script src="ASSETS/js/login.js"></script>
    
    <script>
        // --- HOME PAGE LOGIC (Login State and Success Modal) ---
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Get elements
            const welcomeMsg = document.getElementById('welcomeMessage');
            const callToAction = document.getElementById('callToAction');
            const authButtons = document.getElementById('authButtons');
            const profileLink = document.getElementById('headerProfileLink'); 
            const loggedInContent = document.getElementById('loggedInContent');

            // 2. Check login status (using function from login.js)
            const user = getLoggedInUser();

            if (user && user.isLoggedIn) {
                // LOGGED IN STATE
                profileLink.href = 'profile.html'; 
                welcomeMsg.textContent = `Welcome back, ${user.firstName || user.email.split('@')[0]}!`;
                callToAction.style.display = 'none';
                authButtons.style.display = 'none';
                loggedInContent.classList.remove('hidden-content');
                
            } else {
                // LOGGED OUT STATE
                profileLink.href = 'login.php'; 
                welcomeMsg.textContent = 'Hello, Welcome to Woolworths!';
                callToAction.style.display = 'block';
                authButtons.style.display = 'flex';
                loggedInContent.classList.add('hidden-content');
            }
            
            // 3. Check for Registration Success URL flag
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('showSuccess') === 'true') {
                const modal = document.getElementById('registrationSuccessModal');
                if (modal) {
                    modal.classList.remove('hidden-content');
                    // Clean up URL parameter to prevent modal showing on refresh
                    history.replaceState(null, '', window.location.pathname);
                }
            }
            
            // --- FOOTER ACCORDION LOGIC ---
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    const isActive = header.classList.contains('active');

                    // Close all other open accordions
                    accordionHeaders.forEach(h => {
                        if (h !== header && h.classList.contains('active')) {
                            h.classList.remove('active');
                            h.nextElementSibling.style.maxHeight = 0;
                        }
                    });

                    // Toggle the clicked accordion
                    if (isActive) {
                        header.classList.remove('active');
                        content.style.maxHeight = 0;
                    } else {
                        header.classList.add('active');
                        // Set maxHeight to the scrollHeight to allow smooth CSS transition
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            });
        });
    </script>
</body>
</html>