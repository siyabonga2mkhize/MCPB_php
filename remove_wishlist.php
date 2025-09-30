<?php
// remove_wishlist.php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_id'])) {
    $wishlist_id = intval($_POST['wishlist_id']);

    $sql_remove_wishlist = "DELETE FROM wishlist WHERE wishlist_id = ?";
    $stmt_remove_wishlist = $conn->prepare($sql_remove_wishlist);

    if ($stmt_remove_wishlist) {
        $stmt_remove_wishlist->bind_param("i", $wishlist_id);
        $stmt_remove_wishlist->execute();
        $stmt_remove_wishlist->close();
        echo "<script>alert('Item removed from wishlist!'); window.location.href='shopping_list.php';</script>";
    } else {
        echo "<script>alert('Failed to remove item from wishlist.'); window.location.href='shopping_list.php';</script>";
    }
}

$conn->close();
?>