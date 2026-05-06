<?php
session_start();
require_once __DIR__ . '/../core/db.php';

$errors = [];

// If user is already logged in, redirect to dashboard
if (is_logged_in()) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Validation
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no errors, attempt login
    if (empty($errors)) {
        $sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (verify_password($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to dashboard
                redirect('dashboard.php');
            } else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }
    }
}
?>

<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host . '/fitness_tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitTrack Pro</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css?v=3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <span class="material-symbols-outlined">fitness_center</span>
            </div>
            <h1>Welcome Back</h1>
            <p>Login to your FitTrack Pro account</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <?php echo error_message($error); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form method="POST" action="" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined">login</span>
                Login
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="/fitness_tracker/pages/register.php">Register here</a></p>
        </div>
    </div>
    
    <script src="/fitness_tracker/assets/js/validation.js"></script>
</body>
</html>
