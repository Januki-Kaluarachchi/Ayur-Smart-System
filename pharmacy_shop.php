<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.html");
    exit();
}
$search = isset($_GET['search']) ? $_GET['search'] : '';
$cat = isset($_GET['cat']) ? $_GET['cat'] : null;

$sql = "SELECT * FROM product WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND product_name LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}
if (!empty($cat)) {
    $sql .= " AND category = ?";
    $params[] = $cat;
    $types .= "s";
}
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy | Ayur-Smart</title>
    <style>
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; text-align: center; }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; }
        .filter-nav { margin: 20px; }
        .filter-nav a { color: #b7e4c7; margin: 0 15px; text-decoration: none; font-size: 1.2rem; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 40px; }
        .product-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 20px; border: 1px solid #b7e4c7; transition: 0.3s; cursor: pointer; }
        .product-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
        .btn-add { background: #40916c; color: white; padding: 10px; border-radius: 10px; border: none; margin-top: 10px; }
    </style>
</head>
<body>

   <div class="header-container">
        <div style="display: flex; gap: 10px;">
            <a href="customer_dashboard.php" style="color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">⬅️ Dashboard</a>
        </div>
        
        <h1>ඖෂධ සහ පූජා ද්‍රව්‍ය අංශය</h1>
        
        <div style="display: flex; gap: 10px;">
            <a href="cart.php" style="color: #ffffff; text-decoration: none; border: 1px solid #40916c; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem; background-color: #40916c;">
                🛒 View Cart
            </a>
            <a href="logout.php" style="color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">🚪 Log Out</a>
        </div>
    </div>

    <div style="margin: 20px;">
        <form method="GET" action="pharmacy_shop.php">
            <input type="text" name="search" id="search-input" value="<?php echo htmlspecialchars($search); ?>" 
                   placeholder="ඖෂධ හෝ පූජා ද්‍රව්‍ය සොයන්න..." 
                   style="padding: 10px; width: 300px; border-radius: 10px; border: none;">
            <button type="submit" style="padding: 10px; cursor: pointer;">සොයන්න</button>
            <button type="button" onclick="startVoiceSearch()" style="padding: 10px; background: #40916c; color: white; border: none; border-radius: 10px;">🎤</button>
        </form>
    </div>

    <div class="filter-nav">
        <a href="pharmacy_shop.php">සියල්ල</a> | 
        <a href="pharmacy_shop.php?cat=Medicinal">ඖෂධ</a> | 
        <a href="pharmacy_shop.php?cat=Puja">පූජා ද්‍රව්‍ය</a>
    </div>

    <div class="products-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<a href='product_detail.php?id=".$row['id']."' style='text-decoration:none; color:inherit;'>
                        <div class='product-card'>
                            <img src='".$row['image_url']."' alt='".$row['product_name']."'>
                            <h3>".$row['product_name']."</h3>
                            <p>මිල: LKR ".$row['price']."</p>
                            <button class='btn-add'>තව දැනගන්න</button>
                        </div>
                      </a>";
            }
        } else {
            echo "<div style='grid-column: 1/-1;'><h3>සෙවුමට අදාළ ප්‍රතිඵල නොමැත.</h3></div>";
        }
        ?>
    </div>

    <script>
    function startVoiceSearch() {
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'si-LK'; 
        recognition.start();

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            document.getElementById('search-input').value = transcript;
            document.forms[0].submit();
        };
    }
    </script>
</body>
</html>