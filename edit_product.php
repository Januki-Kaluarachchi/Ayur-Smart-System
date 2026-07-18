<?php
include 'db.php';
$id = $_GET['id'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $conn->query("UPDATE product SET product_name='$name', price='$price' WHERE id=$id");
    header("Location: pharmacy_manage.php");
}

$row = $conn->query("SELECT * FROM product WHERE id=$id")->fetch_assoc();
?>
<form method="POST">
    <input type="text" name="name" value="<?php echo $row['product_name']; ?>">
    <input type="number" name="price" value="<?php echo $row['price']; ?>">
    <button type="submit" name="update">Update</button>
</form>