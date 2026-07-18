<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Management</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background-color: #1b4332; }
        .btn-del { color: #ff6b6b; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h2>💊 ඖෂධ කළමනාකරණය</h2>
    <a href="staff_dashboard.php" style="color: #74c69d;">⬅️ Back to Dashboard</a>

    <table>
        <tr>
            <th>ID</th>
            <th>ඖෂධයේ නම</th>
            <th>මිල (LKR)</th>
            <th>ක්‍රියාමාර්ග</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM product"); 
        while($row = $res->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['price']}</td>
                <td><a href='delete_product.php?id={$row['id']}' class='btn-del'>Delete</a></td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>