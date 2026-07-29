<?php
session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}


if (isset($_GET['approve_id'])) {
    $id = intval($_GET['approve_id']);
    

    $result = $conn->query("SELECT * FROM pending_products WHERE id = $id");
    if ($result->num_rows > 0) {
        $prod = $result->fetch_assoc();
        $name = $prod['product_name'];
        $desc = $prod['description'];
        $price = $prod['price'];
        $qty = $prod['stock_quantity'];
        $image = $prod['product_image'];

   
        $stmt = $conn->prepare("INSERT INTO product (product_name, description, price, stock_quantity, product_image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $name, $desc, $price, $qty, $image);
        $stmt->execute();

       
        $conn->query("DELETE FROM pending_products WHERE id = $id");
    }
    header("Location: manage_products.php");
    exit();
}


if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM pending_products WHERE id = $id");
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Product Requests - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 30px; }
        .container { max-width: 1000px; margin: auto; }
        .card { background: #1b4332; padding: 20px; border-radius: 10px; border: 1px solid #40916c; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background: #2d6a4f; }
        .action-btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; color: white; font-size: 0.85rem; margin-right: 5px; font-weight: bold; }
        .approve-btn { background: #2b9348; }
        .delete-btn { background: #d90429; }
        .back-btn { background: #555; display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>
        <h2>Pending Product Requests 🏷️</h2>

        <div class="card">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price (Rs.)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM pending_products");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['description']}</td>
                            <td>Rs. {$row['price']}</td>
                            <td>{$row['stock_quantity']}</td>
                            <td>
                                <a href='manage_products.php?approve_id={$row['id']}' class='action-btn approve-btn'>Approve</a>
                                <a href='manage_products.php?delete_id={$row['id']}' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to reject/delete this product?\")'>Reject</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center; color: #74c69d;'>No pending product requests found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>