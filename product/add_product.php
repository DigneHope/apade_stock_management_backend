<?php
header('Content-Type: application/json'); 

include_once '../config/db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'] ?? null;
$price = $data['price'] ?? null;
$quantity = $data['quantity'] ?? null;


if (!$name || !$price || !$quantity) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

try {
    $query = "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $price, $quantity]);
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Failed to add product: " . $e->getMessage()]);
}
?>