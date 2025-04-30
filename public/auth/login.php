<?php
require_once dirname(__FILE__) . '/../../config/db.php';

$conn = getDatabaseConnection();




header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';



if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password required']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

$user = $result->fetch_assoc();


if ($user) {
    if (password_verify($password, $user['password'])) {
        // Password is correct

        // Check if the stored password looks like a hash (example check)
        if (strlen($user['password']) < 60 || strpos($user['password'], '$2y$') === false) {
            // Password doesn't look like a strong hash, let's re-hash it
            $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?"); // Assuming you have a user_id
            $updateStmt->bind_param("si", $newHashedPassword, $user['user_id']);
            $updateStmt->execute();

            // Optionally, you might want to fetch the updated user data again
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

        }
            echo json_encode(['success' => true, 'message' => 'Login successful', 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Wrong password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
    ?>