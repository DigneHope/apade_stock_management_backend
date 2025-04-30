<?php

// 💥 Turn on all errors (your dev-time best friend)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 🌍 Let frontend friends talk to you freely
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 🛡️ Handle preflight requests (important for POST/PUT from frontend)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 🧭 Get the full requested URL (e.g., /apade_stock_management_backend/public/api/login)
$full_uri = $_SERVER['REQUEST_URI'];

// 🧼 Trim off the project base path
$base_path = '/apade_stock_management_backend/public';
$path = str_replace($base_path, '', parse_url($full_uri, PHP_URL_PATH));
$path = trim($path, '/');

// 🧠 Route the request like a wise old switch wizard
switch ($path) {

    // 🔐 Auth routes
    case 'api/login':
        include_once __DIR__ . '/auth/login.php';
        break;

    case 'api/register':
        include_once __DIR__ . '/auth/register.php';
        break;

    // 📦 Product routes
    case 'api/products':
        include_once __DIR__ . '/products/index.php';
        break;

    // 📥 Stock in
    case 'api/stock-in':
        include_once __DIR__ . '/stock/in.php';
        break;

    // 📤 Stock out
    case 'api/stock-out':
        include_once __DIR__ . '/stock/out.php';
        break;

    // 📊 Stock report
    case 'api/stock-report':
        include_once __DIR__ . '/report/index.php';
        break;

    // 👥 User management
    case 'api/users':
        include_once __DIR__ . '/users/index.php';
        break;

    // 🚨 Default if route not matched
    default:
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'API Endpoint not found']);
        break;
}
