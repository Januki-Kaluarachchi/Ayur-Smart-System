<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Ayur-Smart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <p>Your Shop Management System - Admin Panel</p>
        
        <div class="menu-grid">
            <button onclick="window.location='add_product.php'">Add Product</button>
            <button onclick="window.location='view_orders.php'">View Orders</button>
            <button onclick="window.location='logout.php'" style="background: #a4161a;">Logout</button>
        </div>
    </div>
</body>
</html>