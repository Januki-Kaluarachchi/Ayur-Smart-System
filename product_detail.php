<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
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

//  Direct WhatsApp Order 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $username = $_SESSION['username'];
    
    $user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $user_query->bind_param("s", $username);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user_data = $user_result->fetch_assoc();
    $user_id = $user_data['id'];

    $product_name = $row['product_name'];
    $price = $row['price'];
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) { $quantity = 1; }
    $total_price = $price * $quantity;
    $status = 'Pending';

    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, product_name, price, quantity, total_price, status) VALUES (?, ?, ?, ?, ?, ?)");
    $order_stmt->bind_param("isdids", $user_id, $product_name, $price, $quantity, $total_price, $status);
    
    if ($order_stmt->execute()) {
        $product_encoded = urlencode($product_name);
        $qty_encoded = urlencode($quantity);
        $total_encoded = urlencode($total_price);
        
        echo "<script>
                window.open('https://wa.me/94710665979?text=මම%20$product_encoded%20භාණ්ඩය%20ප්‍රමාණය%20$qty_encoded%20ක්%20මිලදී%20ගැනීමට%20ඇණවුම්%20කළෙමි.%20මුළු%20මිල:%20LKR%20$total_encoded', '_blank');
                window.location.href = 'my_orders.php';
              </script>";
        exit();
    } else {
        $error_msg = "Order failed: " . $conn->error;
    }
}

// Add to Cart 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $row['id'];
    $product_name = $row['product_name'];
    $price = $row['price'];
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) { $quantity = 1; }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit();
}
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
        
        .cart-section { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; margin-top: 20px; text-align: center; }
        .qty-input { padding: 10px; width: 80px; border-radius: 8px; border: none; font-size: 1.1rem; text-align: center; }
        
        .btn-buy { background: #25d366; color: white; padding: 14px 25px; border-radius: 10px; border: none; font-weight: bold; font-size: 1.2rem; cursor: pointer; transition: 0.3s; width: 100%; margin-top: 15px; }
        .btn-buy:hover { background: #128c7e; }

        .btn-cart { background: #2b7a78; color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-cart:hover { background: #3aafa9; }

        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; }
        .action-row { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 10px; flex-wrap: wrap; }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="pharmacy_shop.php" class="btn-back">⬅️ Back to Shop </a>
        <div style="display: flex; gap: 15px;">
            <a href="cart.php" style="color: #66fcf1; text-decoration: none; font-size: 1.2rem; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 8px;">
                🛒 View Cart
            </a>
            <a href="my_orders.php" style="color: #b7e4c7; text-decoration: none; font-size: 1.2rem; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 8px;">
                📦 My Orders
            </a>
        </div>
    </div>

    <?php if (isset($error_msg)) { echo "<p style='color: #ff6b6b; text-align:center;'>$error_msg</p>"; } ?>

    <div class="main-content">
        <div>
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="product-img" alt="Product Image">
        </div>
        
        <div class="info">
            <h1><?php echo htmlspecialchars($row['product_name']); ?></h1>
            <p style="font-size: 1.2rem; line-height: 1.6; text-align: left;"><?php echo htmlspecialchars($row['description']); ?></p>
            <p class="price" style="text-align: left;">මිල: LKR <?php echo htmlspecialchars($row['price']); ?></p>

            <h3 class="section-title" style="text-align: left;">අඩංගු දේ (Ingredients)</h3>
            <p style="text-align: left;"><?php echo $row['ingredients'] ? htmlspecialchars($row['ingredients']) : "ස්වාභාවික ඖෂධීය ශාකසාර."; ?></p>

            <h3 class="section-title" style="text-align: left;">පාවිච්චි කරන ආකාරය (Usage)</h3>
            <p style="text-align: left;"><?php echo $row['usage_instructions'] ? htmlspecialchars($row['usage_instructions']) : "වෛද්‍ය උපදෙස් පරිදි භාවිතා කරන්න."; ?></p>
            
            <div class="cart-section">
                <form method="POST" action="product_detail.php?id=<?php echo $id; ?>">
                 
                    <div class="action-row">
                        <label style="font-size: 1.1rem; font-weight: bold;">QTY:</label>
                        <input type="number" name="quantity" class="qty-input" value="1" min="1">
                        
                        <button type="submit" name="add_to_cart" class="btn-cart">🛒 Add to Cart</button>
                    </div>

                    <button type="submit" name="place_order" class="btn-buy">💬 BUY (WhatsApp & Place Order)</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>