<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');
include_once __DIR__ . '/../middleware/auth.php';
include_once __DIR__ . '/../config/db.php';


$full_uri = $_SERVER['REQUEST_URI'];
$base_path = '/apade_stock_management_backend/public';
$path = str_replace($base_path, '', parse_url($full_uri, PHP_URL_PATH));
$path = trim($path, '/');

function showLayoutPage() {
    global $pdo;
    isAdmin();

    try {
        $query = "SELECT user_id, email, role FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "message" => "Admin layout with user management",
            "data" => [
                "layout" => "Admin Dashboard",
                "users" => $users
            ]
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to load user data: " . $e->getMessage()
        ]);
    }
}

function manageUsers() {
    global $pdo;
    isAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $user_id = $data['id'] ?? null;
        $email = $data['email'] ?? null;

        if (!$user_id || !$email) {
            echo json_encode(["success" => false, "message" => "Missing or invalid fields: id and email are required"]);
            exit;
        }

        try {
            $query = "UPDATE users SET email = ? WHERE user_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$email, $user_id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "message" => "User updated successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => "User not found"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Failed to update user: " . $e->getMessage()]);
        }
    } else {
        showLayoutPage();
    }
}

switch ($path) {
    case 'api/layout':
        showLayoutPage();
        break;
    case 'api/manage-users':
        manageUsers();
        break;
    default:
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "404: Page not found"]);
        break;
}
?>