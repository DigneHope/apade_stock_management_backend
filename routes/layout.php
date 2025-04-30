<?php
include_once('../middleware/auth.php');

function showLayoutPage() {
    isAuthenticated(); 
    echo "Welcome to the layout page!"; 
}
function manageUsers() {
    isAdmin(); 
    echo "Admin can manage users here!";
}
$requestedRoute = $_SERVER['REQUEST_URI'];

if ($requestedRoute == '/layout') {
    showLayoutPage();
} elseif ($requestedRoute == '/manage-users') {
    manageUsers();
} else {
    http_response_code(404); 
    echo "404: Page not found";
}
?>
