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
        body { background-color: #081c15; color: #d8f3dc; font-family: sans-serif; text-align: center; margin: 0; padding: 0; }
        .header-container { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(183, 228, 199, 0.2); }
        .filter-nav { margin: 20px; }
        .filter-nav a { color: #b7e4c7; margin: 0 15px; text-decoration: none; font-size: 1.2rem; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 40px; }
        .product-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 20px; border: 1px solid #b7e4c7; transition: 0.3s; cursor: pointer; }
        .product-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
        .btn-add { background: #40916c; color: white; padding: 10px; border-radius: 10px; border: none; margin-top: 10px; cursor: pointer; }
        .btn-add:hover { background: #52b788; }
    </style>
</head>
<body>

    <div class="header-container">
        <div style="display: flex; gap: 10px;">
            <a href="customer_dashboard.php" style="color: #b7e4c7; text-decoration: none; border: 1px solid #b7e4c7; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">⬅️ Dashboard</a>
        </div>
        
        <h1 style="color: #b7e4c7; margin: 0; font-size: 1.8rem;">ඖෂධ සහ පූජා ද්‍රව්‍ය අංශය</h1>
        
        <div style="display: flex; gap: 10px;">
            <a href="cart.php" style="background: #2d6a4f; color: white; padding: 8px 15px; text-decoration: none; border-radius: 8px; font-size: 0.9rem;">View Cart</a>
            <a href="my_orders.php" style="background: #40916c; color: white; padding: 8px 15px; text-decoration: none; border-radius: 8px; font-size: 0.9rem;">📦 My Orders</a>
            <a href="logout.php" style="color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 8px 15px; border-radius: 8px; font-size: 0.9rem;">🚪 Log Out</a>
        </div>
    </div>

    <div style="margin: 30px;">
        <form method="GET" action="pharmacy_shop.php">
            <input type="text" name="search" id="search-input" value="<?php echo htmlspecialchars($search); ?>" 
                   placeholder="ඖෂධ හෝ පූජා ද්‍රව්‍ය සොයන්න..." 
                   style="padding: 10px; width: 300px; border-radius: 10px; border: none; background: rgba(255,255,255,0.1); color: white;">
            <button type="submit" style="padding: 10px 15px; cursor: pointer; border-radius: 10px; border: none; background: #2d6a4f; color: white;">සොයන්න</button>
            <button type="button" onclick="startVoiceSearch()" style="padding: 10px 15px; background: #40916c; color: white; border: none; border-radius: 10px; cursor: pointer;" title="Voice Search">🎤</button>
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
                            <h3 style='color: #b7e4c7;'>".$row['product_name']."</h3>
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
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        
        if (!SpeechRecognition) {
            alert("Error .... please use  Google Chrome .");
            return;
        }

        const recognition = new SpeechRecognition();
        recognition.lang = 'si-LK'; 
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        recognition.start();
        console.log("Voice search started. Speak now...");

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            console.log("Recognized text: " + transcript);
            document.getElementById('search-input').value = transcript;
            document.forms[0].submit();
        };

        recognition.onerror = function(event) {
            console.error("Speech recognition error: ", event.error);
            alert("Error .... please use  Google Chrome .");
        };
    }
    </script>
</body>
</html>