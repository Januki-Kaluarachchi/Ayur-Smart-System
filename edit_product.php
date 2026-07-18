<?php
include 'db.php';
$id = $_GET['id'];

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $conn->query("UPDATE product SET product_name='$name', price='$price' WHERE id=$id");
    header("Location: pharmacy_manage.php");
}

$row = $conn->query("SELECT * FROM product WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .edit-box { background: #1b4332; padding: 30px; border-radius: 15px; border: 1px solid #40916c; width: 350px; text-align: center; }
        h2 { color: #b7e4c7; margin-bottom: 20px; }
        input { width: 90%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #40916c; background: #081c15; color: white; }
        button { width: 95%; padding: 12px; margin-top: 10px; background: #40916c; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        button:hover { background: #2d6a4f; }
        a { color: #74c69d; text-decoration: none; display: block; margin-top: 15px; }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>📝 ඖෂධ සංස්කරණය</h2>
    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['product_name']); ?>" required>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>
        <button type="submit" name="update">Update Product</button>
    </form>
    <a href="pharmacy_manage.php">⬅️ ආපසු යන්න</a>
</div>

</body>
</html>