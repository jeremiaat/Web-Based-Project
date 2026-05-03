<?php
/**
 * Layout Template
 * 
 * This is the main layout template file.
 * All pages should extend this layout.
 */

$page_title = $page_title ?? 'Fitness Tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/fitness_tracker/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php if (is_logged_in()): ?>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-dumbbell"></i> Fitness Tracker</h1>
                </div>
                
                <nav class="nav">
                    <ul>
                        <li><a href="/fitness_tracker/dashboard.php" class="<?php echo is_active_page('dashboard.php'); ?>">Dashboard</a></li>
                        <li><a href="/fitness_tracker/add_workout.php" class="<?php echo is_active_page('add_workout.php'); ?>">Add Workout</a></li>
                        <li><a href="/fitness_tracker/add_meal.php" class="<?php echo is_active_page('add_meal.php'); ?>">Add Meal</a></li>
                        <li><a href="/fitness_tracker/profile.php" class="<?php echo is_active_page('profile.php'); ?>">Profile</a></li>
                        <li><a href="/fitness_tracker/logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <?php endif; ?>
    
    <main class="main">
        <div class="container">
            <?php if (is_logged_in()): ?>
            <div class="user-welcome">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></strong>!
            </div>
            <?php endif; ?>
            
            <!-- Page Content Start -->
            <?php echo $content ?? ''; ?>
            <!-- Page Content End -->
        </div>
    </main>
    
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Fitness Tracker. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>