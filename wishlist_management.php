<?php
// wishlist_management.php
session_start();
include 'database.php';

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Debugging: Log the received product_id
error_log("Received product_id: " . $_POST['product_id']);

// Check if product_id is provided and valid
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    error_log("Invalid product ID.");
    die("Invalid product ID.");
}

$product_id = intval($_POST['product_id']);

// Fetch existing lists for the user
$sql_fetch_lists = "SELECT list_id, name FROM wishlist_lists WHERE user_id = ?";
$stmt_fetch_lists = $conn->prepare($sql_fetch_lists);

$lists = [];
if ($stmt_fetch_lists) {
    $stmt_fetch_lists->bind_param("i", $user_id);
    $stmt_fetch_lists->execute();
    $result_lists = $stmt_fetch_lists->get_result();

    while ($row = $result_lists->fetch_assoc()) {
        $lists[] = $row;
    }
    $stmt_fetch_lists->close();
}

// Handle creating a new list
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_list'])) {
    $list_name = $_POST['list_name'];

    $sql_create_list = "INSERT INTO wishlist_lists (user_id, name) VALUES (?, ?)";
    $stmt_create_list = $conn->prepare($sql_create_list);

    if ($stmt_create_list) {
        $stmt_create_list->bind_param("is", $user_id, $list_name);
        $stmt_create_list->execute();
        $stmt_create_list->close();
        echo "<script>alert('List created successfully!'); window.location.href='wishlist_management.php';</script>";
    } else {
        echo "<script>alert('Failed to create list.'); window.location.href='wishlist_management.php';</script>";
    }
}

// Handle adding product to a list
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_list'])) {
    $list_id = intval($_POST['list_id']);

    // Validate product_id before adding to wishlist
    $sql_validate_product = "SELECT product_id FROM products WHERE product_id = ?";
    $stmt_validate_product = $conn->prepare($sql_validate_product);
    $product_exists = false;

    if ($stmt_validate_product) {
        $stmt_validate_product->bind_param("i", $product_id);
        $stmt_validate_product->execute();
        $result_validate_product = $stmt_validate_product->get_result();

        if ($result_validate_product->num_rows > 0) {
            $product_exists = true;
        }
        $stmt_validate_product->close();
    }

    if (!$product_exists) {
        die("Product does not exist or is unavailable.");
    }

    $sql_add_to_list = "INSERT INTO wishlist_items (list_id, product_id) VALUES (?, ?)";
    $stmt_add_to_list = $conn->prepare($sql_add_to_list);

    if ($stmt_add_to_list) {
        $stmt_add_to_list->bind_param("ii", $list_id, $product_id);
        $stmt_add_to_list->execute();
        $stmt_add_to_list->close();
        echo "<script>alert('Product added to list!'); window.location.href='wishlist_management.php';</script>";
    } else {
        echo "<script>alert('Failed to add product to list.'); window.location.href='wishlist_management.php';</script>";
    }
}

// Handle removing product from a list
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_list'])) {
    $list_id = intval($_POST['list_id']);

    $sql_remove_from_list = "DELETE FROM wishlist_items WHERE list_id = ? AND product_id = ?";
    $stmt_remove_from_list = $conn->prepare($sql_remove_from_list);

    if ($stmt_remove_from_list) {
        $stmt_remove_from_list->bind_param("ii", $list_id, $product_id);
        $stmt_remove_from_list->execute();
        $stmt_remove_from_list->close();
        echo "<script>alert('Product removed from list!'); window.location.href='wishlist_management.php';</script>";
    } else {
        echo "<script>alert('Failed to remove product from list.'); window.location.href='wishlist_management.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Management - Woolworths</title>
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
            <a href="index.php">Home</a> / <strong>Wishlist Management</strong>
        </div>

        <div class="content-area">
            
            <h1>Manage Your Wishlist</h1>
            
            <div class="create-list">
                <form method="POST">
                    <input type="text" name="list_name" placeholder="Enter list name" required>
                    <button type="submit" name="create_list">Create List</button>
                </form>
            </div>

            <div class="existing-lists">
                <h2>Your Lists</h2>
                <?php if (empty($lists)): ?>
                    <p>You have no lists. Create one above.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($lists as $list): ?>
                            <li>
                                <span><?php echo htmlspecialchars($list['name']); ?></span>
                                <form method="POST">
                                    <input type="hidden" name="list_id" value="<?php echo $list['list_id']; ?>">
                                    <button type="submit" name="add_to_list">Add Product</button>
                                    <button type="submit" name="remove_from_list">Remove Product</button>
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