<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/../core/header.php';
require_login();

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Get today's stats
$today_workouts_sql = "SELECT SUM(calories_burned) as total_calories_burned, COUNT(*) as workout_count 
                      FROM workouts WHERE user_id = $user_id AND date = '$today'";
$today_workouts_result = $conn->query($today_workouts_sql);
$today_workouts = $today_workouts_result->fetch_assoc();

$today_meals_sql = "SELECT SUM(calories) as total_calories_consumed, COUNT(*) as meal_count 
                   FROM meals WHERE user_id = $user_id AND date = '$today'";
$today_meals_result = $conn->query($today_meals_sql);
$today_meals = $today_meals_result->fetch_assoc();

// Calculate net calories
$net_calories = ($today_meals['total_calories_consumed'] ?? 0) - ($today_workouts['total_calories_burned'] ?? 0);

// Get weekly stats for chart (last 7 days)
$days = [];
$workout_data = [];
$meal_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $days[] = date('D', strtotime($date));
    
    $day_workout_sql = "SELECT SUM(calories_burned) as total FROM workouts WHERE user_id = $user_id AND date = '$date'";
    $day_workout_result = $conn->query($day_workout_sql);
    $day_workout = $day_workout_result->fetch_assoc();
    $workout_data[] = $day_workout['total'] ?? 0;
    
    $day_meal_sql = "SELECT SUM(calories) as total FROM meals WHERE user_id = $user_id AND date = '$date'";
    $day_meal_result = $conn->query($day_meal_sql);
    $day_meal = $day_meal_result->fetch_assoc();
    $meal_data[] = $day_meal['total'] ?? 0;
}

// Get recent activities
$recent_workouts_sql = "SELECT * FROM workouts WHERE user_id = $user_id 
                       ORDER BY date DESC, created_at DESC LIMIT 5";
$recent_workouts_result = $conn->query($recent_workouts_sql);

$recent_meals_sql = "SELECT * FROM meals WHERE user_id = $user_id 
                    ORDER BY date DESC, created_at DESC LIMIT 5";
$recent_meals_result = $conn->query($recent_meals_sql);

// Get user profile info
$user_sql = "SELECT * FROM users WHERE id = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Calculate percentages for progress bars
$consumed_calories = $today_meals['total_calories_consumed'] ?? 0;
$burned_calories = $today_workouts['total_calories_burned'] ?? 0;
$target_calories = 2500; // Default target
$consumed_pct = min(100, round(($consumed_calories / $target_calories) * 100));
$burned_pct = min(100, round(($burned_calories / 1200) * 100)); // Based on 1200 goal
?>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Hello, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</h1>
    <p class="page-subtitle">Ready to crush your goals today?</p>
</div>

<!-- Metrics Grid -->
<div class="metric-grid">
    <!-- Calories Consumed -->
    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Calories Consumed</span>
            <div class="metric-icon">
                <span class="material-symbols-outlined">restaurant</span>
            </div>
        </div>
        <div class="metric-value">
            <?php echo number_format($consumed_calories); ?> <span class="unit">kcal</span>
        </div>
        <div class="metric-bar">
            <div class="metric-bar-fill" style="width: <?php echo $consumed_pct; ?>%"></div>
        </div>
        <div class="metric-detail"><?php echo $consumed_pct; ?>% of daily target (<?php echo number_format($target_calories); ?> kcal)</div>
    </div>
    <!-- Calories Burned -->
    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Calories Burned</span>
            <div class="metric-icon">
                <span class="material-symbols-outlined">local_fire_department</span>
            </div>
        </div>
        <div class="metric-value">
            <?php echo number_format($burned_calories); ?> <span class="unit">kcal</span>
        </div>
        <div class="metric-bar">
            <div class="metric-bar-fill" style="width: <?php echo $burned_pct; ?>%"></div>
        </div>
        <div class="metric-detail"><?php echo $burned_pct; ?>% of active goal (1,200 kcal)</div>
    </div>

    <!-- Net Calories -->
    <div class="metric-card">
        <div class="metric-header">
            <span class="metric-label">Net Calories</span>
            <div class="metric-icon">
                <span class="material-symbols-outlined">balance</span>
            </div>
        </div>
        <div class="metric-value <?php echo $net_calories < 0 ? 'positive' : ($net_calories > 500 ? 'negative' : ''); ?>">
            <?php echo ($net_calories > 0 ? '+' : '') . number_format($net_calories); ?> <span class="unit">kcal</span>
        </div>
        <div class="metric-bar">
            <div class="metric-bar-fill" style="width: 100%; opacity: 0.2;"></div>
        </div>
        <div class="metric-detail"><?php echo $net_calories < 0 ? 'Caloric deficit - Great job!' : 'Track your burn!'; ?></div>
    </div>
</div>

<!-- Weekly Chart -->
<div class="chart-card">
    <div class="chart-header">
        <div>
            <h2 class="chart-title">Weekly Overview</h2>
            <p class="card-subtitle">Calories burned vs consumed over the last 7 days</p>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="weeklyChart"></canvas>
    </div>
</div>

<!-- Recent Activities -->
<div class="activity-section">
    <!-- Recent Workouts -->
    <div class="activity-list-card">
        <div class="card-header">
            <h3 class="card-title">Recent Workouts</h3>
            <a href="/fitness_tracker/pages/add_workout.php" class="btn btn-link">View All</a>
        </div>
        <div class="activity-list">
            <?php if ($recent_workouts_result->num_rows > 0): ?>
                <?php while ($workout = $recent_workouts_result->fetch_assoc()): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <span class="material-symbols-outlined">fitness_center</span>
                        </div>
                        <div class="activity-info">
                            <div class="activity-name"><?php echo htmlspecialchars($workout['type']); ?></div>
                            <div class="activity-meta"><?php echo $workout['duration']; ?> min • <?php echo date('M j', strtotime($workout['date'])); ?></div>
                        </div>
                        <div class="activity-stats">
                            <div class="activity-value"><?php echo $workout['calories_burned']; ?> cal</div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <span class="material-symbols-outlined">fitness_center</span>
                    <p>No workouts yet. <a href="/fitness_tracker/pages/add_workout.php">Add your first workout!</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Meals -->
    <div class="activity-list-card">
        <div class="card-header">
            <h3 class="card-title">Recent Meals</h3>
            <a href="/fitness_tracker/pages/add_meal.php" class="btn btn-link">View All</a>
        </div>
        <div class="activity-list">
            <?php if ($recent_meals_result->num_rows > 0): ?>
                <?php while ($meal = $recent_meals_result->fetch_assoc()): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <span class="material-symbols-outlined">restaurant</span>
                        </div>
                        <div class="activity-info">
                            <div class="activity-name"><?php echo htmlspecialchars($meal['meal_name']); ?></div>
                            <div class="activity-meta"><?php echo date('M j', strtotime($meal['date'])); ?></div>
                        </div>
                        <div class="activity-stats">
                            <div class="activity-value"><?php echo $meal['calories']; ?> cal</div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <span class="material-symbols-outlined">restaurant</span>
                    <p>No meals yet. <a href="/fitness_tracker/pages/add_meal.php">Add your first meal!</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="/fitness_tracker/pages/add_workout.php" class="action-button">
        <span class="material-symbols-outlined">add</span>
        Add Workout
    </a>
    <a href="/fitness_tracker/pages/add_meal.php" class="action-button">
        <span class="material-symbols-outlined">add</span>
        Add Meal
    </a>
    <a href="/fitness_tracker/pages/profile.php" class="action-button">
        <span class="material-symbols-outlined">person</span>
        Update Profile
    </a>
</div>

<script>
// Weekly Chart
const ctx = document.getElementById('weeklyChart').getContext('2d');
const weeklyChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($days); ?>,
        datasets: [
            {
                label: 'Calories Burned',
                data: <?php echo json_encode($workout_data); ?>,
                backgroundColor: '#006397',
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Calories Consumed',
                data: <?php echo json_encode($meal_data); ?>,
                backgroundColor: '#5cb8fd',
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 20,
                    font: {
                        family: "'Lexend', sans-serif",
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: '#041525',
                padding: 12,
                cornerRadius: 8,
                titleFont: {
                    family: "'Lexend', sans-serif",
                    size: 13
                },
                bodyFont: {
                    family: "'Lexend', sans-serif",
                    size: 12
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f5',
                    drawBorder: false
                },
                ticks: {
                    font: {
                        family: "'Lexend', sans-serif",
                        size: 11
                    },
                    color: '#44474c'
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    font: {
                        family: "'Lexend', sans-serif",
                        size: 11
                    },
                    color: '#44474c'
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});
</script>

<?php include __DIR__ . '/../core/footer.php'; ?>

