<?php
include 'db.php';
header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'customer'; 

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $conn->begin_transaction();

    try {
  
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $username, $hashed_password, $role);
        $stmt->execute();
        
        $user_id = $stmt->insert_id;
        $stmt->close();

        if ($role === 'supplier') {
            $company_name = $_POST['company_name'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];

            $stmt_sup = $conn->prepare("INSERT INTO suppliers (user_id, company_name, phone_number, address) VALUES (?, ?, ?, ?)");
            $stmt_sup->bind_param("isss", $user_id, $company_name, $phone_number, $address);
            $stmt_sup->execute();
            $stmt_sup->close();
        }

        $conn->commit();
        echo json_encode(["status" => "success"]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $conn->close();
}
?>