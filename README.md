# Fitness Tracker System

A clean, simple fitness tracking application built with PHP, MySQL, HTML, CSS, and JavaScript. No frameworks required - perfect for beginners learning full-stack development.

## Features

- **User Authentication**: Register, login, and logout with secure session management
- **User Profile**: Manage personal information (age, weight, height, fitness goal)
- **Workout Tracking**: Log workouts with type, duration, calories burned, and date
- **Meal Tracking**: Record meals with name, calories, and date
- **Dashboard**: View daily summaries, weekly stats, and recent activities
- **Responsive Design**: Works on desktop and mobile devices

## Tech Stack

- **Backend**: PHP (procedural with mysqli)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Environment**: XAMPP (Apache + MySQL)

## Project Structure

```
/fitness_tracker
  ├── assets/
  │   ├── css/
  │   │   └── style.css          # Main stylesheet
  │   ├── js/
  │   │   └── validation.js     # Form validation scripts
  │   └── images/               # Images folder
  ├── config/
  │   └── app.php               # Application configuration
  ├── core/
  │   ├── db.php                # Database connection
  │   ├── header.php            # Header template
  │   └── footer.php            # Footer template
  ├── functions/
  │   ├── auth.php             # Authentication functions
  │   ├── database.php        # Database utilities
  │   └── helpers.php         # Helper functions
  ├── pages/
  │   ├── index.php           # Entry point (redirects to login/dashboard)
  │   ├── login.php          # User login page
  │   ├── register.php       # User registration page
  │   ├── logout.php        # Logout handler
  │   ├── dashboard.php     # Main dashboard with stats
  │   ├── profile.php     # User profile management
  │   ├── add_workout.php # Add and view workouts
  │   └── add_meal.php    # Add and view meals
  ├── templates/
  │   ├── layout.php       # Main layout template
  │   └── auth_layout.php # Auth layout template
  ├── database.sql       # Database schema and sample data
  └── README.md          # This file
```

## How to Run

### Quick Start
1. Start Apache and MySQL in XAMPP
2. Import database.sql in phpMyAdmin
3. Open browser to: http://localhost/fitness_tracker/pages/

### Detailed Instructions

### Prerequisites

- XAMPP installed on your computer
- Basic understanding of PHP and MySQL

### Step 1: Setup XAMPP

1. Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Start Apache and MySQL from the XAMPP Control Panel

### Step 2: Create the Database

1. Open your browser and go to `http://localhost/phpmyadmin/`
2. Click on the "Import" tab
3. Select the `database.sql` file from the fitness_tracker folder
4. Click "Go" to import the database

This will create:
- Database: `fitness_tracker`
- Tables: `users`, `workouts`, `meals`, `progress`
- Sample data for testing

### Step 3: Place the Files

1. Copy the entire `fitness_tracker` folder to `C:\xampp\htdocs\`
2. The full path should be: `C:\xampp\htdocs\fitness_tracker\`

### Step 4: Access the Application

1. Open your browser
2. Go to `http://localhost/fitness_tracker/`
3. You will be redirected to the login page

### Step 5: Test the Application

**Option 1: Use Sample Accounts**
- Email: `john@example.com` / Password: `password`
- Email: `jane@example.com` / Password: `password`

**Option 2: Create Your Own Account**
1. Click "Register here" on the login page
2. Fill in your details
3. Submit the form
4. Login with your new account

## Usage Guide

### Dashboard
- View today's calorie summary (consumed vs burned)
- Check weekly statistics
- See recent workouts and meals
- Quick access to add new entries

### Profile
- Update your personal information
- Set or change your fitness goal
- View your BMI (if weight and height are set)

### Add Workout
- Select workout type (Running, Cycling, Swimming, etc.)
- Enter duration in minutes
- Add calories burned
- Choose the date
- View and delete previous workouts

### Add Meal
- Enter meal name (e.g., "Breakfast - Oatmeal")
- Add calorie count
- Choose the date
- View and delete previous meals

## Database Schema

### Users Table
- `id` - Primary key
- `name` - Full name
- `email` - Unique email address
- `password` - Hashed password
- `age` - Age (optional)
- `weight` - Weight in kg (optional)
- `height` - Height in cm (optional)
- `goal` - Fitness goal (weight_loss, muscle_gain, maintenance, fitness)
- `created_at` - Registration timestamp

### Workouts Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `type` - Workout type
- `duration` - Duration in minutes
- `calories_burned` - Calories burned
- `date` - Workout date
- `created_at` - Creation timestamp

### Meals Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `meal_name` - Name of the meal
- `calories` - Calorie count
- `date` - Meal date
- `created_at` - Creation timestamp

### Progress Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `weight` - Weight measurement
- `date` - Measurement date
- `created_at` - Creation timestamp

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with `mysqli_real_escape_string()`
- XSS prevention with `htmlspecialchars()`
- Session-based authentication
- Input validation (both client-side and server-side)

## Customization

### Change Database Credentials
Edit `db.php` to match your MySQL configuration:
```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fitness_tracker';
```

### Modify Styling
Edit `css/style.css` to customize colors, fonts, and layout.

### Add New Workout Types
Edit the dropdown in `add_workout.php`:
```html
<option value="YourType">Your Type</option>
```

## Troubleshooting

### Database Connection Error
- Ensure Apache and MySQL are running in XAMPP
- Check database credentials in `db.php`
- Verify the database exists in phpMyAdmin

### Session Not Working
- Ensure PHP sessions are enabled in `php.ini`
- Check folder permissions for session storage

### CSS Not Loading
- Verify the CSS file path in your HTML
- Clear your browser cache

## Future Enhancements

- Admin panel for user management
- Progress charts and graphs
- Export data to CSV
- Mobile app version
- Social sharing features
- Workout recommendations
- Meal planning

## License

This project is open source and available for educational purposes.

## Support

For issues or questions, please refer to the code comments or modify the code to suit your needs.

---

**Happy Tracking! 💪**
