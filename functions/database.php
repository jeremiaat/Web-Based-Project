<?php
/**
 * Database Configuration and Connection
 * 
 * This file handles database connection and configuration.
 * Move database credentials to config file for better security and organization.
 */

// Database configuration - consider moving to config file in production
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'fitness_tracker'
];

/**
 * Get database connection
 * @return mysqli
 */
function get_db_connection() {
    global $db_config;
    
    $conn = new mysqli(
        $db_config['host'], 
        $db_config['username'], 
        $db_config['password'], 
        $db_config['database']
    );
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}
?>
