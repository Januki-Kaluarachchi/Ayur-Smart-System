<?php
session_start();
include 'db.php';

// Check if user is admin or staff
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    header("Location: login.html");
    exit();
}

// Fetch products expiring within the next 10 days based on current date
$sql = "SELECT * FROM product WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY) ORDER BY expiry_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Expiring Products Report - Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; padding: 40px; }
        .container { max-width: 1000px; margin: auto; background: #1b2a2d; padding: 30px; border-radius: 15px; border: 1px solid #40916c; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; display: inline-block; margin-bottom: 20px; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #2b7a78; }
        th { color: #ff6b6b; }
        .badge { background: #ff6b6b; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="container">
    <a href="view_reports.php" class="btn-back">⬅️ Back to Reports</a>
    
    <h2>⚠️ Products Expiring in Next 10 Days</h2>
    <p style="color: #a5c4d4;">Expire Products List </p>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Stock Count</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['stock_count']); ?></td>
                <td style="color: #ff6b6b; font-weight: bold;"><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                <td><span class="badge">Expiring Soon</span></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center; padding: 30px; color: #52b788; font-size: 1.2rem;">දින 10ක් ඇතුළත expire වීමට නියමිත කිසිදු භාණ්ඩයක් නොමැත! 👍</p>
    <?php endif; ?>
</div>

</body>
</html>