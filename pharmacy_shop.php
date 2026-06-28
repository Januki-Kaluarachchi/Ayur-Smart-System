<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; text-align: center; }
        .filter-nav { margin: 20px; }
        .filter-nav a { color: #b7e4c7; margin: 0 15px; text-decoration: none; font-size: 1.2rem; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 40px; }
        .product-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 20px; border: 1px solid #b7e4c7; transition: 0.3s; cursor: pointer; }
        .product-card:hover { transform: scale(1.03); background: rgba(255, 255, 255, 0.1); }
        .product-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
        .btn-add { background: #40916c; color: white; padding: 10px; border-radius: 10px; border: none; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>ඖෂධ සහ පූජා ද්‍රව්‍ය අංශය</h1>
    

    <div class="filter-nav">
        <a href="pharmacy_shop.php">සියල්ල</a> | 
        <a href="pharmacy_shop.php?cat=Medicinal">ඖෂධ</a> | 
        <a href="pharmacy_shop.php?cat=Puja">පූජා ද්‍රව්‍ය</a>
    </div>

    <div class="products-grid">
        <?php

        $cat = isset($_GET['cat']) ? $_GET['cat'] : null;
        if ($cat) {
            $sql = "SELECT * FROM product WHERE category = '$cat'";
        } else {
            $sql = "SELECT * FROM product";
        }
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              
                echo "<a href='product_detail.php?id=".$row['id']."' style='text-decoration:none; color:inherit;'>
                        <div class='product-card'>
                            <img src='".$row['image_url']."' alt='".$row['product_name']."'>
                            <h3>".$row['product_name']."</h3>
                            <p>මිල: LKR ".$row['price']."</p>
                            <button class='btn-add'>තව දැනගන්න</button>
                        </div>
                      </a>";
            }
        } else {
            echo "<p>දැනට මෙම වර්ගයේ නිෂ්පාදන නොමැත.</p>";
        }
        ?>
    </div>
</body>
</html>