<?php
include_once '../config/db.php';

$product_id = $_POST['product_id'];
$quantity_in = $_POST['quantity_in'];

$query = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$quantity_in, $product_id]);

echo json_encode(["success" => true, "message" => "Stock added successfully"]);
?>
