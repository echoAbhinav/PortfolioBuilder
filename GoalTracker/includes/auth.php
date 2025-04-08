<?php
// Authentication functions

// Register new user
function registerUser($username, $email, $password) {
    $db = new Database();
    
    // Check if username or email already exists
    $db->query("SELECT id FROM users WHERE username = :username OR email = :email");
    $db->bind(':username', $username);
    $db->bind(':email', $email);
    $db->execute();
    
    if($db->rowCount() > 0) {
        return false; // User already exists
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $db->query("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $db->bind(':username', $username);
    $db->bind(':email', $email);
    $db->bind(':password', $hashedPassword);
    
    if($db->execute()) {
        return true;
    }
    return false;
}

// Login user
function loginUser($username, $password) {
    $db = new Database();
    
    // Get user by username
    $db->query("SELECT * FROM users WHERE username = :username");
    $db->bind(':username', $username);
    $user = $db->single();
    
    if($user && password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['dark_mode'] = $user->dark_mode;
        return true;
    }
    return false;
}

// Update user dark mode preference
function updateDarkModePreference($userId, $darkMode) {
    $db = new Database();
    $db->query("UPDATE users SET dark_mode = :dark_mode WHERE id = :id");
    $db->bind(':dark_mode', $darkMode);
    $db->bind(':id', $userId);
    return $db->execute();
}
?>