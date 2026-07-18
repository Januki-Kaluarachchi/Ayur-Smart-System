<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard | Ayur-Smart</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #081c15; color: #d8f3dc; margin: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; }
        h1 { margin-bottom: 10px; color: #b7e4c7; }
        .dashboard-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px; width: 80%; max-width: 800px; }
        .nav-card { background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 20px; border: 1px solid #40916c; text-align: center; transition: 0.3s; text-decoration: none; color: #d8f3dc; }
        .nav-card:hover { background: #1b4332; transform: scale(1.05); border-color: #74c69d; }
        .nav-card h3 { margin-bottom: 5px; }
        .logout-btn { margin-top: 30px; padding: 10px 25px; border-radius: 30px; background: #ff6b6b; color: white; text-decoration: none; }
        .logout-btn:hover { background: #e63946; }
    </style>
</head>
<body>

    <h1>ආයුබෝවන්, Staff!</h1>
    <p>Staff Dashboard | Ayur-Smart</p>

    <div class="dashboard-container">
        <a href="pharmacy_manage.php" class="nav-card">
            <h3>💊 Pharmacy</h3>
            <p>ඖෂධ කළමනාකරණය</p>
        </a>
        <a href="salon_appointments_manage.php" class="nav-card">
            <h3>💆 Salon</h3>
            <p>ප්‍රතිකාර හමුවීම්</p>
        </a>
        <a href="channeling_manage.php" class="nav-card">
            <h3>🩺 Channeling</h3>
            <p>වෛද්‍ය හමුවීම්</p>
        </a>
    </div>

    <a href="logout.php" class="logout-btn">🚪 Logout (පිටවීම)</a>

</body>
</html>