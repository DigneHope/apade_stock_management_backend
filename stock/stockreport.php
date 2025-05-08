<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');
include_once '../config/db.php';


if (!isset($pdo)) {
    echo json_encode(["success" => false, "message" => "Database connection not established"]);
    exit;
}

try {
    $query = "SELECT id, name, quantity FROM products";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $stock_report = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "message" => "Stock report retrieved successfully",
        "data" => $stock_report
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to retrieve stock report: " . $e->getMessage()
    ]);
}
?>