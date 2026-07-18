<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}

$doctor_name = $_SESSION['username'];


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
        .confirm-btn { background: #4CAF50; color: white; padding: 5px 12px; text-decoration: none; border-radius: 5px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointments / හමුවීම් ලැයිස්තුව</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient / රෝගියා</th>
                    <th>Date / දිනය</th>
                    <th>Time / වේලාව</th>
                    <th>Status / තත්ත්වය</th>
                    <th>Action / ක්‍රියාමාර්ග</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="confirm_appointment.php?id=<?php echo $row['id']; ?>" class="confirm-btn">Confirm</a>
                        <?php else: ?>
                            <span style="color: #74c69d;">Confirmed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="doctor_dashboard.php" class="back-btn">Back to Dashboard / ඩෑෂ්බෝඩ් එකට යන්න</a>
    </div>
</body>
</html>