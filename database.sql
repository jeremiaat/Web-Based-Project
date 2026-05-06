-- Fitness Tracker Database Schema
-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS fitness_tracker;
USE fitness_tracker;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    weight DECIMAL(5,2),
    height DECIMAL(5,2),
    goal VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Workouts table
CREATE TABLE workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    duration INT NOT NULL, -- in minutes
    calories_burned INT NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Meals table
CREATE TABLE meals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    meal_name VARCHAR(100) NOT NULL,
    calories INT NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Progress table (optional for tracking weight over time)
CREATE TABLE progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_date (user_id, date)
);

-- Insert sample data for testing
INSERT INTO users (name, email, password, age, weight, height, goal) VALUES 
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 25, 75.50, 175.00, 'weight_loss'),
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 30, 65.00, 165.00, 'muscle_gain');

-- Sample workouts
INSERT INTO workouts (user_id, type, duration, calories_burned, date) VALUES
(1, 'Running', 30, 300, '2024-01-15'),
(1, 'Cycling', 45, 400, '2024-01-15'),
(2, 'Yoga', 60, 200, '2024-01-15');

-- Sample meals
INSERT INTO meals (user_id, meal_name, calories, date) VALUES
(1, 'Breakfast - Oatmeal', 350, '2024-01-15'),
(1, 'Lunch - Chicken Salad', 450, '2024-01-15'),
(2, 'Breakfast - Smoothie', 300, '2024-01-15'),
(2, 'Dinner - Grilled Fish', 500, '2024-01-15');

-- Sample progress
INSERT INTO progress (user_id, weight, date) VALUES
(1, 75.50, '2024-01-10'),
(1, 75.30, '2024-01-15'),
(2, 65.00, '2024-01-10'),
(2, 64.80, '2024-01-15');
