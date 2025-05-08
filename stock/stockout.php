<?php
header('Content-Type: application/json');
include_once '../config/db.php';


if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);


$product_id = $data['id'] ?? null; 
$quantity_out = $data['quantity'] ?? null; 


if (!$product_id || !$quantity_out) {
    echo json_encode(["success" => false, "message" => "Missing or invalid fields: id and quantity are required"]);
    exit;
}


$quantity_out = (int)$quantity_out;
if ($quantity_out <= 0) {
    echo json_encode(["success" => false, "message" => "Quantity must be a positive number"]);
    exit;
}

try {
   
    $check_query = "SELECT quantity FROM products WHERE id = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$product_id]);
    $product = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(["success" => false, "message" => "Product not found"]);
        exit;
    }

    if ($product['quantity'] < $quantity_out) {
        echo json_encode(["success" => false, "message" => "Insufficient stock"]);
        exit;
    }

   
    $update_query = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$quantity_out, $product_id]);


    if ($update_stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Stock deducted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to deduct stock"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Failed to update stock: " . $e->getMessage()]);
}
?>