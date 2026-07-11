<?php
include 'db.php';
header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'customer'; 


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, ?)");
    
    $stmt->bind_param("ssss", $fullname, $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>