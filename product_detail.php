<?php
// product_detail.php
session_start();
include 'database.php'; // Use the now-working database.php with the port/password fix

// Check if the product ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // If no ID or invalid ID, redirect or show an error
    die("Product ID is missing or invalid.");
}

$product_id = intval($_GET['id']);
$product = null;
$product_images = [];

// --- 1. Fetch Product Details (Name, Price, Description, etc.) ---
// Note: We use LEFT JOIN here just in case a product is created without a category (though it shouldn't happen)
$sql_product = "SELECT 
    p.`product_id`, p.`name`, p.`price`, p.`description`, 
    p.`image_url` AS default_image, p.`unit`, p.`discounted_price`,
    c.`name` AS category_name
FROM 
    `products` p
LEFT JOIN
    `categories` c ON p.`category_id` = c.`category_id`
WHERE 
    p.`product_id` = ? AND p.`is_active` = 1"; 

$stmt_product = $conn->prepare($sql_product);
if (!$stmt_product) {
    die("SQL Prepare failed for product: " . $conn->error);
}

$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$result_product = $stmt_product->get_result();

if ($result_product->num_rows > 0) {
    $product = $result_product->fetch_assoc();
} else {
    // Product not found or inactive
    die("Product not found or is currently unavailable.");
}
$stmt_product->close();

// --- 2. Fetch All Associated Images ---
$sql_images = "SELECT 
    `image_url`, `is_main`
FROM 
    `product_images`
WHERE 
    `product_id` = ?
ORDER BY 
    `is_main` DESC, `image_id` ASC"; 

$stmt_images = $conn->prepare($sql_images);
if (!$stmt_images) {
    die("SQL Prepare failed for images: " . $conn->error);
}

$stmt_images->bind_param("i", $product_id);
$stmt_images->execute();
$result_images = $stmt_images->get_result();

while($row = $result_images->fetch_assoc()) {
    $product_images[] = $row;
}
$stmt_images->close();

$conn->close();

// Check if product was actually found before proceeding to HTML
if ($product === null) {
    die("Product not found or is currently unavailable.");
}

// Extract the price per kg/unit from the product name/description if needed, 
// for now we'll use a placeholder based on your example
$price_per_unit_display = "R 269.99/kg"; // Placeholder based on example image

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    <link rel="stylesheet" href="ASSETS/css/product_detail.css"> 
    <style>
        /* Minimal CSS for product detail layout to mimic the image */
        .product-detail-container { padding: 15px; max-width: 600px; margin: 0 auto; }
        .product-image-carousel { position: relative; margin-bottom: 20px; }
        .product-image-carousel img { width: 100%; height: auto; display: block; }
        .price-details { font-size: 1.5em; font-weight: bold; margin-bottom: 5px; }
        .price-per-unit { font-size: 0.9em; font-weight: normal; color: #555; }
        .qty-controls { display: flex; align-items: center; justify-content: space-between; margin-top: 20px; }
        .qty-dropdown, .add-to-cart-btn { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .add-to-cart-btn { background-color: #007041; color: white; border: none; font-weight: bold; width: 60%; text-align: center; }
        .store-availability, .shopping-list { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px; }
        .store-availability i, .shopping-list i { margin-right: 10px; color: #555; }
        .view-btn, .add-btn { background: white; color: black; border: 1px solid black; padding: 8px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="app-container">
        
    <header class="main-header">
            <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span>
        </a> 
        <div class="header-icons">
                            <a href="<?php echo $isLoggedIn ? 'profile.php' : 'login.php'; ?>" class="icon-link"><i class="fa-regular fa-user"></i>
                        </a>
                            <a href="cart.php" class="icon-link shopping-cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="cart-count">0</span> 
                            </a>
                            <button class="menu-btn"><i class="fa-solid fa-bars"></i></button>
                        </div>
                    </header>
        <div class="search-bar-container">...</div>
        
        <div class="breadcrumb-container">
            <a href="index.php">Food</a> / <a href="meat.php">Meat, Poultry & Fish</a> / <a href="meat_beef.php">BEEF</a> / <strong><?php echo htmlspecialchars($product['name']); ?></strong>
        </div>

        <div class="product-detail-container">
            
            <span class="save-tag">SAVE</span>

            <div class="product-image-carousel">
                <?php 
                $main_image_url = $product['default_image'] ?? ($product_images[0]['image_url'] ?? 'ASSETS/images/placeholder.png');
                ?>
                <img src="<?php echo htmlspecialchars($main_image_url); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <i class="fa-solid fa-share-alt" style="position: absolute; bottom: 10px; right: 10px; background: white; padding: 5px; border-radius: 50%;"></i>
            </div>
            
            <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <div class="price-details">
                R<?php echo number_format($product['price'], 2); ?>
                <span class="price-per-unit">(R<?php echo htmlspecialchars($price_per_unit_display); ?>)</span>
            </div>
            
            <div class="qty-controls">
                <select class="qty-dropdown" title="Quantity">
                    <option>Qty</option>
                    <option>1</option>
                    <option>2</option>
                    </select>
                <button class="add-to-cart-btn">ADD TO CART</button>
            </div>
            
            <div class="store-availability">
                <span><i class="fa-solid fa-location-dot"></i>Check In-Store Availability</span>
                <button class="view-btn">VIEW</button>
            </div>
            
            <div class="shopping-list">
                <span><i class="fa-solid fa-list-ul"></i>Add to Shopping List</span>
                <!-- Redirect to wishlist management page when 'ADD' button is clicked -->
<form method="POST" action="wishlist_management.php">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
    <button class="add-btn" name="manage_wishlist">ADD</button>
</form>
            </div>

        </div> 
        <div id="sideMenu" class="side-menu-overlay">
        <div class="side-menu-content">
            <div class="menu-header">
                <span class="logo">WOOLWORTHS</span>
                <button id="closeMenuBtn" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <nav class="menu-nav">
                <a href="food.php" id="foodLink" class="menu-item">FOOD <i class="fa-solid fa-angle-right"></i></a> 
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
                    <a href="registration.php" class="menu-item">REGISTER</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <div id="foodMenu" class="side-menu-overlay second-level">
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
                <a href="meat.php" id="meatLink" class="menu-item dropdown-toggle">MEAT, POULTRY & FISH <i class="fa-solid fa-angle-down"></i></a> 
                <a href="milk.php" class="menu-item dropdown-toggle">MILK, DAIRY & EGGS <i class="fa-solid fa-angle-down"></i></a>
                <a href="ready_meals.php" class="menu-item dropdown-toggle">READY MEALS <i class="fa-solid fa-angle-down"></i></a>
                <a href="deli.php" class="menu-item dropdown-toggle">DELI & ENTERTAINING <i class="fa-solid fa-angle-down"></i></a>
                <a href="food_to_go.php" class="menu-item dropdown-toggle">FOOD TO GO <i class="fa-solid fa-angle-down"></i></a>
                <a href="bakery.php" class="menu-item dropdown-toggle">BAKERY <i class="fa-solid fa-angle-down"></i></a>
            </nav>
        </div>
    </div>
    
    <div id="meatMenu" class="side-menu-overlay third-level">
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
        </div>w
    </div>

    <script src="ASSETS/js/menu.js"></script>
    <script src="ASSETS/js/cart.js"></script>
    </div>

</body>
</html>