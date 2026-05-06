<?php
$page_title = 'Add Meal';
require_once __DIR__ . '/../core/header.php';
require_login();

$errors = [];
$success = '';
$user_id = $_SESSION['user_id'];


if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $meal_id = (int)$_GET['delete'];
    

    $check_meal_exists_sql = "SELECT `id` FROM `meals` WHERE `id` = $meal_id AND `user_id` = $user_id";
    $result = $conn->query($check_meal_exists_sql);
    
    if ($result->num_rows == 1) {
        $delete_meal_sql = "DELETE FROM `meals` WHERE `id` = $meal_id AND `user_id` = $user_id";
        if ($conn->query($delete_meal_sql)) {
            $success = 'Meal deleted successfully!';
        } else {
            $errors[] = 'Failed to delete meal.';
        }
    } else {
        $errors[] = 'Meal not found.';
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $meal_name = sanitize($conn, $_POST['meal_name']);
    $calories = (int)$_POST['calories'];
    $date = sanitize($conn, $_POST['date']);
    

    if (empty($meal_name)) {
        $errors[] = 'Meal name is required';
    }
    
    if (empty($calories) || $calories <= 0) {
        $errors[] = 'Calories must be greater than 0';
    }
    
    if (empty($date)) {
        $errors[] = 'Date is required';
    }
    

    if (empty($errors)) {
        $insert_meal_sql = "INSERT INTO `meals` (`user_id`, `meal_name`, `calories`, `date`) 
                VALUES (" . $user_id . ", '" . $meal_name . "', " . $calories . ", '" . $date . "')";
        
        if ($conn->query($insert_meal_sql)) {
            $success = 'Meal added successfully!';
           
            $meal_name = $calories = $date = '';
        } else {
            $errors[] = 'Failed to add meal. Please try again.';
        }
    }
}


$meals_sql = "SELECT * FROM `meals` WHERE `user_id` = $user_id ORDER BY `date` DESC, `created_at` DESC";
$meals_result = $conn->query($meals_sql);
?>

<div class="page-header">
    <h1 class="page-title">Meal Tracking</h1>
    <p class="page-subtitle">Log your meals and monitor your nutrition</p>
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

    <div class="form-card">
        <h3>Add New Meal</h3>
        <form method="POST" action="" onsubmit="return validateMealForm()">
            <div class="form-group">
                <label for="meal_name">Meal Name</label>
                <input id="meal_name" name="meal_name" type="text" placeholder="e.g., Breakfast - Oatmeal with berries" required>
            </div>
            
            <div class="form-group">
                <label for="calories">Calories</label>
                <input id="calories" name="calories" type="number" min="1" max="5000" required>
            </div>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input id="date" name="date" type="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <span class="material-symbols-outlined">add</span>
                Add Meal
            </button>
        </form>
    </div>
    

    <div class="list-card">
        <h3>Recent Meals</h3>
        
        <?php if ($meals_result->num_rows > 0): ?>
            <div class="items-list">
                <?php while ($meal = $meals_result->fetch_assoc()): ?>
                    <div class="list-item">
                        <div class="list-item-info">
                            <h4><?php echo htmlspecialchars($meal['meal_name']); ?></h4>
                            <p><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">local_fire_department</span> <?php echo $meal['calories']; ?> cal</p>
                            <p><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">calendar_today</span> <?php echo date('M j, Y', strtotime($meal['date'])); ?></p>
                        </div>
                        <div class="list-item-actions">
                            <a href="?delete=<?php echo $meal['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this meal?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <span class="material-symbols-outlined">restaurant</span>
                <p>No meals recorded yet. Start by adding your first meal!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../core/footer.php'; ?>
