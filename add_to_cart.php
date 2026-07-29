<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check if cart already exists in session
    if (isset($_SESSION['cart'][$product_id])) {
        // Update quantity if item already in cart
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Add new item to cart
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    // Redirect back to cart page
    header("Location: cart.php");
    exit();
}
?>