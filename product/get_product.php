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


$query = "SELECT * FROM products";
$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);
?>
