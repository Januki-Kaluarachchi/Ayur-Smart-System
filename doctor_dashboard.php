<?php
session_start();
// verify if the user is logged in and is a doctor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard | Ayur-Smart</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #081c15; color: #d8f3dc; padding: 40px; }
        .dashboard-container { max-width: 900px; margin: auto; background: rgba(255, 255, 255, 0.03); padding: 40px; border-radius: 25px; backdrop-filter: blur(15px); border: 1px solid rgba(183, 228, 199, 0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { margin-bottom: 10px; color: #b7e4c7; }
        p.welcome-msg { opacity: 0.8; margin-bottom: 30px; }
        
        .grid-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: rgba(183, 228, 199, 0.05); padding: 30px; border-radius: 20px; border: 1px solid rgba(183, 228, 199, 0.1); transition: 0.3s; }
        .card:hover { background: rgba(183, 228, 199, 0.1); transform: translateY(-5px); border-color: #b7e4c7; }
        
        .card h3 { margin-bottom: 15px; color: #74c69d; }
        .btn-link { display: inline-block; margin-top: 15px; padding: 10px 20px; background: #2d6a4f; color: white; text-decoration: none; border-radius: 8px; font-size: 0.9rem; transition: 0.3s; }
        .btn-link:hover { background: #40916c; }
        
        .logout-section { margin-top: 40px; text-align: right; }
        .btn-logout { background: #ff6b6b; color: white; padding: 10px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .btn-logout:hover { background: #ff5252; }

        @media (max-width: 600px) { .grid-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, Dr. <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="welcome-msg">Manage your consultations and professional profile from here.</p>

        <div class="grid-container">
            <!-- Consultations Card -->
            <div class="card">
                <h3>Upcoming Consultations</h3>
                <p>View all your scheduled patient appointments for today and the future.</p>
                <a href="view_appointments.php" class="btn-link">View Appointments</a>
            </div>

            <!-- Profile Settings Card -->
            <div class="card">
                <h3>Profile Settings</h3>
                <p>Update your specialization, availability, and professional details.</p>
                <a href="doctor_profile.php" class="btn-link">Edit Profile</a>
            </div>
        </div>

        <div class="logout-section">
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

</body>
</html>