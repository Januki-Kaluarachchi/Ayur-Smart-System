<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $doctor_name = $_POST['doctor_name'];
    $patient_name = $_SESSION['username']; 
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = 'pending'; 

    $stmt = $conn->prepare("INSERT INTO appointments (doctor_name, patient_name, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $doctor_name, $patient_name, $appointment_date, $appointment_time, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully! / ඔබේ හමුවීම සාර්ථකව වෙන් කෙරිණි.'); window.location='customer_appointments.php';</script>";
    } else {
        echo "<script>alert('Error! Please try again.'); window.location='channeling_doctors.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>