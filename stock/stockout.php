<?php

include_once '../config/db.php';

$product_id = $_POST['product_id'];
$quantity_out = $_POST['quantity_out'];

$query = "SELECT quantity FROM products WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product['quantity'] >= $quantity_out) {

    $query = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$quantity_out, $product_id]);

    echo json_encode(["success" => true, "message" => "Stock deducted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Insufficient stock"]);
}
?>
