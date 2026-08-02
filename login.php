<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

      
        if ($password === $user['password'] || password_verify($password, $user['password'])) {

            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 

           
            if ($user['role'] === 'supplier') {
                header("Location: supplier_dashboard.php");
                exit();
            } elseif ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($user['role'] === 'doctor') {
                header("Location: doctor_dashboard.php");
                exit();
            } 
            elseif($user['role']== 'staff')
                {
                    header("Location: staff_dashboard.php");
                    exit();
                }
            else {
                header("Location: customer_dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    }
    $stmt->close();
}
$conn->close();
?>