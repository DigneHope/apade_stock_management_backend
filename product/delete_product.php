<?php
header('Content-Type: application/json');
include_once '../config/db.php';


if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$product_id = $data['product_id'] ?? null; 

if (!$product_id) {
    echo json_encode(["success" => false, "message" => "Missing or invalid product_id"]);
    exit;
}

try {
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_id]);

 
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Product not found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Failed to delete product: " . $e->getMessage()]);
}
?>