<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['product_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO product (product_name, price, category, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $p_name, $price, $category, $image_url);
    $stmt->execute();
    echo "<script>alert('භාණ්ඩය සාර්ථකව එකතු කරන ලදී!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Manage Stock</title></head>
<body>
    <h1>භාණ්ඩ එකතු කරන්න</h1>
    <form method="POST">
        <input type="text" name="product_name" placeholder="භාණ්ඩයේ නම" required><br>
        <input type="number" name="price" placeholder="මිල (LKR)" required><br>
        <select name="category">
            <option value="Medicinal">ඖෂධ</option>
            <option value="Puja">පූජා ද්‍රව්‍ය</option>
        </select><br>
        <input type="text" name="image_url" placeholder="පින්තූර ලිපිනය (URL)" required><br>
        <button type="submit">එකතු කරන්න</button>
    </form>
    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>