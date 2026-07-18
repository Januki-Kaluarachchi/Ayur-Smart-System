<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $stmt = $conn->prepare("UPDATE appointments SET status = 'confirmed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: view_appointments.php"); 
    } else {
        echo "Error updating record.";
    }
}
?>