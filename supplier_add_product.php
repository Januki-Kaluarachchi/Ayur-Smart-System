<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supplier') {
    header("Location: login.html");
    exit();
}

$supplier_username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Image upload handling
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO pending_products (supplier_name, product_name, description, price, stock_quantity, image_url, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("sssdss", $supplier_username, $product_name, $description, $price, $stock_quantity, $target_file);
        
        if ($stmt->execute()) {
            $success = "Product added successfully. Please wait for admin approval.";
        } else {
            $error = "Database Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Error uploading the product image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Supplier</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        .container { max-width: 600px; margin: auto; background: #1b4332; padding: 30px; border-radius: 10px; border: 1px solid #40916c; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; background: #081c15; border: 1px solid #40916c; color: white; border-radius: 5px; }
        button { background: #40916c; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .msg { color: #74c69d; margin-bottom: 15px; }
        .err { color: #ff6b6b; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Add New Product for Approval</h2>
        <?php if(isset($success)) echo "<p class='msg'>$success</p>"; ?>
        <?php if(isset($error)) echo "<p class='err'>$error</p>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Product Name</label>
            <input type="text" name="product_name" required>

            <label>Description</label>
            <textarea name="description" required></textarea>

            <label>Price (Rs.)</label>
            <input type="number" step="0.01" name="price" required>

            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" required>

            <label>Product Image</label>
            <input type="file" name="image" required>

            <button type="submit">Submit for Approval</button>
        </form>
        <br>
        <a href="supplier_dashboard.php" style="color: #b7e4c7; text-decoration: none;">⬅️ Back to Dashboard</a>
    </div>
</body>
</html>