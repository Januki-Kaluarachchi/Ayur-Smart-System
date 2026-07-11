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
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; padding: 40px; display: flex; flex-wrap: wrap; gap: 40px; justify-content: center; }
        .product-img { width: 450px; height: 450px; object-fit: cover; border-radius: 20px; border: 4px solid #b7e4c7; }
        .info { max-width: 600px; }
        .price { font-size: 2rem; color: #b7e4c7; font-weight: bold; margin: 20px 0; }
        .section-title { color: #b7e4c7; border-bottom: 2px solid #40916c; padding-bottom: 5px; margin-top: 30px; }
        .btn-whatsapp { background: #25d366; color: white; padding: 15px 40px; border-radius: 50px; text-decoration: none; display: inline-block; font-weight: bold; font-size: 1.2rem; transition: 0.3s; }
        .btn-whatsapp:hover { background: #128c7e; transform: scale(1.05); }
    </style>
</head>
<body>
    <div>
        <img src="<?php echo $row['image_url']; ?>" class="product-img">
    </div>
    <div class="info">
        <h1><?php echo $row['product_name']; ?></h1>
        <p style="font-size: 1.2rem;"><?php echo $row['description']; ?></p>
        <p class="price">මිල: LKR <?php echo $row['price']; ?></p>

        <h3 class="section-title">අඩංගු දේ (Ingredients)</h3>
        <p><?php echo $row['ingredients'] ? $row['ingredients'] : "ස්වාභාවික ඖෂධීය ශාකසාර."; ?></p>

        <h3 class="section-title">පාවිච්චි කරන ආකාරය (Usage)</h3>
        <p><?php echo $row['usage_instructions'] ? $row['usage_instructions'] : "වෛද්‍ය උපදෙස් පරිදි භාවිතා කරන්න."; ?></p>
        
        <br><br>
        <a href="https://wa.me/94769797635?text=මම%20<?php echo $row['product_name']; ?>%20මිලදී%20ගැනීමට%20කැමතියි." 
           class="btn-whatsapp" target="_blank">🛒 දැන්ම ඇණවුම් කරන්න</a>
    </div>
</body>
</html>