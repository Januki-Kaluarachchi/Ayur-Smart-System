<?php
session_start();
include 'db.php'; // Database connection 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}

$doctor_name = $_SESSION['username'];

// to get all appointments for the logged-in doctor, ordered by date
$query = "SELECT * FROM appointments WHERE doctor_name = ? ORDER BY appointment_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $doctor_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Appointments | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .container { max-width: 900px; margin: auto; background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; color: white; }
        th, td { padding: 15px; border: 1px solid #2d6a4f; text-align: left; }
        th { background: #1b4332; }
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #2d6a4f; color: white; text-decoration: none; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="doctor_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>