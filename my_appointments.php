<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

$current_user = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        table { width: 100%; border-collapse: collapse; background: #1b4332; margin-top: 20px; }
        th, td { border: 1px solid #40916c; padding: 15px; text-align: left; }
        th { background-color: #2d6a4f; }
        .back-btn { display: inline-block; padding: 10px 20px; background: #2d6a4f; color: white; text-decoration: none; border-radius: 8px; }
    </style>
</head>
<body>
    <h2>මගේ හමුවීම් (My Appointments)</h2>
    <a href="salon_therapy.php" class="back-btn">⬅️ ආපසු යන්න</a>

    <table>
        <tr>
            <th>ප්‍රතිකාරය</th>
            <th>දිනය</th>
            <th>වේලාව</th>
        </tr>
        <?php
        $stmt = $conn->prepare("SELECT * FROM salon_appointments WHERE patient_name = ?");
        $stmt->bind_param("s", $current_user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['therapy_name']}</td>
                <td>{$row['appointment_date']}</td>
                <td>{$row['appointment_time']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>