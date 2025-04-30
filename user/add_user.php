// backend/api/user/add_user.php
<?php
require_once '../../utils/jwt_helper.php';
require_once '../../config/db.php';

$headers = apache_request_headers();
$authHeader = $headers['Authorization'];

if (!$authHeader) {
    http_response_code(401);
    echo json_encode(["message" => "Access denied. No token provided."]);
    exit();
}

$token = str_replace('Bearer ', '', $authHeader);
try {
    $decoded = JwtHelper::decode($token);
    
    // Check if user is an admin
    if ($decoded->role !== 'admin') {
        http_response_code(403); // Forbidden
        echo json_encode(["message" => "Access denied. Admins only."]);
        exit();
    }
    
    // Proceed to add the user
    $data = json_decode(file_get_contents("php://input"));
    // Insert user into DB (using your DB connection here)
    echo json_encode(['message' => 'User added successfully']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid token."]);
    exit();
}
