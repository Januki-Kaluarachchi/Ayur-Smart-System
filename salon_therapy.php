<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$query = "SELECT * FROM therapies";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Salon Therapy | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; margin: 0; }
        .container { max-width: 800px; margin: auto; }
        h2 { color: #b7e4c7; text-align: center; margin-bottom: 30px; }
        .card { background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #2d6a4f; transition: 0.3s; }
        .card:hover { border-color: #74c69d; }
        .btn { background: #40916c; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; }
        .btn:hover { background: #2d6a4f; }
        .nav-buttons { text-align: center; margin-bottom: 30px; }
        .my-app-btn { background: #d90429; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Therapies / පවතින ප්‍රතිකාර</h2>

        <div class="nav-buttons">
            <a href="customer_dashboard.php" class="btn">⬅️ Back to Dashboard</a>
            <a href="my_appointments.php" class="my-app-btn">📅 My Appointments</a>
        </div>

        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['therapy_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Price / මිල:</strong> Rs. <?php echo htmlspecialchars($row['price']); ?></p>
                <a href="book_salon.php?therapy=<?php echo urlencode($row['therapy_name']); ?>" class="btn">Book Now / වෙන් කරන්න</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>