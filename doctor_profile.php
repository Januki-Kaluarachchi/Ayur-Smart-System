<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile | Ayur-Smart</title>
    <style>
        body { font-family: sans-serif; background: #081c15; color: white; padding: 40px; }
        .container { max-width: 500px; margin: auto; background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: none; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <form action="update_profile_process.php" method="POST">
            <label>Specialization:</label>
            <input type="text" name="specialization" required>
            <label>Available Date:</label>
            <input type="date" name="schedule_date" required>
            <label>Available Time:</label>
            <input type="time" name="schedule_time" required>
            <br><button type="submit">Save Changes</button>
        </form>
        <br><a href="doctor_dashboard.php" style="color: white;">Back to Dashboard</a>
    </div>
</body>
</html>