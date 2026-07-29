<?php
session_start();
include 'db.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$success_msg = "";
$error_msg = "";

// Handle form submission to add product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    $expiry_date = $_POST['expiry_date'];
    $ingredients = $_POST['ingredients'];
    $usage_instructions = $_POST['usage_instructions'];
    $image_url = $_POST['image_url'];

    // Insert query matching database columns
    $sql = "INSERT INTO product (product_name, description, price, stock_quantity, image_url, expiry_date, category, ingredients, usage_instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisssss", $product_name, $description, $price, $stock_quantity, $image_url, $expiry_date, $category, $ingredients, $usage_instructions);

    if ($stmt->execute()) {
        $success_msg = "Product added successfully!";
    } else {
        $error_msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Manage Stock | Ayur-Smart</title>
    <style>
        body { 
            margin: 0; padding: 20px; 
            font-family: 'Segoe UI', sans-serif; 
            background: radial-gradient(circle at top, #0d2b24, #081c15); 
            color: #d8f3dc; 
            min-height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px 40px;
            border-radius: 20px;
            border: 1px solid rgba(183, 228, 199, 0.3);
            backdrop-filter: blur(10px);
            width: 100%; max-width: 500px;
            text-align: center;
        }
        h1 { margin-bottom: 20px; color: #b7e4c7; }
        input, select, textarea {
            width: 100%; padding: 10px 12px; margin: 8px 0;
            border-radius: 10px; border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white; box-sizing: border-box; font-size: 1rem;
        }
        textarea { resize: vertical; height: 70px; }
        option { background: #081c15; color: white; }
        button {
            width: 100%; padding: 12px; margin-top: 15px;
            border-radius: 10px; border: none;
            background: #40916c; color: white;
            cursor: pointer; font-weight: bold; transition: 0.3s; font-size: 1rem;
        }
        button:hover { background: #52b788; }
        a { color: #b7e4c7; text-decoration: none; display: inline-block; margin-top: 15px; }
        a:hover { text-decoration: underline; }
        .msg-success { color: #52b788; margin-bottom: 10px; font-weight: bold; }
        .msg-error { color: #ff6b6b; margin-bottom: 10px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h1>ADD PRODUCT</h1>

        <?php if(!empty($success_msg)) { echo "<p class='msg-success'>$success_msg</p>"; } ?>
        <?php if(!empty($error_msg)) { echo "<p class='msg-error'>$error_msg</p>"; } ?>

        <form method="POST">
            <input type="text" name="product_name" placeholder="Product Name" required>
            
            <textarea name="description" placeholder="Description (විස්තරය)" required></textarea>
            
            <input type="number" step="0.01" name="price" placeholder="Price (LKR)" required>
            
            <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>
            
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Medicinal">Medicinal</option>
                <option value="Puja">Puja Items</option>
            </select>
            
            <input type="date" name="expiry_date" required>

            <textarea name="ingredients" placeholder="Ingredients (අඩංගු දේ)"></textarea>

            <textarea name="usage_instructions" placeholder="Usage Instructions (පාවිච්චි කරන ආකාරය)"></textarea>
            
            <input type="text" name="image_url" placeholder="Image URL (e.g., uploads/oil.jpg)" required>
            
            <button type="submit">ADD PRODUCT</button>
        </form>
        
        <a href="admin_dashboard.php">⬅️ Go Back</a>
    </div>

</body>
</html>