<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Manage Stock | Ayur-Smart</title>
    <style>
        body { 
            margin: 0; padding: 0; 
            font-family: 'Segoe UI', sans-serif; 
            background: radial-gradient(circle at top, #0d2b24, #081c15); 
            color: #d8f3dc; 
            min-height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(183, 228, 199, 0.3);
            backdrop-filter: blur(10px);
            width: 100%; max-width: 400px;
            text-align: center;
        }
        h1 { margin-bottom: 30px; color: #b7e4c7; }
        input, select {
            width: 100%; padding: 12px; margin: 10px 0;
            border-radius: 10px; border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white; box-sizing: border-box;
        }
        button {
            width: 100%; padding: 12px; margin-top: 20px;
            border-radius: 10px; border: none;
            background: #40916c; color: white;
            cursor: pointer; font-weight: bold; transition: 0.3s;
        }
        button:hover { background: #52b788; }
        a { color: #b7e4c7; text-decoration: none; display: inline-block; margin-top: 20px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <h1>ADD PRODUCT</h1>
        <form method="POST">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price (LKR)" required>
            <select name="category">
                <option value="Medicinal">Medicinal</option>
                <option value="Puja">Puja Items</option>
            </select>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <button type="submit">ADD PRODUCT</button>
        </form>
        <a href="admin_dashboard.php">⬅️ Go Back</a>
    </div>

</body>
</html>