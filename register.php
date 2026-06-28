<?php
include 'db.php';
header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'customer'; 

    $sql = "INSERT INTO users (fullname, username, password, role) VALUES ('$fullname', '$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
?>