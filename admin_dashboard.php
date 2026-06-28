<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | Ayur-Smart</title>
    <link rel="stylesheet" href="style.css"> <style>
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px; }
        .card { background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; text-align: center; border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Admin Control Panel</h1>
        <p>Welcome back, <?php echo $_SESSION['username']; ?></p>
        
        <div class="dashboard-grid">
            <div class="card"><h3>Manage Stock</h3></div>
            <div class="card"><h3>View Reports</h3></div>
            <div class="card"><h3>User List</h3></div>
            <div class="card"><a href="logout.php" style="color:red;">Logout</a></div>
        </div>
    </div>
</body>
</html>