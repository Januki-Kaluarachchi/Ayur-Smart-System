<?php
session_start();
include 'db.php'; // Database connection 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
$query = "SELECT * FROM doctors WHERE status = 'active'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Channeling Doctors | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .container { max-width: 900px; margin: auto; }
        .doctor-card { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #2d6a4f; }
        .btn-book { background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Doctors</h2>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="doctor-card">
                <h3>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h3>
                <p>Specialization: <?php echo htmlspecialchars($row['specialization']); ?></p>
                <p>Available Date: <?php echo htmlspecialchars($row['schedule_date']); ?></p>
                <p>Available Time: <?php echo htmlspecialchars($row['schedule_time']); ?></p>
                <a href="book_appointment.php?doctor_id=<?php echo $row['id']; ?>" class="btn-book">Book Now</a>
            </div>
        <?php endwhile; ?>
        <br><a href="customer_dashboard.php" style="color: white;">Back to Dashboard</a>
    </div>
</body>
</html>