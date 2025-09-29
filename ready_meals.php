<?php
// ready_meals.php
session_start();
include 'database.php'; // Include the database connection file

// Check if the user is logged in (for personalized header)
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['user_firstName']) : 'Customer';

// --- Database Logic: Filter by Category ID (2) and JOIN images ---
$ready_meals_category_id = 2; // Assuming Category ID 2 is the correct ID for Ready Meals

// SQL JOIN: Select product details (p) and the main image URL (pi)
$sql = "SELECT 
            p.`product_id`, p.`name`, p.`price`, p.`description`, 
            pi.`image_url` AS main_image_url
        FROM 
            `products` p
        JOIN 
            `product_images` pi ON p.`product_id` = pi.`product_id` AND pi.`is_main` = TRUE
        WHERE 
            p.`category_id` = ? AND p.`is_active` = 1"; 

$stmt = $conn->prepare($sql);
if (!$stmt) {
    // Show a detailed error if the SQL statement itself is broken
    die("SQL Prepare failed: " . $conn->error);
}

// Assuming category_id is an integer (i)
$stmt->bind_param("i", $ready_meals_category_id);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Crucially, the image URL is now in the 'main_image_url' key
        $products[] = $row; 
    }
}
$itemCount = count($products);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ready Meals - Woolworths</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="ASSETS/css/style.css"> 
    <link rel="stylesheet" href="ASSETS/css/product_page.css"> 
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
        
        <div class="search-bar-container">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" placeholder="Search" class="search-input">
        </div>
        
        <div class="breadcrumb-container">
            <a href="index.php">Food</a> / <a href="ready_meals.php">Ready Meals</a> / <strong>READY MEALS</strong>
        </div>

        <div class="content-area product-list-page">
            
            <h1>READY MEALS</h1>
            
            <div class="category-banner">
                <img src="ASSETS/images/ready_meals_banner.png" alt="Ready Meals"> 
            </div>

            <div class="controls-bar">
                <div class="filter-dropdown">
                    <select><option>Filter</option></select>
                </div>
                <div class="sort-dropdown">
                    <select><option>Sort by: Sort by</option></select>
                </div>
            </div>
            
            <div class="info-bar">
                <span class="item-count"><?php echo $itemCount; ?> Items Found</span>
                <div class="view-toggle">
                    <i class="fa-solid fa-table-cells-large"></i> <i class="fa-solid fa-list"></i> 
                </div>
            </div>

            <div class="filter-category-buttons">
                <a href="#" class="filter-btn">Vegetarian</a>
                <a href="#" class="filter-btn active">Meat</a>
                <a href="#" class="filter-btn">Seafood</a>
                <a href="#" class="filter-btn">Pasta</a>
                <a href="#" class="filter-btn">Rice Dishes</a>
                <div class="see-more-btn">SEE MORE <i class="fa-solid fa-angle-down"></i></div>
            </div>
            
            <div class="product-grid">
                <?php if ($itemCount > 0): ?>
                    <?php foreach ($products as $product): ?>
                        
                        <a href="product_detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="product-card-link">
                            <div class="product-card">
                                <span class="save-tag">SAVE</span>
                                <img src="<?php echo htmlspecialchars($product['main_image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="product-details">
                                    <p class="product-name"><?php echo htmlspecialchars($product['name']); ?></p>
                                    <p class="product-price">R<?php echo number_format($product['price'], 2); ?></p>
                                    <button class="add-to-cart-btn">ADD</button>
                                </div>
                            </div>
                        </a>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No ready meals found.</p> 
                <?php endif; ?>
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

    <script src="ASSETS/js/menu.js"></script>
    <script src="ASSETS/js/cart.js"></script>
</body>
</html>