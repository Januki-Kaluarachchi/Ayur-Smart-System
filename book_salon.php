<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$therapy = isset($_GET['therapy']) ? $_GET['therapy'] : 'Service';
$current_user = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Book Salon Therapy</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #081c15; color: #d8f3dc; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .booking-card { background: rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 20px; border: 1px solid #40916c; width: 100%; max-width: 450px; text-align: center; }
        h2 { color: #b7e4c7; }
        label { display: block; text-align: left; margin: 15px 0 5px 0; color: #74c69d; font-weight: bold; }
        input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #2d6a4f; background: #1b4332; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 15px; margin-top: 25px; border-radius: 8px; border: none; background: #40916c; color: white; font-weight: bold; cursor: pointer; }
        .btn-whatsapp { display: block; margin-top: 20px; background: #25d366; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="booking-card">
    <h2>✨ Appointment වෙන් කරන්න</h2>
    <p style="color: #b7e4c7;"><?php echo htmlspecialchars($therapy); ?></p>
    
    <form action="save_salon_booking.php" method="POST">
        <input type="hidden" name="therapy_name" value="<?php echo htmlspecialchars($therapy); ?>">
        
        <label>👤 නම (Name) Please enter your username :</label>
        <input type="text" name="patient_name" value="<?php echo htmlspecialchars($current_user); ?>" required>
        
        <label>📅 දිනය (Date):</label>
        <input type="date" name="date" required>
        
        <label>⏰ වේලාව (Time):</label>
        <input type="time" name="time" required>
        
        <button type="submit">Confirm Booking / තහවුරු කරන්න</button>
    </form>

    <hr style="border: 0; border-top: 1px solid #2d6a4f; margin: 25px 0;">
    <p style="color: #b7e4c7; font-size: 0.9rem;">වැඩිදුර විස්තර සඳහා අප අමතන්න:</p>
    <a href="https://wa.me/94769797635?text=මම%20<?php echo urlencode($therapy); ?>%20සම්බන්ධව%20විමසීමට%20කැමතියි." 
       class="btn-whatsapp" target="_blank">💬 WhatsApp හරහා විමසන්න</a>
    
    <a href="salon_therapy.php" style="display:block; margin-top:15px; color:#74c69d; text-decoration:none;">⬅️ ආපසු යන්න</a>
</div>

</body>
</html>