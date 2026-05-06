<?php
session_start();
require_once __DIR__ . '/../core/db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form data
    $name = sanitize($conn, $_POST['name']);
    $email = sanitize($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = isset($_POST['age']) ? (int)$_POST['age'] : null;
    $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : null;
    $height = isset($_POST['height']) ? (float)$_POST['height'] : null;
    $goal = sanitize($conn, $_POST['goal']);
    
    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $check_email = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);
        
        if ($result->num_rows > 0) {
            $errors[] = "Email already exists";
        }
    }
    
    // If no errors, register user
    if (empty($errors)) {
        $hashed_password = hash_password($password);
        
        $sql = "INSERT INTO users (name, email, password, age, weight, height, goal) 
                VALUES ('$name', '$email', '$hashed_password', $age, $weight, $height, '$goal')";
        
        if ($conn->query($sql)) {
            $success = "Registration successful! You can now login.";
            // Clear form data
            $name = $email = $age = $weight = $height = $goal = '';
        } else {
            $errors[] = "Registration failed. Please try again.";
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
    <title>Register - FitTrack Pro</title>
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
            <h1>Create Account</h1>
            <p>Join FitTrack Pro today!</p>
        </div>
        
        <?php if ($success): ?>
            <?php echo success_message($success); ?>
            <p style="text-align: center; margin-top: 1rem;"><a href="/fitness_tracker/pages/login.php">Click here to login</a></p>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <?php echo error_message($error); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="" onsubmit="return validateRegisterForm()">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" placeholder="Enter your full name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password (min 6 chars)" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo isset($age) ? $age : ''; ?>" min="1" max="120" placeholder="Years">
                </div>
                
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" value="<?php echo isset($weight) ? $weight : ''; ?>" min="1" max="300" step="0.1" placeholder="kg">
                </div>
                
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" value="<?php echo isset($height) ? $height : ''; ?>" min="50" max="250" step="0.1" placeholder="cm">
                </div>
            </div>
            
            <div class="form-group">
                <label for="goal">Fitness Goal</label>
                <select id="goal" name="goal">
                    <option value="">Select Goal</option>
                    <option value="weight_loss" <?php echo (isset($goal) && $goal == 'weight_loss') ? 'selected' : ''; ?>>Weight Loss</option>
                    <option value="muscle_gain" <?php echo (isset($goal) && $goal == 'muscle_gain') ? 'selected' : ''; ?>>Muscle Gain</option>
                    <option value="maintenance" <?php echo (isset($goal) && $goal == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="fitness" <?php echo (isset($goal) && $goal == 'fitness') ? 'selected' : ''; ?>>General Fitness</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined">person_add</span>
                Create Account
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Already have an account? <a href="/fitness_tracker/pages/login.php">Login here</a></p>
        </div>
        <?php endif; ?>
    </div>
    
    <script src="/fitness_tracker/assets/js/validation.js"></script>
</body>
</html>
