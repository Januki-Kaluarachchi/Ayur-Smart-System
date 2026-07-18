<?php
include 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $schedule_date = $_POST['schedule_date']; 
    $schedule_time = $_POST['schedule_time']; 
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $medical_license_id = $_POST['medical_license_id'];
    $status = 'pending';

    $stmt = $conn->prepare("INSERT INTO doctors (doctor_name, specialization, schedule_date, schedule_time, username, password, medical_license_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssss", $doctor_name, $specialization, $schedule_date, $schedule_time, $username, $password, $medical_license_id, $status);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration submitted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>