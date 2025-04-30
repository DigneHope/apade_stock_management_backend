<?php
include_once '../config/db.php';

$product_name = $_POST['product_name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$query = "INSERT INTO products (product_name, price, quantity) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$product_name, $price, $quantity]);

echo json_encode(["success" => true, "message" => "Product added successfully"]);
?>
