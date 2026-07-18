<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM product WHERE id = $id");
header("Location: pharmacy_manage.php");
?>