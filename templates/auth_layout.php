<?php
/**
 * Auth Layout Template
 * 
 * This is the layout template for authentication pages (login/register).
 */

$page_title = $page_title ?? 'Fitness Tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Fitness Tracker</title>
    <link rel="stylesheet" href="/fitness_tracker/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1><i class="fas fa-dumbbell"></i> Fitness Tracker</h1>
        </div>
        
        <!-- Page Content Start -->
        <?php echo $content ?? ''; ?>
        <!-- Page Content End -->
        
        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Fitness Tracker. All rights reserved.</p>
        </div>
    </div>
    
    <script src="/fitness_tracker/assets/js/validation.js"></script>
</body>
</html>
