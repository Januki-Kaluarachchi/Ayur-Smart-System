<?php
session_start();
//verify if the user is logged in and has the role of 'doctor'
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
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: #081c15; 
            color: #d8f3dc; 
            margin: 0; 
            padding: 40px; 
        }
        .dashboard-container { 
            max-width: 800px; 
            margin: auto; 
            background: rgba(255, 255, 255, 0.05); 
            padding: 30px; 
            border-radius: 20px; 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(183, 228, 199, 0.2);
        }
        h1 { color: #b7e4c7; }
        .card { 
            background: rgba(183, 228, 199, 0.1); 
            padding: 20px; 
            border-radius: 15px; 
            margin-top: 20px; 
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-logout { 
            background: #ff6b6b; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            margin-top: 20px; 
            font-weight: bold;
        }
        .btn-logout:hover { background: #ff5252; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, Dr. <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>This is your professional dashboard for Ayur-Smart System.</p>

        <div class="card">
            <h3>Upcoming Consultations</h3>
            <p>Your scheduled appointments will appear here.</p>
        </div>

        <div class="card">
            <h3>Profile Settings</h3>
            <p>You can update your availability and specialization here.</p>
        </div>

        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

</body>
</html>