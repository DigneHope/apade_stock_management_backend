<?php
include_once '../config/db.php';

$product_id = $_POST['product_id'];

$query = "DELETE FROM products WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$product_id]);

echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
?>
