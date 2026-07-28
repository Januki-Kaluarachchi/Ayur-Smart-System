<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}


if (isset($_GET['approve_id'])) {
    $id = $_GET['approve_id'];

    $res = $conn->query("SELECT * FROM pending_products WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        $p_name = $row['product_name'];
        $desc = $row['description'];
        $price = $row['price'];
        $stock = $row['stock_quantity'];
        $img = $row['image_url'];
        
      
        $stmt = $conn->prepare("INSERT INTO product (product_name, description, price, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $p_name, $desc, $price, $stock, $img);
        $stmt->execute();
        $stmt->close();
   
        $conn->query("DELETE FROM pending_products WHERE id = $id");
        header("Location: admin_products_approve.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Product Approvals</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 30px; }
        table { width: 100%; border-collapse: collapse; background: #1b4332; margin-top: 20px; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background: #2d6a4f; }
        .btn-app { background: #2b9348; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>✅ Supplier Product Approvals</h2>
    <a href="admin_dashboard.php" style="color: #b7e4c7; text-decoration: none;">⬅️ Back to Dashboard</a>

    <table>
        <tr>
            <th>Supplier</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM pending_products WHERE status = 'Pending'");
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['supplier_name']}</td>
                <td>{$row['product_name']}</td>
                <td>Rs. {$row['price']}</td>
                <td>{$row['stock_quantity']}</td>
                <td><img src='{$row['image_url']}' width='50' style='border-radius: 5px;'></td>
                <td><a href='admin_products_approve.php?approve_id={$row['id']}' class='btn-app'>Approve</a></td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>