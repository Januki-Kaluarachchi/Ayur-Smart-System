<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; text-align: center; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 40px; }
        .product-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 20px; border: 1px solid #b7e4c7; }
        .product-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
        .btn-add { background: #40916c; color: white; padding: 10px; border-radius: 10px; cursor: pointer; border: none; }
    </style>
</head>
<body>
    <h1>ඖෂධ අංශය (Pharmacy)</h1>
    
    <div class="products-grid">
        <?php
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>
                        <img src='".$row['image_url']."' alt='".$row['product_name']."'>
                        <h3>".$row['product_name']."</h3>
                        <p>මිල: LKR ".$row['price']."</p>
                        <button class='btn-add'>Add to Cart</button>
                      </div>";
            }
        } else {
            echo "<p>දැනට නිෂ්පාදන නොමැත.</p>";
        }
        ?>
    </div>
</body>
</html>