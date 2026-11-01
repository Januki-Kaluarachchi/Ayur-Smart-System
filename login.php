<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 1. Check in the 'doctors' table first if the user is a doctor
    $stmt_doc = $conn->prepare("SELECT * FROM doctors WHERE username = ?");
    $stmt_doc->bind_param("s", $username);
    $stmt_doc->execute();
    $result_doc = $stmt_doc->get_result();

    if ($result_doc->num_rows === 1) {
        $doc = $result_doc->fetch_assoc();
        
        // Verify doctor password (supports both plain text and hashed passwords)
        if ($password === $doc['password'] || password_verify($password, $doc['password'])) {
            $_SESSION['username'] = $doc['doctor_name'];
            $_SESSION['role'] = 'doctor';
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='login.html';</script>";
            exit();
        }
    }

    // 2. If not a doctor, check in the standard 'users' table (Admin, Staff, Supplier, Customer)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify user password (supports both plain text and hashed passwords)
        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 

            // Redirect based on user role
            if ($user['role'] === 'supplier') { 
                header("Location: supplier_dashboard.php"); 
                exit(); 
            } elseif ($user['role'] === 'admin') { 
                header("Location: admin_dashboard.php"); 
                exit(); 
            } elseif ($user['role'] === 'staff') { 
                header("Location: staff_dashboard.php"); 
                exit(); 
            } else { 
                header("Location: customer_dashboard.php"); 
                exit(); 
            }
        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='login.html';</script>";
            exit();
        }
    } 

    // If user is not found in either table
    echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
    
    // Close prepared statements
    $stmt_doc->close();
    if(isset($stmt)) { $stmt->close(); }
}
$conn->close();
?>