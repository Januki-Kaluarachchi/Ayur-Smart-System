<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$customer_name = $_SESSION['username'];

$query = "SELECT * FROM appointments WHERE patient_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $customer_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .container { max-width: 800px; margin: auto; background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; color: white; }
        th, td { padding: 15px; border: 1px solid #2d6a4f; text-align: left; }
        th { background: #1b4332; }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Appointments / මගේ හමුවීම්</h2>
        <table>
            <tr>
                <th>Doctor / වෛද්‍යවරයා</th>
                <th>Date / දිනය</th>
                <th>Status / තත්ත්වය</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br><a href="channeling_doctors.php" style="color: #b7e4c7;">Back / ආපසු</a>
    </div>
</body>
</html>