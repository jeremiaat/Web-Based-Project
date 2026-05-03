<?php
/**
 * Authentication Functions
 * 
 * This file contains authentication-related helper functions.
 */

/**
 * Check if user is logged in
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Require login - redirect to login page if not logged in
 */
function require_login() {
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

/**
 * Hash password using PHP's default hashing algorithm
 * @param string $password
 * @return string
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 * @param string $password
 * @param string $hashed
 * @return bool
 */
