<?php
session_start();
include 'db.php'; 

// verify if the user is logged in and is a customer
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
        .doctor-card { background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #2d6a4f; }
        .btn-book { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; }
        .btn-book:hover { background: #45a049; }
        h2 { color: #b7e4c7; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Doctors</h2>
      <?php while($row = $result->fetch_assoc()): ?>
            <div class="doctor-card">
                <h3>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h3>
                
                <p><strong>Specialization / විශේෂඥතාව:</strong> 
                    <?php echo htmlspecialchars($row['specialization']); ?>
                </p>
                
                <p><strong>Schedule / වෙන් කර ඇති වේලාව:</strong> 
                    <?php echo htmlspecialchars($row['schedule']); ?>
                </p>
                
                <p style="color: #74c69d; font-size: 0.9em;">
                    * Please book your appointment in advance / කරුණාකර ඔබගේ හමුවීම කල්තියා වෙන් කරවා ගන්න.
                </p>
                
                <a href="book_appointment.php?doctor_id=<?php echo $row['id']; ?>" class="btn-book">
                    Book Now / හමුවීම වෙන් කරන්න
                </a>
            </div>
        <?php endwhile; ?>
        <br><a href="customer_dashboard.php" style="color: #b7e4c7;">Back to Dashboard</a>
    </div>
</body>
</html>