<?php
$page_title = 'Add Workout';
require_once __DIR__ . '/../core/header.php';
require_login();

$errors = [];
$success = '';

// Handle workout deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $workout_id = (int)$_GET['delete'];
    $user_id = $_SESSION['user_id'];
    
    // Verify workout belongs to current user
    $check_sql = "SELECT id FROM workouts WHERE id = $workout_id AND user_id = $user_id";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows == 1) {
        $delete_sql = "DELETE FROM workouts WHERE id = $workout_id AND user_id = $user_id";
        if ($conn->query($delete_sql)) {
            $success = "Workout deleted successfully!";
        } else {
            $errors[] = "Failed to delete workout.";
        }
    } else {
        $errors[] = "Workout not found.";
    }
}

// Handle workout addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = sanitize($conn, $_POST['type']);
    $duration = (int)$_POST['duration'];
    $calories_burned = (int)$_POST['calories_burned'];
    $date = sanitize($conn, $_POST['date']);
    $user_id = $_SESSION['user_id'];
    
    // Validation
    if (empty($type)) {
        $errors[] = "Workout type is required";
    }
    
    if (empty($duration) || $duration <= 0) {
        $errors[] = "Duration must be greater than 0";
    }
    
    if (empty($calories_burned) || $calories_burned <= 0) {
        $errors[] = "Calories burned must be greater than 0";
    }
    
    if (empty($date)) {
        $errors[] = "Date is required";
    }
    
    // If no errors, add workout
    if (empty($errors)) {
        $sql = "INSERT INTO workouts (user_id, type, duration, calories_burned, date) 
                VALUES ($user_id, '$type', $duration, $calories_burned, '$date')";
        
        if ($conn->query($sql)) {
            $success = "Workout added successfully!";
            // Clear form
            $type = $duration = $calories_burned = $date = '';
        } else {
            $errors[] = "Failed to add workout. Please try again.";
        }
    }
}

// Get user's workouts
$user_id = $_SESSION['user_id'];
$workouts_sql = "SELECT * FROM workouts WHERE user_id = $user_id ORDER BY date DESC, created_at DESC";
$workouts_result = $conn->query($workouts_sql);
?>

<div class="page-header">
    <h1 class="page-title">Workout Tracking</h1>
    <p class="page-subtitle">Log your exercises and track your progress</p>
</div>

<?php if ($success): ?>
    <?php echo success_message($success); ?>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <?php echo error_message($error); ?>
    <?php endforeach; ?>
<?php endif; ?>

<div class="form-page-grid">
    <!-- Add Workout Form -->
    <div class="form-card">
        <h3>Add New Workout</h3>
        <form method="POST" action="" onsubmit="return validateWorkoutForm()">
            <div class="form-group">
                <label for="type">Workout Type</label>
                <select id="type" name="type" required>
                    <option value="">Select Workout Type</option>
                    <option value="Running">Running</option>
                    <option value="Walking">Walking</option>
                    <option value="Cycling">Cycling</option>
                    <option value="Swimming">Swimming</option>
                    <option value="Weight Training">Weight Training</option>
                    <option value="Yoga">Yoga</option>
                    <option value="Pilates">Pilates</option>
                    <option value="Dancing">Dancing</option>
                    <option value="Sports">Sports</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" id="duration" name="duration" min="1" max="600" required>
                </div>
                
                <div class="form-group">
                    <label for="calories_burned">Calories Burned</label>
                    <input type="number" id="calories_burned" name="calories_burned" min="1" max="5000" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span>
                Add Workout
            </button>
        </form>
    </div>
    
    <!-- Recent Workouts List -->
    <div class="list-card">
        <h3>Recent Workouts</h3>
        
        <?php if ($workouts_result->num_rows > 0): ?>
            <div class="items-list">
                <?php while ($workout = $workouts_result->fetch_assoc()): ?>
                    <div class="list-item">
                        <div class="list-item-info">
                            <h4><?php echo htmlspecialchars($workout['type']); ?></h4>
                            <p><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">schedule</span> <?php echo $workout['duration']; ?> min</p>
                            <p><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">local_fire_department</span> <?php echo $workout['calories_burned']; ?> cal</p>
                            <p><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">calendar_today</span> <?php echo date('M j, Y', strtotime($workout['date'])); ?></p>
                        </div>
                        <div class="list-item-actions">
                            <a href="?delete=<?php echo $workout['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this workout?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <span class="material-symbols-outlined">fitness_center</span>
                <p>No workouts recorded yet. Start by adding your first workout!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../core/footer.php'; ?>
