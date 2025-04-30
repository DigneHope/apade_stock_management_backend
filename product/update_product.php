<?php
include_once '../config/db.php';

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$query = "UPDATE products SET product_name = ?, price = ?, quantity = ? WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$product_name, $price, $quantity, $product_id]);

echo json_encode(["success" => true, "message" => "Product updated successfully"]);
?>
