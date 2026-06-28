<?php
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard | Ayur-Smart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .btn-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(149, 213, 178, 0.3);
            color: #d8f3dc;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: block;
        }
        .btn-card:hover {
            background: #2d6a4f;
            transform: translateY(-5px);
        }
  
.logout-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 10px 25px;
    background-color: transparent;
    color: #ff6b6b;
    border: 1px solid #ff6b6b;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background-color: #ff6b6b;
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <p>Staff Management System</p>

        <div class="menu-grid">
            <a href="pharmacy_manage.php" class="btn-card">Pharmacy<br><small>ඔසුසල</small></a>
            <a href="salon_manage.php" class="btn-card">Salon<br><small>සැලෝන්</small></a>
            <a href="channeling_manage.php" class="btn-card">Channeling<br><small>වෛද්‍ය උපදෙස්</small></a>
        </div>
        
<a href="logout.php" class="logout-btn">Logout (පිටවීම)</a>
    </div>

    <canvas id="canvas"></canvas>
    </body>
</html>