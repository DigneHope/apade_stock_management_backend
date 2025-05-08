<?php
session_start();

function isAuthenticated() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Unauthorized: Please log in"]);
        exit();
    }
}

function isAdmin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(["success" => false, "message" => "Forbidden: Admin access required"]);
        exit();
    }
}
?>