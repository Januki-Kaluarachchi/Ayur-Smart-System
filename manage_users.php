<?php
session_start();
include 'db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM suppliers WHERE user_id = $id");
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'customers';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 30px; }
        .container { max-width: 1000px; margin: auto; }
        .btn-group { margin-bottom: 20px; }
        .btn { background: #1b4332; color: #d8f3dc; padding: 10px 20px; text-decoration: none; border-radius: 5px; border: 1px solid #40916c; font-weight: bold; margin-right: 10px; }
        .btn.active { background: #40916c; color: white; }
        .card { background: #1b4332; padding: 20px; border-radius: 10px; border: 1px solid #40916c; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background: #2d6a4f; }
        .action-btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; color: white; font-size: 0.85rem; margin-right: 5px; }
        .edit-btn { background: #0077b6; }
        .delete-btn { background: #d90429; }
        .back-btn { background: #555; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_dashboard.php" class="btn back-btn">⬅️ Back to Dashboard</a>
        <h2>Manage Users 👥</h2>
        
        <!-- Tab Buttons for Customers and Suppliers -->
        <div class="btn-group">
            <a href="manage_users.php?tab=customers" class="btn <?php echo ($tab == 'customers') ? 'active' : ''; ?>">Manage Customers</a>
            <a href="manage_users.php?tab=suppliers" class="btn <?php echo ($tab == 'suppliers') ? 'active' : ''; ?>">Manage Suppliers</a>
        </div>

        <div class="card">
            <?php if ($tab == 'customers'): ?>
                <h3>Customer List</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $result = $conn->query("SELECT * FROM users WHERE role = 'customer'");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['fullname']}</td>
                                <td>{$row['username']}</td>
                                <td>
                                    <a href='edit_user.php?id={$row['id']}' class='action-btn edit-btn'>Edit</a>
                                    <a href='manage_users.php?delete_id={$row['id']}&tab=customers' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center; color: #74c69d;'>No customers found.</td></tr>";
                    }
                    ?>
                </table>

            <?php elseif ($tab == 'suppliers'): ?>
                <h3>Supplier List</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $supplier_query = "SELECT users.id, users.fullname, users.username, suppliers.company_name, suppliers.phone_number 
                                       FROM users 
                                       JOIN suppliers ON users.id = suppliers.user_id 
                                       WHERE users.role = 'supplier'";
                    $sup_result = $conn->query($supplier_query);
                    if ($sup_result && $sup_result->num_rows > 0) {
                        while ($row = $sup_result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['fullname']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['company_name']}</td>
                                <td>{$row['phone_number']}</td>
                                <td>
                                    <a href='edit_supplier.php?id={$row['id']}' class='action-btn edit-btn'>Edit</a>
                                    <a href='manage_users.php?delete_id={$row['id']}&tab=suppliers' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this supplier?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center; color: #74c69d;'>No suppliers found.</td></tr>";
                    }
                    ?>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>