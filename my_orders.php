<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

$user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user_data = $user_result->fetch_assoc();
$user_id = $user_data['id'];


$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>My Orders - Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; text-align: center; margin: 0; padding: 30px; }
        .nav-container { display: flex; justify-content: flex-start; max-width: 1000px; margin: 0 auto 20px auto; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; background: rgba(255,255,255,0.05); font-weight: bold; }
        
        h1 { margin-bottom: 20px; }
        
        .table-container { max-width: 1000px; margin: 0 auto; background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 15px; border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        th { color: #b7e4c7; font-size: 1.1rem; }
        td { color: #d8f3dc; }
        
        .status-pending { color: #ffb703; font-weight: bold; }
        
        .btn-whatsapp { 
            background: #25d366; 
            color: white; 
            padding: 6px 12px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 0.9rem; 
            font-weight: bold; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
            transition: 0.3s;
        }
        .btn-whatsapp:hover { background: #128c7e; }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="pharmacy_shop.php" class="btn-back">⬅️ Back to Shop</a>
    </div>

    <h1>My Orders 📦</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Price (Rs.)</th>
                    <th>Quantity</th>
                    <th>Total (Rs.)</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        $order_date = isset($row['order_date']) ? $row['order_date'] : (isset($row['date']) ? $row['date'] : 'N/A');
                        $wa_text = "මම Order ID #" . $row['id'] . " යටතේ " . $row['product_name'] . " (ප්‍රමාණය: " . $row['quantity'] . ") ඇණවුම් කළෙමි. මුළු මිල: Rs. " . $row['total_price'];
                        $wa_url = "https://wa.me/94710665979?text=" . urlencode($wa_text);

                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".htmlspecialchars($row['product_name'])."</td>
                                <td>Rs. ".number_format($row['price'], 2)."</td>
                                <td>".$row['quantity']."</td>
                                <td>Rs. ".number_format($row['total_price'], 2)."</td>
                                <td>".$order_date."</td>
                                <td class='status-pending'>".$row['status']."</td>
                                <td>
                                    <a href='".$wa_url."' class='btn-whatsapp' target='_blank'>💬 WhatsApp</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align: center; padding: 20px;'>ඔබ විසින් තවමත් කිසිදු ඇණවුමක් කර නොමැත.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>