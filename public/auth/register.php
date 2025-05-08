<?php
require_once dirname(__FILE__) . '/../../config/db.php';
$conn = getDatabaseConnection();

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit;
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password required']);
    exit;
}

$checkStmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");

if (!$checkStmt) {
   
    echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
    exit;
}

$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'User already exists']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$insertStmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

if (!$insertStmt) {
    
    echo json_encode(['success' => false, 'message' => 'Error preparing insert statement: ' . $conn->error]);
    exit;
}

$insertStmt->bind_param("ss", $email, $hashedPassword);

if ($insertStmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User registered successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error registering user: ' . $conn->error]);
}
?>