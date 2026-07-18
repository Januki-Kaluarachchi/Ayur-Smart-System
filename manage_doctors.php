<?php
include 'db.php';

if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE doctors SET status = 'active' WHERE id = $id");
    header("Location: manage_doctors.php");
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <title>Manage Doctors | Admin</title>
    <style>
        body { font-family: sans-serif; background: #081c15; color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #b7e4c7; text-align: left; }
        .btn-approve { background: #4CAF50; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Pending Doctor Approvals</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Specialization</th>
            <th>License ID</th>
            <th>Action</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM doctors WHERE status = 'pending'");
        while($row = $res->fetch_assoc()) {
            echo "<tr>
                <td>{$row['doctor_name']}</td>
                <td>{$row['specialization']}</td>
                <td>{$row['medical_license_id']}</td>
                <td><a href='manage_doctors.php?approve={$row['id']}' class='btn-approve'>Approve</a></td>
            </tr>";
        }
        ?>
    </table>
    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>