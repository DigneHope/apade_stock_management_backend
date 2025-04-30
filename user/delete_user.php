<?php
include_once '../config/db.php';

$user_id = $_POST['user_id'];

$query = "DELETE FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);

echo json_encode(["success" => true, "message" => "User deleted successfully"]);
?>
