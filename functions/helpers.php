<?php
/**
 * Helper Functions
 * 
 * This file contains general utility/helper functions.
 */

/**
 * Sanitize input data
 * @param mysqli $conn Database connection
 * @param mixed $data Data to sanitize
 * @return string
 */
function sanitize($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

/**
 * Redirect to specified URL
 * @param string $url
 */
function redirect($url) {
    // If URL doesn't start with /, prepend the base path
    if (!str_starts_with($url, '/')) {
        $url = "/fitness_tracker/$url";
    }
    header("Location: $url");
    exit();
}

/**
 * Display success message
 * @param string $message
 * @return string
 */
function success_message($message) {
    return "<div class='alert alert-success'>$message</div>";
}

/**
 * Display error message
 * @param string $message
 * @return string
 */
function error_message($message) {
    return "<div class='alert alert-error'>$message</div>";
}

/**
 * Get current page name
 * @return string
 */
function get_current_page() {
    return basename($_SERVER['PHP_SELF']);
}

/**
 * Format date for display
 * @param string $date
 * @return string
 */
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Format calories with thousand separators
 * @param int|float $calories
 * @return string
 */
function format_calories($calories) {
    return number_format($calories ?? 0);
}

/**
 * Calculate BMI
 * @param float $weight in kg
 * @param float $height in cm
 * @return float
 */

?>
