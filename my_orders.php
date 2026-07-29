<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$user_query = $conn->query("SELECT id FROM users WHERE username = '$username'");
$user_data = $user_query->fetch_assoc();
$user_id = $user_data['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 30px; }
        .container { max-width: 900px; margin: auto; }
        .card { background: #1b4332; padding: 20px; border-radius: 10px; border: 1px solid #40916c; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background: #2d6a4f; }
        .back-btn { background: #555; display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .status-pending { color: #ffb703; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <a href="pharmacy_shop.php" class="back-btn">⬅️ Back to Shop</a>
        <h2>My Orders 📦</h2>

        <div class="card">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Price (Rs.)</th>
                    <th>Quantity</th>
                    <th>Total (Rs.)</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php
                $orders_result = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
                if ($orders_result && $orders_result->num_rows > 0) {
                    while ($row = $orders_result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>Rs. {$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>Rs. {$row['total_price']}</td>
                            <td>{$row['order_date']}</td>
                            <td><span class='status-pending'>{$row['status']}</span></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center; color: #74c69d;'>You have not placed any orders yet.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>