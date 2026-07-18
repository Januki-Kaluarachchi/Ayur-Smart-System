<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            if ($row['role'] == 'admin') header("Location: admin_dashboard.php");
            elseif ($row['role'] == 'staff') header("Location: staff_dashboard.php");
            else header("Location: customer_dashboard.php");
            exit();
        }
    } 

    else {
        $stmt = $conn->prepare("SELECT id, doctor_name, password, status FROM doctors WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
      
            if ($row['status'] === 'active' && password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['doctor_name'];
                $_SESSION['role'] = 'doctor'; 
                header("Location: doctor_dashboard.php");
                exit();
            } elseif ($row['status'] === 'pending') {
                echo "<script>alert('Your account is still pending approval!'); window.location='login.html';</script>";
                exit();
            }
        }
    }

    echo "<script>alert('Invalid Login Details!'); window.location='login.html';</script>";
    $stmt->close();
    $conn->close();
}
?>