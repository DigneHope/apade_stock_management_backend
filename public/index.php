<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


$full_uri = $_SERVER['REQUEST_URI'];

$base_path = '/apade_stock_management_backend/public';
$path = str_replace($base_path, '', parse_url($full_uri, PHP_URL_PATH));
$path = trim($path, '/');


switch ($path) {

   
    case 'api/login':
        include_once __DIR__ . '/auth/login.php';
        break;

    case 'api/register':
        include_once __DIR__ . '/auth/register.php';
        break;

    
    case 'api/products':
        include_once __DIR__ . '/products/index.php';
        break;

    
    case 'api/stock-in':
        include_once __DIR__ . '/stock/in.php';
        break;

    
    case 'api/stock-out':
        include_once __DIR__ . '/stock/out.php';
        break;

    case 'api/stock-report':
        include_once __DIR__ . '/report/index.php';
        break;

   
    case 'api/users':
        include_once __DIR__ . '/users/index.php';
        break;
        case 'api/layout':
            include_once __DIR__ . '/../routes/layout.php';
            break;
        case 'api/manage-users':
            include_once __DIR__ . '/../routes/layout.php';
            break;

    
    default:
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'API Endpoint not found']);
        break;
}
