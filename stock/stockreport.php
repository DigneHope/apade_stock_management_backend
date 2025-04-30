<?php

include_once '../config/db.php';

$query = "SELECT id, product_name, quantity FROM products";
$stmt = $pdo->prepare($query);
$stmt->execute();
$stock_report = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($stock_report);
?>
