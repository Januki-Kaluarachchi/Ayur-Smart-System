<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

       
        if ($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($row['role'] == 'staff') {
            header("Location: staff_dashboard.php");
        } elseif ($row['role'] == 'customer') {
            header("Location: customer_dashboard.php");
        } else {
            echo "<script>alert('Invalid Role!'); window.location='login.html';</script>";
        }
        exit();
    } else {
        echo "<script>alert('Invalid Login Details!'); window.location='login.html';</script>";
    }
}
?>