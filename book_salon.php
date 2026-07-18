<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$therapy = isset($_GET['therapy']) ? $_GET['therapy'] : 'Service';
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Book Salon Therapy</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #081c15; color: #d8f3dc; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .booking-card { background: rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 20px; border: 1px solid #40916c; width: 100%; max-width: 400px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        h2 { color: #b7e4c7; margin-bottom: 20px; }
        label { display: block; text-align: left; margin: 15px 0 5px 0; color: #74c69d; font-weight: bold; }
        input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #2d6a4f; background: #1b4332; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 15px; margin-top: 25px; border-radius: 8px; border: none; background: #40916c; color: white; font-size: 1rem; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background: #2d6a4f; }
        .back-link { display: block; margin-top: 15px; color: #74c69d; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="booking-card">
    <h2>✨ Appointment වෙන් කරන්න</h2>
    <p style="font-style: italic; color: #b7e4c7;"><?php echo htmlspecialchars($therapy); ?></p>
    
    <form action="save_salon_booking.php" method="POST">
        <input type="hidden" name="therapy_name" value="<?php echo htmlspecialchars($therapy); ?>">
        
        <label>📅 දිනය (Date):</label>
        <input type="date" name="date" required>
        
        <label>⏰ වේලාව (Time):</label>
        <input type="time" name="time" required>
        
        <button type="submit">Confirm Booking / තහවුරු කරන්න</button>
    </form>
    
    <a href="salon_therapy.php" class="back-link">⬅️ ආපසු යන්න</a>
</div>

</body>
</html>