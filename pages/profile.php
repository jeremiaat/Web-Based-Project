<?php
$page_title = 'Profile';
require_once __DIR__ . '/../core/header.php';
require_login();

$errors = [];
$success = '';

// Get current user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form data
    $name = sanitize($conn, $_POST['name']);
    $email = sanitize($conn, $_POST['email']);
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
    
    // Check if email already exists (excluding current user)
    if (empty($errors)) {
        $check_email = "SELECT id FROM users WHERE email = '$email' AND id != $user_id";
        $result = $conn->query($check_email);
        
        if ($result->num_rows > 0) {
            $errors[] = "Email already exists";
        }
    }
    
    // If no errors, update user
    if (empty($errors)) {
        $sql = "UPDATE users SET name = '$name', email = '$email', age = $age, weight = $weight, height = $height, goal = '$goal' WHERE id = $user_id";
        
        if ($conn->query($sql)) {
            $success = "Profile updated successfully!";
            
            // Update session variables
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            
            // Refresh user data
            $result = $conn->query("SELECT * FROM users WHERE id = $user_id");
            $user = $result->fetch_assoc();
        } else {
            $errors[] = "Update failed. Please try again.";
        }
    }
}
?>

<div class="page-header">
    <h1 class="page-title">My Profile</h1>
    <p class="page-subtitle">Update your personal information and fitness goals</p>
</div>

<?php if ($success): ?>
    <?php echo success_message($success); ?>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <?php echo error_message($error); ?>
    <?php endforeach; ?>
<?php endif; ?>

<div class="profile-grid">
    <!-- Profile Form -->
    <div class="profile-card">
        <h3>Update Information</h3>
        <form method="POST" action="" onsubmit="return validateProfileForm()">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" min="1" max="120">
                </div>
                
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" value="<?php echo $user['weight']; ?>" min="1" max="300" step="0.1">
                </div>
                
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" value="<?php echo $user['height']; ?>" min="50" max="250" step="0.1">
                </div>
            </div>
            
            <div class="form-group">
                <label for="goal">Fitness Goal</label>
                <select id="goal" name="goal">
                    <option value="">Select Goal</option>
                    <option value="weight_loss" <?php echo ($user['goal'] == 'weight_loss') ? 'selected' : ''; ?>>Weight Loss</option>
                    <option value="muscle_gain" <?php echo ($user['goal'] == 'muscle_gain') ? 'selected' : ''; ?>>Muscle Gain</option>
                    <option value="maintenance" <?php echo ($user['goal'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="fitness" <?php echo ($user['goal'] == 'fitness') ? 'selected' : ''; ?>>General Fitness</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined">save</span>
                Update Profile
            </button>
        </form>
    </div>
    
    <!-- Stats Card -->
    <div class="stats-card">
        <h3>Account Information</h3>
        <div class="stats-list">
            <div class="stats-row">
                <span class="stats-label">Member Since</span>
                <span class="stats-value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></span>
            </div>
            
            <?php if ($user['age']): ?>
            <div class="stats-row">
                <span class="stats-label">Age</span>
                <span class="stats-value"><?php echo $user['age']; ?> years</span>
            </div>
            <?php endif; ?>
            
            <?php if ($user['weight']): ?>
            <div class="stats-row">
                <span class="stats-label">Weight</span>
                <span class="stats-value"><?php echo $user['weight']; ?> kg</span>
            </div>
            <?php endif; ?>
            
            <?php if ($user['height']): ?>
            <div class="stats-row">
                <span class="stats-label">Height</span>
                <span class="stats-value"><?php echo $user['height']; ?> cm</span>
            </div>
            <?php endif; ?>
            
            <?php if ($user['weight'] && $user['height']): ?>
            <div class="stats-row">
                <span class="stats-label">BMI</span>
                <span class="stats-value"><?php echo number_format($user['weight'] / (($user['height'] / 100) ** 2), 1); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="stats-row">
                <span class="stats-label">Current Goal</span>
                <span class="stats-value"><?php echo ucfirst(str_replace('_', ' ', $user['goal'] ?: 'Not set')); ?></span>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../core/footer.php'; ?>
