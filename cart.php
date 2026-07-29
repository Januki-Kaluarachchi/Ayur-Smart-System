<?php
session_start();
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - Ayur-Smart</title>
    <style>
        body { background-color: #0d1b1e; color: white; font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #1b2a2d; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #2b7a78; }
        th { color: #66fcf1; }
        .btn-order { background-color: #25D366; color: white; padding: 12px 25px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; margin-top: 20px; }
        .empty-cart { text-align: center; padding: 40px; color: #a5c4d4; }
    </style>
</head>
<body>

<div class="container">
    <h2>🛍️ Shopping Cart / ඔබේ ඇණවුම් ලැයිස්තුව</h2>
    <a href="pharmacy_shop.php" style="color: #66fcf1; text-decoration: none;">← Continue Shopping / තව බඩු ගන්න</a>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price (LKR)</th>
                <th>Quantity</th>
                <th>Total (LKR)</th>
            </tr>
            <?php 
            $grand_total = 0;
            $whatsapp_message = "Hello Ayur-Smart, I would like to place an order for the following items:%0A";
            
            foreach ($_SESSION['cart'] as $id => $item): 
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
                $whatsapp_message .= "- " . $item['name'] . " (Qty: " . $item['quantity'] . ") - LKR " . $total . "%0A";
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($total, 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3 style="text-align: right; margin-top: 20px;">Grand Total: LKR <?php echo number_format($grand_total, 2); ?></h3>
        
        <?php 
        $whatsapp_message .= "%0AGrand Total: LKR " . number_format($grand_total, 2) . "%0APlease confirm my order.";
        $whatsapp_url = "https://wa.me/94710665979?text=" . $whatsapp_message;
        ?>

        <div style="text-align: right;">
            <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="btn-order">
                🟢 Order All via WhatsApp
            </a>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <h3>ඔබේ කාර්ට් එක දැනට හිස්ව පවතී. / Your cart is empty.</h3>
            <br>
            <a href="pharmacy_shop.php" style="background: #2b7a78; color: white; padding: 10px 20px; text-decoration: none; border-radius: 20px;">Shop Now / औषධ මිලදී ගන්න</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>