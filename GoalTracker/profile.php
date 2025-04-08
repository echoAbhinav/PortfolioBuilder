<?php
require_once 'includes/config.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$userId = getUserId();
$db = new Database();

// Handle profile update
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $current_password = sanitize($_POST['current_password']);
    $new_password = sanitize($_POST['new_password']);
    $confirm_password = sanitize($_POST['confirm_password']);
    
    $errors = [];
    
    // Get current user data
    $db->query("SELECT * FROM users WHERE id = :id");
    $db->bind(':id', $userId);
    $user = $db->single();
    
    // Validate username
    if(empty($username)) {
        $errors[] = "Username is required";
    } elseif($username != $user->username) {
        // Check if new username is available
        $db->query("SELECT id FROM users WHERE username = :username AND id != :id");
        $db->bind(':username', $username);
        $db->bind(':id', $userId);
        $db->execute();
        
        if($db->rowCount() > 0) {
            $errors[] = "Username already taken";
        }
    }
    
    // Validate email
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } elseif($email != $user->email) {
        // Check if new email is available
        $db->query("SELECT id FROM users WHERE email = :email AND id != :id");
        $db->bind(':email', $email);
        $db->bind(':id', $userId);
        $db->execute();
        
        if($db->rowCount() > 0) {
            $errors[] = "Email already in use";
        }
    }
    
    // Validate password change if requested
    if(!empty($new_password)) {
        if(empty($current_password)) {
            $errors[] = "Current password is required to change password";
        } elseif(!password_verify($current_password, $user->password)) {
            $errors[] = "Current password is incorrect";
        } elseif(strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters";
        } elseif($new_password != $confirm_password) {
            $errors[] = "New passwords do not match";
        }
    }
    
    if(empty($errors)) {
        // Update user profile
        $query = "UPDATE users SET username = :username, email = :email";
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':id' => $userId
        ];
        
        if(!empty($new_password)) {
            $query .= ", password = :password";
            $params[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }
        
        $query .= " WHERE id = :id";
        
        $db->query($query);
        foreach($params as $key => $value) {
            $db->bind($key, $value);
        }
        
        if($db->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $success = "Profile updated successfully";
        } else {
            $errors[] = "Failed to update profile";
        }
    }
}

// Get current user data
$db->query("SELECT * FROM users WHERE id = :id");
$db->bind(':id', $userId);
$user = $db->single();

$page_title = "Profile - GoalTrack Pro";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Profile Content -->
        <main class="px-6 py-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 dark:text-gray-200">Profile Settings</h2>
                    
                    <?php if(isset($errors)): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <?php foreach($errors as $error): ?>
                                <span class="block sm:inline"><?php echo $error; ?></span><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($success)): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?php echo $success; ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <form action="profile.php" method="POST">
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo $user->username; ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo $user->email; ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Current Password (leave blank to keep current)</label>
                            <input type="password" id="current_password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">New Password (leave blank to keep current)</label>
                            <input type="password" id="new_password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="mb-6">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>