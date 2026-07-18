<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Salon Appointments Manage</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1b4332; }
        th, td { border: 1px solid #40916c; padding: 12px; text-align: left; }
        th { background-color: #2d6a4f; }
        .btn-dashboard { display: inline-block; padding: 10px 20px; background-color: #2d6a4f; color: #d8f3dc; text-decoration: none; border-radius: 8px; border: 1px solid #40916c; margin-bottom: 20px; }
        .btn-del { color: #ff6b6b; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h2>💆 Salon Appointments කළමනාකරණය</h2>
    <a href="staff_dashboard.php" class="btn-dashboard">⬅️ Back to Dashboard</a>

    <table>
        <tr>
            <th>ID</th>
            <th>පාරිභෝගිකයාගේ නම</th>
            <th>ප්‍රතිකාරය</th>
            <th>දිනය</th>
            <th>වේලාව</th>
            <th>ක්‍රියාමාර්ග</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM salon_appointments ORDER BY appointment_date ASC");
        while($row = $res->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['therapy_name']}</td>
                <td>{$row['appointment_date']}</td>
                <td>{$row['appointment_time']}</td>
                <td><a href='delete_salon.php?id={$row['id']}' class='btn-del' onclick='return confirm(\"මකා දැමීමට අවශ්‍යද?\")'>Delete</a></td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>