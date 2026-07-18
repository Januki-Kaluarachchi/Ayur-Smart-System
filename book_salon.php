<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$therapy = $_GET['therapy'];
?>

<!DOCTYPE html>
<html lang="si">
<head><title>Book Salon Therapy</title></head>
<body style="background:#081c15; color:#d8f3dc; padding:40px;">
    <h2>Book: <?php echo htmlspecialchars($therapy); ?></h2>
    <form action="save_salon_booking.php" method="POST">
        <input type="hidden" name="therapy_name" value="<?php echo htmlspecialchars($therapy); ?>">
        <label>Date / දිනය:</label><br>
        <input type="date" name="date" required><br><br>
        <label>Time / වේලාව:</label><br>
        <input type="time" name="time" required><br><br>
        <button type="submit">Confirm Booking / වෙන් කරන්න</button>
    </form>
</body>
</html>