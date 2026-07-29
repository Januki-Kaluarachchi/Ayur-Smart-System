<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $company_name = $_POST['company_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    $stmt1 = $conn->prepare("UPDATE users SET fullname = ?, username = ? WHERE id = ?");
    $stmt1->bind_param("ssi", $fullname, $username, $id);
    $stmt1->execute();
    $stmt2 = $conn->prepare("UPDATE suppliers SET company_name = ?, phone_number = ?, address = ? WHERE user_id = ?");
    $stmt2->bind_param("sssi", $company_name, $phone_number, $address, $id);
    $stmt2->execute();

    header("Location: manage_users.php?tab=suppliers");
    exit();
}


$query = "SELECT users.fullname, users.username, suppliers.company_name, suppliers.phone_number, suppliers.address 
          FROM users 
          JOIN suppliers ON users.id = suppliers.user_id 
          WHERE users.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$supplier = $result->fetch_assoc();

if (!$supplier) {
    echo "Supplier not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        .container { max-width: 500px; margin: auto; background: #1b4332; padding: 30px; border-radius: 10px; border: 1px solid #40916c; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #b7e4c7; }
        input, textarea { width: 100%; padding: 10px; border-radius: 5px; background: #081c15; color: white; border: 1px solid #40916c; box-sizing: border-box; }
        .btn { background: #40916c; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn:hover { background: #2d6a4f; }
        .back-link { display: inline-block; margin-top: 15px; color: #b7e4c7; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Supplier Details 📝</h2>
        <form method="POST">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($supplier['fullname']); ?>" required>
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($supplier['username']); ?>" required>
            </div>
            <div class="input-group">
                <label>Company Name</label>
                <input type="text" name="company_name" value="<?php echo htmlspecialchars($supplier['company_name']); ?>" required>
            </div>
            <div class="input-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($supplier['phone_number']); ?>" required>
            </div>
            <div class="input-group">
                <label>Address</label>
                <textarea name="address" rows="3" required><?php echo htmlspecialchars($supplier['address']); ?></textarea>
            </div>
            <button type="submit" class="btn">Update Supplier</button>
        </form>
        <a href="manage_users.php?tab=suppliers" class="back-link">⬅️ Back to Manage Users</a>
    </div>
</body>
</html>