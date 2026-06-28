<?php
session_start();
include 'db.php';


$id = $_GET['id'];
$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['product_name']; ?> | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; padding: 50px; display: flex; gap: 40px; justify-content: center; }
        .product-img { width: 400px; border-radius: 20px; border: 2px solid #b7e4c7; }
        .info { max-width: 500px; }
        .price { font-size: 1.5rem; color: #b7e4c7; font-weight: bold; }
        .btn-whatsapp { background: #25d366; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; display: inline-block; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div>
        <img src="<?php echo $row['image_url']; ?>" class="product-img">
    </div>
    <div class="info">
        <h1><?php echo $row['product_name']; ?></h1>
        <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
        <p style="font-size: 1.2rem;"><?php echo $row['description']; ?></p>
        <p class="price">මිල: LKR <?php echo $row['price']; ?></p>
        
        <a href="https://wa.me/94770000000?text=මම%20<?php echo $row['product_name']; ?>%20මිලදී%20ගැනීමට%20කැමතියි." 
           class="btn-whatsapp" target="_blank">WhatsApp හරහා ඇණවුම් කරන්න 🛒</a>
    </div>
</body>
</html>