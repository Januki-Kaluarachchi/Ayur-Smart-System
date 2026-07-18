<?php
session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity < 1) {
        $quantity = 1;
    }

  
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

   
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    echo "<script>
            alert('භාණ්ඩය සාර්ථකව කාර්ට් එකට එක් කරන ලදී! / Product added to cart!');
            window.location='pharmacy_shop.php';
          </script>";
    exit();
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Product not found!";
        exit();
    }
} else {
    header("Location: pharmacy_shop.php");
    exit();
}


$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($row['product_name']); ?> | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; padding: 40px; }
        .nav-container { display: flex; justify-content: space-between; align-items: center; max-width: 1100px; margin: 0 auto 30px auto; }
        .main-content { display: flex; flex-wrap: wrap; gap: 40px; justify-content: center; max-width: 1100px; margin: auto; }
        .product-img { width: 450px; height: 450px; object-fit: cover; border-radius: 20px; border: 4px solid #b7e4c7; }
        .info { max-width: 600px; flex: 1; }
        .price { font-size: 2rem; color: #b7e4c7; font-weight: bold; margin: 20px 0; }
        .section-title { color: #b7e4c7; border-bottom: 2px solid #40916c; padding-bottom: 5px; margin-top: 30px; }
        
        .cart-section { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; margin-top: 20px; }
        .qty-input { padding: 10px; width: 60px; border-radius: 8px; border: none; font-size: 1.1rem; text-align: center; margin-right: 10px; }
        .btn-cart { background: #40916c; color: white; padding: 12px 25px; border-radius: 10px; border: none; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-cart:hover { background: #2d6a4f; }
        
        .btn-whatsapp { background: #25d366; color: white; padding: 12px 25px; border-radius: 10px; text-decoration: none; display: inline-block; font-weight: bold; font-size: 1.1rem; transition: 0.3s; margin-top: 10px; }
        .btn-whatsapp:hover { background: #128c7e; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="pharmacy_shop.php" class="btn-back">⬅️ Back to Shop </a>
        <a href="cart.php" style="color: #b7e4c7; text-decoration: none; font-size: 1.2rem; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 8px;">
            🛒 View Cart  (<?php echo $cart_count; ?>)
        </a>
    </div>

    <div class="main-content">
        <div>
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="product-img" alt="Product Image">
        </div>
        
        <div class="info">
            <h1><?php echo htmlspecialchars($row['product_name']); ?></h1>
            <p style="font-size: 1.2rem; line-height: 1.6;"><?php echo htmlspecialchars($row['description']); ?></p>
            <p class="price">මිල: LKR <?php echo htmlspecialchars($row['price']); ?></p>

            <h3 class="section-title">අඩංගු දේ (Ingredients)</h3>
            <p><?php echo $row['ingredients'] ? htmlspecialchars($row['ingredients']) : "ස්වාභාවික ඖෂධීය ශාකසාර."; ?></p>

            <h3 class="section-title">පාවිච්චි කරන ආකාරය (Usage)</h3>
            <p><?php echo $row['usage_instructions'] ? htmlspecialchars($row['usage_instructions']) : "වෛද්‍ය උපදෙස් පරිදි භාවිතා කරන්න."; ?></p>
            
           
            <div class="cart-section">
                <form method="POST" action="product_detail.php?id=<?php echo $id; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <label style="display:block; margin-bottom:8px;">Quantity / ප්‍රමාණය:</label>
                    <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <input type="number" name="quantity" class="qty-input" value="1" min="1">
                        <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart </button>
                    </div>
                </form>
                
                <div style="margin-top: 15px; border-top: 1px dashed #40916c; padding-top: 15px;">
                    <a href="https://wa.me/94769797635?text=මම%20<?php echo urlencode($row['product_name']); ?>%20මිලදී%20ගැනීමට%20කැමතියි." 
                       class="btn-whatsapp" target="_blank">💬 Direct WhatsApp Inquiry</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>