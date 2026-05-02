// JavaScript Form Validation for Fitness Tracker

// Validate Login Form
function validateLoginForm() {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    let isValid = true;
    let errors = [];

    // Reset previous error styles
    email.style.borderColor = '#ddd';
    password.style.borderColor = '#ddd';

    // Validate email
    if (!email.value.trim()) {
        errors.push('Email is required');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (!isValidEmail(email.value)) {
        errors.push('Please enter a valid email address');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate password
    if (!password.value) {
        errors.push('Password is required');
        password.style.borderColor = '#e74c3c';
        isValid = false;
    }

    if (!isValid) {
        displayErrors(errors);
    }

    return isValid;
}

// Validate Register Form
function validateRegisterForm() {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const age = document.getElementById('age');
    const weight = document.getElementById('weight');
    const height = document.getElementById('height');
    const goal = document.getElementById('goal');
    
    let isValid = true;
    let errors = [];

    // Reset previous error styles
    const inputs = [name, email, password, confirmPassword, age, weight, height, goal];
    inputs.forEach(input => {
        if (input) input.style.borderColor = '#ddd';
    });

    // Validate name
    if (!name.value.trim()) {
        errors.push('Name is required');
        name.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate email
    if (!email.value.trim()) {
        errors.push('Email is required');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (!isValidEmail(email.value)) {
        errors.push('Please enter a valid email address');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate password
    if (!password.value) {
        errors.push('Password is required');
        password.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (password.value.length < 6) {
        errors.push('Password must be at least 6 characters');
        password.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate confirm password
    if (!confirmPassword.value) {
        errors.push('Confirm password is required');
        confirmPassword.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (password.value !== confirmPassword.value) {
        errors.push('Passwords do not match');
        confirmPassword.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate age (if provided)
    if (age.value && (age.value < 1 || age.value > 120)) {
        errors.push('Age must be between 1 and 120');
        age.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate weight (if provided)
    if (weight.value && (weight.value < 1 || weight.value > 300)) {
        errors.push('Weight must be between 1 and 300 kg');
        weight.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate height (if provided)
    if (height.value && (height.value < 50 || height.value > 250)) {
        errors.push('Height must be between 50 and 250 cm');
        height.style.borderColor = '#e74c3c';
        isValid = false;
    }

    if (!isValid) {
        displayErrors(errors);
    }

    return isValid;
}

// Validate Workout Form
function validateWorkoutForm() {
    const type = document.getElementById('type');
    const duration = document.getElementById('duration');
    const caloriesBurned = document.getElementById('calories_burned');
    const date = document.getElementById('date');
    
    let isValid = true;
    let errors = [];

    // Reset previous error styles
    [type, duration, caloriesBurned, date].forEach(input => {
        input.style.borderColor = '#ddd';
    });

    // Validate workout type
    if (!type.value) {
        errors.push('Workout type is required');
        type.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate duration
    if (!duration.value || duration.value <= 0) {
        errors.push('Duration must be greater than 0');
        duration.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (duration.value > 600) {
        errors.push('Duration cannot exceed 600 minutes');
        duration.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate calories burned
    if (!caloriesBurned.value || caloriesBurned.value <= 0) {
        errors.push('Calories burned must be greater than 0');
        caloriesBurned.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (caloriesBurned.value > 5000) {
        errors.push('Calories burned cannot exceed 5000');
        caloriesBurned.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate date
    if (!date.value) {
        errors.push('Date is required');
        date.style.borderColor = '#e74c3c';
        isValid = false;
    }

    if (!isValid) {
        displayErrors(errors);
    }

    return isValid;
}

// Validate Meal Form
function validateMealForm() {
    const mealName = document.getElementById('meal_name');
    const calories = document.getElementById('calories');
    const date = document.getElementById('date');
    
    let isValid = true;
    let errors = [];

    // Reset previous error styles
    [mealName, calories, date].forEach(input => {
        input.style.borderColor = '#ddd';
    });

    // Validate meal name
    if (!mealName.value.trim()) {
        errors.push('Meal name is required');
        mealName.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate calories
    if (!calories.value || calories.value <= 0) {
        errors.push('Calories must be greater than 0');
        calories.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (calories.value > 5000) {
        errors.push('Calories cannot exceed 5000');
        calories.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate date
    if (!date.value) {
        errors.push('Date is required');
        date.style.borderColor = '#e74c3c';
        isValid = false;
    }

    if (!isValid) {
        displayErrors(errors);
    }

    return isValid;
}

// Validate Profile Form
function validateProfileForm() {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const age = document.getElementById('age');
    const weight = document.getElementById('weight');
    const height = document.getElementById('height');
    
    let isValid = true;
    let errors = [];

    // Reset previous error styles
    [name, email, age, weight, height].forEach(input => {
        if (input) input.style.borderColor = '#ddd';
    });

    // Validate name
    if (!name.value.trim()) {
        errors.push('Name is required');
        name.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate email
    if (!email.value.trim()) {
        errors.push('Email is required');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    } else if (!isValidEmail(email.value)) {
        errors.push('Please enter a valid email address');
        email.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate age (if provided)
    if (age.value && (age.value < 1 || age.value > 120)) {
        errors.push('Age must be between 1 and 120');
        age.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate weight (if provided)
    if (weight.value && (weight.value < 1 || weight.value > 300)) {
        errors.push('Weight must be between 1 and 300 kg');
        weight.style.borderColor = '#e74c3c';
        isValid = false;
    }

    // Validate height (if provided)
    if (height.value && (height.value < 50 || height.value > 250)) {
        errors.push('Height must be between 50 and 250 cm');
        height.style.borderColor = '#e74c3c';
        isValid = false;
    }

    if (!isValid) {
        displayErrors(errors);
    }

    return isValid;
}

// Helper function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Helper function to display errors
function displayErrors(errors) {
    // Create error container if it doesn't exist
    let errorContainer = document.querySelector('.validation-errors');
    
    if (!errorContainer) {
        errorContainer = document.createElement('div');
        errorContainer.className = 'alert alert-error validation-errors';
        
        // Insert before the first form
        const form = document.querySelector('form');
        if (form) {
            form.parentNode.insertBefore(errorContainer, form);
        }
    }
    
    errorContainer.innerHTML = errors.map(error => `<p>${error}</p>`).join('');
    errorContainer.style.display = 'block';
    
    // Hide after 5 seconds
    setTimeout(() => {
        errorContainer.style.display = 'none';
    }, 5000);
}

// Add input event listeners to remove error styling on focus
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#ddd';
        });
    });
});
