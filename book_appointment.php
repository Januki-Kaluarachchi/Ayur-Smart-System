<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$doctor_id = $_GET['doctor_id'];
$query = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .container { max-width: 500px; margin: auto; background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: none; }
        button { background: #4CAF50; color: white; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Appointment with Dr. <?php echo htmlspecialchars($doctor['doctor_name']); ?></h2>
        <form action="save_appointment.php" method="POST">
            <input type="hidden" name="doctor_name" value="<?php echo htmlspecialchars($doctor['doctor_name']); ?>">
            
            <label>Patient Name / රෝගියාගේ නම:(Please enter your username)</label>
            <input type="text" name="patient_name" required>
            
            <label>Appointment Date / දිනය:</label>
            <input type="date" name="appointment_date" required>
            
            <label>Appointment Time / වේලාව:</label>
            <input type="time" name="appointment_time" required>
            
            <button type="submit">Confirm Booking / හමුවීම තහවුරු කරන්න</button>
        </form>
        <br><a href="channeling_doctors.php" style="color: #b7e4c7;">Back / ආපසු</a>
    </div>
</body>
</html>