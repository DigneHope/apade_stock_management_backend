<?php
header('Content-Type: application/json');
include_once '../config/db.php';


if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);


$product_id = $data['id'] ?? null;
$product_name = $data['name'] ?? null; 
$price = $data['price'] ?? null;
$quantity = $data['quantity'] ?? null;


if (!$product_id || !$product_name || !$price || !$quantity) {
    echo json_encode(["success" => false, "message" => "Missing or invalid fields: id, product_name, price, or quantity"]);
    exit;
}

try {
    $query = "UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_name, $price, $quantity, $product_id]);
    echo json_encode(["success" => true, "message" => "Product updated successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Failed to update product: " . $e->getMessage()]);
}
?>