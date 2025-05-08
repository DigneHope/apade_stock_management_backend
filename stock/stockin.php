<?php
header('Content-Type: application/json');
include_once '../config/db.php';


if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);

$product_id = $data['id'] ?? null; 
$quantity_in = $data['quantity'] ?? null; 


if (!$product_id || !$quantity_in) {
    echo json_encode(["success" => false, "message" => "Missing or invalid fields: id and quantity are required"]);
    exit;
}


$quantity_in = (int)$quantity_in;
if ($quantity_in <= 0) {
    echo json_encode(["success" => false, "message" => "Quantity must be a positive number"]);
    exit;
}

try {
    $query = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$quantity_in, $product_id]);

  
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Stock added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Product not found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Failed to update stock: " . $e->getMessage()]);
}
?>