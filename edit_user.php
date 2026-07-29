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

    $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ? WHERE id = ?");
    $stmt->bind_param("ssi", $fullname, $username, $id);
    $stmt->execute();

    header("Location: manage_users.php?tab=customers");
    exit();
}


$stmt = $conn->prepare("SELECT fullname, username FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer - Ayur-Smart</title>
    <style>
        body { background: #081c15; color: #d8f3dc; font-family: sans-serif; padding: 40px; }
        .container { max-width: 500px; margin: auto; background: #1b4332; padding: 30px; border-radius: 10px; border: 1px solid #40916c; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #b7e4c7; }
        input { width: 100%; padding: 10px; border-radius: 5px; background: #081c15; color: white; border: 1px solid #40916c; box-sizing: border-box; }
        .btn { background: #40916c; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn:hover { background: #2d6a4f; }
        .back-link { display: inline-block; margin-top: 15px; color: #b7e4c7; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Customer Details 📝</h2>
        <form method="POST">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <button type="submit" class="btn">Update Customer</button>
        </form>
        <a href="manage_users.php?tab=customers" class="back-link">⬅️ Back to Manage Users</a>
    </div>
</body>
</html>