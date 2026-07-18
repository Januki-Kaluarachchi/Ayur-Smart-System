<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $remove_id = intval($_GET['id']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}

$grand_total = 0;
$whatsapp_message = "ආයුබෝවන් Ayur-Smart, මම පහත සඳහන් ඇණවුම ලබාදීමට කැමතියි:\n\n";
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; padding: 40px; }
        .container { max-width: 900px; margin: auto; background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 20px; border: 1px solid #40916c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; border-bottom: 1px solid #2d6a4f; text-align: left; }
        th { background-color: #1b4332; color: #b7e4c7; }
        .total-row { font-size: 1.3rem; font-weight: bold; color: #b7e4c7; text-align: right; padding: 20px; }
        .btn-checkout { background: #25d366; color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: bold; display: inline-block; font-size: 1.2rem; margin-top: 20px; }
        .btn-clear { background: #ff6b6b; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; }
        .remove-link { color: #ff6b6b; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Shopping Cart / ඔබේ ඇණවුම් ලැයිස්තුව</h2>
        <a href="pharmacy_shop.php" style="color: #b7e4c7; text-decoration: none;">← Continue Shopping / තව බඩු ගන්න</a>
        
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product / භාණ්ඩය</th>
                        <th>Price / මිල</th>
                        <th>Qty / ප්‍රමාණය</th>
                        <th>Subtotal / එකතුව</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($_SESSION['cart'] as $p_id => $qty): 
                        $sql = "SELECT * FROM product WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $p_id);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        if($row = $res->fetch_assoc()):
                            $subtotal = $row['price'] * $qty;
                            $grand_total += $subtotal;
                            
                          
                            $whatsapp_message .= "- " . $row['product_name'] . " (Qty: " . $qty . ") = LKR " . $subtotal . "\n";
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td>LKR <?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>LKR <?php echo $subtotal; ?></td>
                        <td><a href="cart.php?action=remove&id=<?php echo $p_id; ?>" class="remove-link">❌ ඉවත් කරන්න</a></td>
                    </tr>
                    <?php 
                        endif;
                    endforeach; 
                    
                    $whatsapp_message .= "\n*මුළු එකතුව (Grand Total): LKR " . $grand_total . "*";
                    ?>
                </tbody>
            </table>
            
            <div class="total-row">
                Grand Total / මුළු එකතුව: LKR <?php echo $grand_total; ?>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <a href="cart.php?action=clear" class="btn-clear">🗑️ Clear Cart / සියල්ල ඉවත් කරන්න</a>
                <a href="https://wa.me/94769797635?text=<?php echo urlencode($whatsapp_message); ?>" class="btn-checkout" target="_blank">
                    🛒 Confirm Order via WhatsApp / ඇණවුම තහවුරු කරන්න
                </a>
            </div>

        <?php else: ?>
            <div style="text-align: center; padding: 40px;">
                <h3>ඔබේ කාර්ට් එක දැනට හිස්ව පවතී. / Your cart is empty.</h3>
                <br>
                <a href="pharmacy_shop.php" style="background: #40916c; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Shop Now / ඖෂධ මිලදී ගන්න</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>