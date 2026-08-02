<?php
session_start();
include 'db.php';

// Check if user is staff or admin
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.html");
    exit();
}

$msg = "";
// Handle form submission for adding new doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $schedule = $_POST['schedule'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $medical_license_id = $_POST['medical_license_id'];

    $stmt = $conn->prepare("INSERT INTO doctors (doctor_name, specialization, schedule, username, password, medical_license_id, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("ssssss", $doctor_name, $specialization, $schedule, $username, $password, $medical_license_id);
    
    if ($stmt->execute()) {
        $msg = "නව වෛද්‍යවරයා සාර්ථකව එකතු කරන ලදී!";
    } else {
        $msg = "දෝෂයක් ඇති විය: " . $conn->error;
    }
    $stmt->close();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: channeling_manage.php");
    exit();
}

// Fetch doctors from database
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Doctor Channeling Management | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        .container { max-width: 1100px; margin: 30px auto; padding: 20px; }
        h2 { color: #b7e4c7; text-align: center; margin-bottom: 20px; font-size: 1.8rem; }
        .form-box { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #40916c; margin-bottom: 30px; }
        .form-box input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 8px; border: none; background: rgba(255,255,255,0.1); color: white; box-sizing: border-box; }
        .btn-submit { background: #40916c; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; }
        .btn-submit:hover { background: #52b788; }
        .doctors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .doctor-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 15px; border: 1px solid #b7e4c7; position: relative; }
        .doctor-card h3 { color: #b7e4c7; margin-top: 0; font-size: 1.3rem; }
        .doctor-card p { margin: 8px 0; color: #a5c4d4; font-size: 0.9rem; }
        .btn-delete { background: #ff6b6b; color: white; padding: 6px 12px; text-decoration: none; border-radius: 5px; font-size: 0.8rem; display: inline-block; margin-top: 10px; }
        .btn-back { color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem; }
    </style>
</head>
<body>

    <div class="header-container">
        <div>
            <a href="staff_dashboard.php" class="btn-back">⬅️ Dashboard</a>
        </div>
        <h2 style="margin: 0; font-size: 1.4rem; color: #b7e4c7;">වෛද්‍ය හමුවීම් කළමනාකරණය</h2>
        <div>
            <a href="logout.php" style="color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">🚪 Log Out</a>
        </div>
    </div>

    <div class="container">
        <?php if(!empty($msg)) echo "<p style='color: #52b788; text-align: center; font-weight: bold;'>$msg</p>"; ?>

        <!-- Add Doctor Form -->
        <div class="form-box">
            <h3 style="color: #b7e4c7; margin-top:0;">➕ නව වෛද්‍යවරයකු එකතු කරන්න</h3>
            <form method="POST" action="">
                <input type="text" name="doctor_name" placeholder="වෛද්‍යවරයාගේ නම (උදා: Dr. Amal Perera)" required>
                <input type="text" name="specialization" placeholder="විශේෂඥතාව (උදා: Ayurveda Physician)" required>
                <input type="text" name="schedule" placeholder="කාලසටහන (උදා: 2026-07-25 18:00 හෝ සඳුදා 9AM)" required>
                <input type="text" name="medical_license_id" placeholder="వైද්‍ය බලපත්‍ර අංකය (Medical License ID)" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="add_doctor" class="btn-submit">වෛද්‍යවරයා ඇතුළත් කරන්න</button>
            </form>
        </div>

        <h2>📋 පවතින වෛද්‍යවරුන් සහ කාලසටහන්</h2>

        <div class="doctors-grid">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='doctor-card'>
                            <h3>Dr. " . htmlspecialchars($row['doctor_name']) . "</h3>
                            <p><strong>විශේෂඥතාව:</strong> " . htmlspecialchars($row['specialization']) . "</p>
                            <p><strong>කාලසටහන:</strong> " . htmlspecialchars($row['schedule']) . "</p>
                            <p><strong>බලපත්‍ර අංකය:</strong> " . htmlspecialchars($row['medical_license_id']) . "</p>
                            <p><strong>Username:</strong> " . htmlspecialchars($row['username']) . "</p>
                            <a href='channeling_manage.php?delete=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"මෙම කාලසටහන මකා දැමීමට අවශ්‍ය බව විශ්වාසද?\");'>🗑️ ඉවත් කරන්න</a>
                          </div>";
                }
            } else {
                echo "<div style='grid-column: 1/-1; text-align: center;'><p style='color: #52b788; font-size: 1.1rem;'>වෛද්‍යවරුන්ගේ දත්ත කිසිවක් ඇතුළත් කර නැත.</p></div>";
            }
            ?>
        </div>
    </div>

</body>
</html>