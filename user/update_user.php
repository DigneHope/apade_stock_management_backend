<?php
include_once '../config/db.php';

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];

$query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$name, $email, $user_id]);

echo json_encode(["success" => true, "message" => "User updated successfully"]);
?>
