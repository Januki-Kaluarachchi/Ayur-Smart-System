<?php
session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
$sql = "SELECT * FROM users WHERE role = 'customer'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; text-align: center; margin: 0; padding: 30px; }
        .nav-container { display: flex; justify-content: flex-start; max-width: 1000px; margin: 0 auto 20px auto; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; background: rgba(255,255,255,0.05); font-weight: bold; }
        
        h1 { margin-bottom: 20px; }
        
        .tab-container { margin-bottom: 20px; }
        .tab-btn { background: #40916c; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; margin: 0 5px; }
        
        .table-container { max-width: 1000px; margin: 0 auto; background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 15px; border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        th { color: #b7e4c7; font-size: 1.1rem; }
        td { color: #d8f3dc; }
        
        .btn-edit { background: #0077b6; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: bold; margin-right: 5px; }
        .btn-delete { background: #d90429; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: bold; }
        .btn-orders { background: #e85d04; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: bold; margin-right: 5px; display: inline-block; }
        .btn-orders:hover { background: #dc2f02; }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="admin_dashboard.php" class="btn-back">⬅️ Back to Dashboard</a>
    </div>

    <h1>Manage Users 👥</h1>

    <div class="tab-container">
        <a href="manage_users.php" class="tab-btn">Manage Customers</a>
        <a href="manage_suppliers.php" class="tab-btn" style="background: rgba(255,255,255,0.1);">Manage Suppliers</a>
    </div>

    <div class="table-container">
        <h2 style="text-align: left; color: #b7e4c7; margin-top: 0;">Customer List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".htmlspecialchars($row['username'])."</td>
                                <td>".htmlspecialchars($row['username'])."</td>
                                <td>
                                    <a href='customer_orders.php?user_id=".$row['id']."' class='btn-orders'>📦 Orders</a>
                                    <a href='edit_user.php?id=".$row['id']."' class='btn-edit'>Edit</a>
                                    <a href='delete_user.php?id=".$row['id']."' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center; padding: 20px;'>NO CUSTOMERS FOUND.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>