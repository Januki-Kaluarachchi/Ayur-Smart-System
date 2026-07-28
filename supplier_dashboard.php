<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supplier') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Dashboard - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        .container { max-width: 900px; margin: auto; }
        .card { background: #1b4332; padding: 20px; border-radius: 10px; border: 1px solid #40916c; margin-bottom: 20px; }
        .alert-box { background: #780000; color: #ffb703; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #d90429; font-weight: bold; }
        .btn { background: #40916c; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #40916c; padding: 10px; text-align: left; }
        th { background: #2d6a4f; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Supplier Dashboard 🌿</h2>
        <p>Welcome, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></p>
        
        <div style="margin-bottom: 20px;">
            <a href="supplier_add_product.php" class="btn">➕ Add New Product</a>
            <a href="logout.php" class="btn" style="background: #900; float: right;">Logout</a>
        </div>

        <!-- Low Stock Alerts Section -->
        <div class="card">
            <h3>⚠️ Low Stock Alerts (Stock < 5)</h3>
            <?php
            // Display products with stock quantity less than 5
            $low_stock_query = "SELECT * FROM product WHERE stock_quantity < 5";
            $low_res = $conn->query($low_stock_query);
            
            if ($low_res->num_rows > 0) {
                echo "<table>
                    <tr>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Price</th>
                    </tr>";
                while($item = $low_res->fetch_assoc()) {
                    echo "<tr style='background: rgba(217, 4, 41, 0.2);'>
                        <td>{$item['product_name']}</td>
                        <td style='color: #ff6b6b; font-weight: bold;'>{$item['stock_quantity']} (Low Stock!)</td>
                        <td>Rs. {$item['price']}</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: #74c69d;'>No low stock items found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>