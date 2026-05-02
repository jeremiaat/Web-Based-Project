<?php
/**
 * Application Configuration
 * 
 * This file contains application-wide configuration settings.
 */

return [
    // App Info
    'app_name' => 'Fitness Tracker',
    'app_version' => '1.0.0',
    
    // Paths
    'base_path' => '/fitness_tracker',
    'assets_path' => '/fitness_tracker/assets',
    'core_path' => '/fitness_tracker/core',
    'functions_path' => '/fitness_tracker/functions',
    
    // Database
    'db' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'fitness_tracker'
    ],
    
    // Session
    'session' => [
        'name' => 'FITNESS_TRACKER_SESSION',
        'lifetime' => 3600 // 1 hour
    ],
    
    // Validation
    'validation' => [
        'password_min_length' => 6,
        'max_calories' => 5000,
        'max_duration' => 600
    ],
    
    // File Upload
    'upload' => [
        'max_size' => 5242880, // 5MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif']
    ]
];
?>
