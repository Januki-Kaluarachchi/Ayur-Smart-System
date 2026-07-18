<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO salon_appointments (patient_name, therapy_name, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_SESSION['username'], $_POST['therapy_name'], $_POST['date'], $_POST['time']);
    $stmt->execute();
    echo "<script>alert('Booking Success!'); window.location='customer_dashboard.php';</script>";
}
?>