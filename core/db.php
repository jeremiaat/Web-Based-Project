<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fitness_tracker';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Function to sanitize input
function sanitize($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Function to hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify password
function verify_password($password, $hashed) {
    return password_verify($password, $hashed);
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to redirect
function redirect($url) {
    // If URL doesn't start with /, prepend the base path
    if (!str_starts_with($url, '/')) {
        $url = "/fitness_tracker/pages/$url";
    }
    header("Location: $url");
    exit();
}

// Function to display success message
function success_message($message) {
    return "<div class='alert alert-success'>$message</div>";
}

// Function to display error message
function error_message($message) {
    return "<div class='alert alert-error'>$message</div>";
}
?>
