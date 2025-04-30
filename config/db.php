<?php
// Database credentials
$host = "localhost";
$db_name = "apade_stock_management";
$username = "root";
$password = "";

/**
 * Function to establish a database connection
 * 
 * @return mysqli
 */
function getDatabaseConnection() {
    global $host, $username, $password, $db_name;

    // Create connection
    $conn = new mysqli($host, $username, $password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error); // Log the error
        return false; // Return false on connection failure
    }

    return $conn;
}

// Example usage
// $conn = getDatabaseConnection();