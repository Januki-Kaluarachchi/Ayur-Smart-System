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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salon Therapy | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .container { max-width: 800px; margin: auto; }
        .card { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #2d6a4f; }
        .btn { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Therapies / පවතින ප්‍රතිකාර</h2>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['therapy_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Price / මිල:</strong> Rs. <?php echo htmlspecialchars($row['price']); ?></p>
<a href="book_salon.php?therapy=<?php echo urlencode($row['therapy_name']); ?>" class="btn">Book Now / වෙන් කරන්න</a>
            </div>
        <?php endwhile; ?>
        <br><a href="customer_dashboard.php" style="color: #b7e4c7;">Back to Dashboard / ඩෑෂ්බෝඩ් එකට යන්න</a>
    </div>
    <div style="text-align: center; margin-bottom: 20px;">
    <a href="my_appointments.php" style="background-color: #40916c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold;">
        📅 මගේ හමුවීම් බලන්න (My Appointments)
    </a>
</div>
</body>
</html>