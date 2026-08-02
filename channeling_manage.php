<?php
session_start();
include 'db.php';

// Check if user is staff or admin
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.html");
    exit();
}

// Fetch doctors and their schedules from database
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Doctor Channeling Schedules | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        .container { max-width: 1100px; margin: 40px auto; padding: 20px; }
        h2 { color: #b7e4c7; text-align: center; margin-bottom: 30px; font-size: 2rem; }
        .doctors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .doctor-card { background: rgba(255, 255, 255, 0.05); padding: 25px; border-radius: 20px; border: 1px solid #b7e4c7; backdrop-filter: blur(10px); transition: 0.3s; }
        .doctor-card:hover { transform: translateY(-5px); border-color: #52b788; }
        .doctor-card h3 { color: #b7e4c7; margin-top: 0; font-size: 1.4rem; }
        .doctor-card p { margin: 10px 0; color: #a5c4d4; font-size: 0.95rem; }
        .badge { background: #40916c; color: white; padding: 5px 12px; border-radius: 8px; font-size: 0.85rem; display: inline-block; margin-top: 10px; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem; }
        .btn-back:hover { background: rgba(183, 228, 199, 0.1); }
    </style>
</head>
<body>

    <div class="header-container">
        <div>
            <a href="staff_dashboard.php" class="btn-back">⬅️ Dashboard වෙත</a>
        </div>
        <h2 style="margin: 0; font-size: 1.5rem; color: #b7e4c7;">වෛද්‍ය හමුවීම් කළමනාකරණය</h2>
        <div>
            <a href="logout.php" style="color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">🚪 ඉවත් වන්න</a>
        </div>
    </div>

    <div class="container">
        <h2>🩺 වෛද්‍යවරුන්ගේ කාලසටහන් (Doctor Schedules)</h2>

        <div class="doctors-grid">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='doctor-card'>
                            <h3>ডေါ. " . htmlspecialchars($row['doctor_name']) . "</h3>
                            <p><strong>විශේෂඥතාව:</strong> " . htmlspecialchars($row['specialization']) . "</p>
                            <p><strong>දින සහ වේලාවන්:</strong> " . htmlspecialchars($row['schedule_days'] ?? 'සඳුදා - සිකුරාදා (පෙ.ව. 9.00 - ම.ව. 2.00)') . "</p>
                            <p><strong>දුරකථන අංකය:</strong> " . htmlspecialchars($row['contact'] ?? 'දක්වා නැත') . "</p>
                            <span class='badge'>ප්‍රවේශ්‍යයි</span>
                          </div>";
                }
            } else {
                echo "<div style='grid-column: 1/-1; text-align: center;'><p style='color: #52b788; font-size: 1.2rem;'>നിലവിൽ වෛද්‍යවරුන්ගේ දත්ත ඇතුළත් කර නොමැත.</p></div>";
            }
            ?>
        </div>
    </div>

</body>
</html>