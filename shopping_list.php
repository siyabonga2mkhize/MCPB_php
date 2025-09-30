<?php
// shopping_list.php
session_start();
include 'database.php';

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Fetch wishlist items for the user
$sql_wishlist = "SELECT w.wishlist_id, p.name, p.price, p.image_url FROM wishlist w JOIN products p ON w.product_id = p.product_id WHERE w.user_id = ?";
$stmt_wishlist = $conn->prepare($sql_wishlist);

$wishlist_items = [];
if ($stmt_wishlist) {
    $stmt_wishlist->bind_param("i", $user_id);
    $stmt_wishlist->execute();
    $result_wishlist = $stmt_wishlist->get_result();

    while ($row = $result_wishlist->fetch_assoc()) {
        $wishlist_items[] = $row;
    }
    $stmt_wishlist->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping List - Woolworths</title>
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
            <a href="index.php">Home</a> / <strong>Shopping List</strong>
        </div>

        <div class="content-area">
            
            <h1>Your Wishlist</h1>
            
            <div class="wishlist-container">
                <?php if (empty($wishlist_items)): ?>
                    <p>Your wishlist is empty.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($wishlist_items as $item): ?>
                            <li>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <span><?php echo htmlspecialchars($item['name']); ?> - R <?php echo number_format($item['price'], 2); ?></span>
                                <form method="POST" action="remove_wishlist.php">
                                    <input type="hidden" name="wishlist_id" value="<?php echo $item['wishlist_id']; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script src="ASSETS/js/menu.js"></script>
</body>
</html>