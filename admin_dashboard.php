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
        body { font-family: sans-serif; background-color: #081c15; color: #d8f3dc; text-align: center; }
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            padding: 40px; 
            max-width: 900px; 
            margin: auto; 
        }
        .card { 
            background: rgba(255, 255, 255, 0.05); 
            padding: 30px; 
            border-radius: 15px; 
            border: 1px solid #b7e4c7; 
            transition: 0.3s;
            cursor: pointer;
        }
        .card:hover { background: rgba(183, 228, 199, 0.2); }
        .card h3 { margin: 0; color: #b7e4c7; }
        a { text-decoration: none; color: inherit; }
    </style>
</head>
<body>

    <div style="margin-top: 50px;">
        <h1>Admin Control Panel</h1>
        <p>ආයුබෝවන්, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        
        <div class="dashboard-grid">
            <!-- Manage Stock -->
            <a href="manage_stock.php">
                <div class="card"><h3>📦 Manage Stock</h3></div>
            </a>
            
            <!-- View Reports -->
            <a href="view_reports.php">
                <div class="card"><h3>📊 View Reports</h3></div>
            </a>
            
            <!-- User List -->
            <a href="manage_users.php">
                <div class="card"><h3>👥 User List</h3></div>
            </a>
            
            <!-- Logout -->
            <a href="logout.php">
                <div class="card" style="border: 1px solid #ff6b6b;">
                    <h3 style="color: #ff6b6b;">🚪 Logout</h3>
                </div>
            </a>
        </div>
    </div>

</body>
</html>