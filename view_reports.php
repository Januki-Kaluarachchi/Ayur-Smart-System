<?php
session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$customer_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'customer'")->fetch_assoc()['count'];
$supplier_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'supplier'")->fetch_assoc()['count'];
$product_count = $conn->query("SELECT COUNT(*) as count FROM product")->fetch_assoc()['count'];
$pending_product_count = $conn->query("SELECT COUNT(*) as count FROM pending_products")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Reports - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        .container { max-width: 800px; margin: auto; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: #1b4332; padding: 25px; border-radius: 10px; border: 1px solid #40916c; text-align: center; }
        .card h3 { margin: 0; font-size: 1.1rem; color: #b7e4c7; }
        .card p { font-size: 2rem; font-weight: bold; margin: 15px 0 0 0; color: white; }
        .btn { background: #40916c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold; margin-bottom: 20px; }
        .btn:hover { background: #2d6a4f; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_dashboard.php" class="btn">⬅️ Back to Dashboard</a>
        <h2>System Reports & Statistics 📊</h2>

        <div class="card-grid">
            <div class="card">
                <h3>Total Customers</h3>
                <p><?php echo $customer_count; ?></p>
            </div>
            <div class="card">
                <h3>Total Suppliers</h3>
                <p><?php echo $supplier_count; ?></p>
            </div>
            <div class="card">
                <h3>Approved Products</h3>
                <p><?php echo $product_count; ?></p>
            </div>
            <div class="card">
                <h3>Pending Products</h3>
                <p><?php echo $pending_product_count; ?></p>
            </div>
        </div>
    </div>
</body>
</html>