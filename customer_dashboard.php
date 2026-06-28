<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Portal | Ayur-Smart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 50px;
        }
        .service-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid #b7e4c7;
            color: #d8f3dc;
            text-decoration: none;
            transition: 0.3s;
        }
        .service-card:hover {
            background: #2d6a4f;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div style="text-align: center; margin-top: 50px;">
        <h1>ආයුබෝවන්, <?php echo $_SESSION['username']; ?>!</h1>
        <p>ඔබට අවශ්‍ය සේවාව තෝරන්න</p>
    </div>

    <div class="service-grid">
        <a href="pharmacy_shop.php" class="service-card">
            <h2>Pharmacy</h2>
            <p>ඔසුසල</p>
        </a>
        <a href="salon_therapy.php" class="service-card">
            <h2>Salon</h2>
            <p>සැලෝන් (Therapy)</p>
        </a>
        <a href="channeling_doctors.php" class="service-card">
            <h2>Channeling</h2>
            <p>වෛද්‍ය උපදෙස්</p>
        </a>
    </div>

    <div style="text-align: center;">
        <a href="logout.php" class="logout-btn">Logout (පිටවීම)</a>
    </div>

</body>
</html>