<?php
session_start();
include 'db.php';


if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);


    $user_q = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $user_q->bind_param("i", $user_id);
    $user_q->execute();
    $user_res = $user_q->get_result();
    $user_row = $user_res->fetch_assoc();
    $customer_name = $user_row ? $user_row['username'] : "Customer";
} else {
    header("Location: manage_users.php");
    exit();
}


if (isset($_GET['complete_id'])) {
    $order_id = intval($_GET['complete_id']);
    $update_q = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE id = ?");
    $update_q->bind_param("i", $order_id);
    $update_q->execute();
    header("Location: customer_orders.php?user_id=" . $user_id);
    exit();
}


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
    <title><?php echo htmlspecialchars($customer_name); ?>'s Orders - Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; text-align: center; margin: 0; padding: 30px; }
        .nav-container { display: flex; justify-content: flex-start; max-width: 1000px; margin: 0 auto 20px auto; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; background: rgba(255,255,255,0.05); font-weight: bold; }
        
        h1 { margin-bottom: 20px; color: #b7e4c7; }
        
        .table-container { max-width: 1000px; margin: 0 auto; background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 15px; border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        th { color: #b7e4c7; font-size: 1.1rem; }
        td { color: #d8f3dc; }
        
        .status-pending { color: #ffb703; font-weight: bold; }
        .status-completed { color: #2ec4b6; font-weight: bold; }
        
        .btn-complete { 
            background: #2ec4b6; 
            color: #081c15; 
            padding: 6px 12px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 0.9rem; 
            font-weight: bold; 
            transition: 0.3s;
        }
        .btn-complete:hover { background: #cbf3f0; }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="manage_users.php" class="btn-back">⬅️ Back to Manage Users</a>
    </div>

    <h1>📦 Orders of: <?php echo htmlspecialchars($customer_name); ?></h1>

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
                        $status_class = ($row['status'] == 'Completed') ? 'status-completed' : 'status-pending';

                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".htmlspecialchars($row['product_name'])."</td>
                                <td>Rs. ".number_format($row['price'], 2)."</td>
                                <td>".$row['quantity']."</td>
                                <td>Rs. ".number_format($row['total_price'], 2)."</td>
                                <td>".$order_date."</td>
                                <td class='".$status_class."'>".$row['status']."</td>
                                <td>";
                        
                        if ($row['status'] != 'Completed') {
                            echo "<a href='customer_orders.php?user_id=".$user_id."&complete_id=".$row['id']."' class='btn-complete'>✔️ Mark Completed</a>";
                        } else {
                            echo "<span style='color: #2ec4b6; font-weight: bold;'>Completed</span>";
                        }

                        echo "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align: center; padding: 20px;'>මෙම කස්ටමර් විසින් තවමත් කිසිදු ඇණවුමක් කර නොමැත.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>