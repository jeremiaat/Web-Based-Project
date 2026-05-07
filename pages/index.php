<?php
session_start();

// If user can logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// If not, redirect to login page
header('Location: login.php');
exit();
?>
