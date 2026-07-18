<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Ayur-Smart</title>
    <style>
        body { 
            margin: 0; padding: 0; 
            font-family: 'Segoe UI', sans-serif; 
            background: radial-gradient(circle at top, #0d2b24, #081c15); 
            color: #d8f3dc; 
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center;
        }
        h1 { font-size: 3rem; margin-top: 50px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        .welcome-text { font-size: 1.2rem; margin-bottom: 40px; opacity: 0.8; }
        
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 30px; 
            padding: 20px; 
            width: 90%; max-width: 1000px; 
        }
        .card { 
            background: rgba(255, 255, 255, 0.05); 
            padding: 40px 20px; 
            border-radius: 20px; 
            text-align: center; 
            border: 1px solid rgba(183, 228, 199, 0.3); 
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }
        .card:hover { 
            transform: translateY(-10px); 
            background: rgba(183, 228, 199, 0.1);
            border-color: #b7e4c7;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .card h3 { margin: 0; font-size: 1.3rem; letter-spacing: 1px; }
        .card div { font-size: 2.5rem; margin-bottom: 15px; }
        a { text-decoration: none; color: inherit; }
        
        .logout-card:hover { border-color: #ff6b6b !important; }
        .logout-text { color: #ff6b6b; }
    </style>
</head>
<body>

    <h1>Admin Control Panel</h1>
    <p class="welcome-text">ආයුබෝවන්, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>!</p>
    
    <div class="dashboard-grid">
        <a href="manage_stock.php">
            <div class="card"><div>📦</div><h3>Manage Stock</h3></div>
        </a>
        <a href="view_reports.php">
            <div class="card"><div>📊</div><h3>View Reports</h3></div>
        </a>
        <a href="manage_users.php">
            <div class="card"><div>👥</div><h3>User List</h3></div>
        </a>
        <a href="logout.php">
            <div class="card logout-card"><div class="logout-text">🚪</div><h3 class="logout-text">Logout</h3></div>
        </a>
        <a href="manage_doctors.php">
    <div class="card">
        <div>🩺</div>
        <h3>Doctor Requests</h3>
        <?php
        include 'db.php';
        $pending = $conn->query("SELECT COUNT(*) as total FROM doctors WHERE status = 'pending'");
        $data = $pending->fetch_assoc();
        echo "<small>Pending: " . $data['total'] . "</small>";
        ?>
    </div>
</a>
    </div>

</body>
</html>