<?php
session_start();
include 'db.php'; 

// Staff ලොගින් එක පරීක්ෂා කිරීම
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}

// ඖෂධයක් එකතු කිරීමේ ක්‍රියාවලිය
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $conn->query("INSERT INTO product (product_name, price) VALUES ('$name', '$price')");
    header("Location: pharmacy_manage.php");
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Management</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1b4332; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background-color: #2d6a4f; }
        .btn-del { color: #ff6b6b; text-decoration: none; font-weight: bold; }
        .btn-edit { color: #74c69d; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .form-box { background: #081c15; padding: 20px; border: 1px solid #40916c; border-radius: 10px; margin-bottom: 20px; }
        input { padding: 10px; border-radius: 5px; border: 1px solid #40916c; background: #1b4332; color: white; }
        button { padding: 10px 20px; background: #40916c; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>💊 ඖෂධ කළමනාකරණය</h2>
    <a href="staff_dashboard.php" style="color: #74c69d;">⬅️ Back to Dashboard</a>


    <div class="form-box">
        <h3>නව ඖෂධයක් එකතු කරන්න</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="ඖෂධයේ නම" required>
            <input type="number" step="0.01" name="price" placeholder="මිල (LKR)" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>

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
                <td>
                    <a href='edit_product.php?id={$row['id']}' class='btn-edit'>Edit</a>
                    <a href='delete_product.php?id={$row['id']}' class='btn-del' onclick='return confirm(\"ඔබට මෙම ඖෂධය මකා දැමීමට අවශ්‍යද?\")'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>