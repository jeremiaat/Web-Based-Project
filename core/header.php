<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

// Check if user is logged in for protected pages
function require_login() {
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

// Helper function to check active page
function is_active_page($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}
?>

<?php
// Define base URL for assets - auto-detect
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host . '/fitness_tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Fitness Tracker'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css?v=3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php if (is_logged_in()): ?>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="material-symbols-outlined brand-icon">fitness_center</span>
            <span class="brand-text">FitTrack</span>
        </div>
        
        <nav class="sidebar-nav">
            <a href="/fitness_tracker/pages/dashboard.php" class="nav-item <?php echo is_active_page('dashboard.php'); ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="/fitness_tracker/pages/add_workout.php" class="nav-item <?php echo is_active_page('add_workout.php'); ?>">
                <span class="material-symbols-outlined">fitness_center</span>
                <span>Workouts</span>
            </a>
            <a href="/fitness_tracker/pages/add_meal.php" class="nav-item <?php echo is_active_page('add_meal.php'); ?>">
                <span class="material-symbols-outlined">restaurant</span>
                <span>Nutrition</span>
            </a>
            <a href="/fitness_tracker/pages/profile.php" class="nav-item <?php echo is_active_page('profile.php'); ?>">
                <span class="material-symbols-outlined">person</span>
                <span>Profile</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="/fitness_tracker/pages/logout.php" class="nav-item logout">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </a>
            <div class="user-mini-profile">
                <div class="user-avatar">
                    <span class="material-symbols-outlined">account_circle</span>
                </div>
                <div class="user-info">
                    <p class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></p>
                    <p class="user-role">Member</p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Top Header -->
    <header class="top-header">
        <div class="header-search">
            <span class="material-symbols-outlined">search</span>
            <input type="text" placeholder="Search workouts, meals..." />
        </div>
        <div class="header-actions">
            <button class="icon-btn">
                <span class="material-symbols-outlined">notifications</span>
            </button>
        </div>
    </header>
    <?php endif; ?>
    
    <main class="main-content">