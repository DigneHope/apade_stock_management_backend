<?php
$conn = getDatabaseConnection();
echo json_encode(["success" => true, "message" => "Logged out successfully"]);
?>
