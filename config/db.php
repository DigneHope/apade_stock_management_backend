<?php

$host = 'localhost';
$dbname = 'apade_stock_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}


function getDatabaseConnection() {
    $host = 'localhost';
    $dbname = 'apade_stock_management';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
    }

    return $conn;
}
?>