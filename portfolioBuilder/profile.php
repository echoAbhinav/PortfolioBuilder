<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$userId = getUserId();
$db = new Database();

// Handle profile update
$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    // Validate username and email
    if (empty($username)) {
        $errors[] = 'Username cannot be empty.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    // Validate password change
    if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
        if (empty($currentPassword)) {
            $errors[] = 'Current password is required to change your password.';
        }
        if (empty($newPassword)) {
            $errors[] = 'New password cannot be empty.';
        }
        if ($newPassword !== $confirmPassword) {
            $errors[] = 'New password and confirm password do not match.';
        }
    }

    // If no errors, proceed with the update
    if (empty($errors)) {
        try {
            // Update username and email
            $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
            $db->query($sql);
            $db->bind(':username', $username);
            $db->bind(':email', $email);
            $db->bind(':id', $userId);
            $db->execute();

            // Update password if provided
            if (!empty($currentPassword) && !empty($newPassword)) {
                // Verify current password
                $sql = "SELECT password FROM users WHERE id = :id";
                $db->query($sql);
                $db->bind(':id', $userId);
                $user = $db->single();

                if (!password_verify($currentPassword, $user->password)) {
                    $errors[] = 'Current password is incorrect.';
                } else {
                    // Update password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password = :password WHERE id = :id";
                    $db->query($sql);
                    $db->bind(':password', $hashedPassword);
                    $db->bind(':id', $userId);
                    $db->execute();
                }
            }

            if (empty($errors)) {
                $success = 'Profile updated successfully.';
            }
        } catch (Exception $e) {
            error_log("Error updating profile: " . $e->getMessage());
            $errors[] = 'An error occurred while updating your profile. Please try again.';
        }
    }
}

// Fetch user data
$sql = "SELECT username, email FROM users WHERE id = :id";
$db->query($sql);
$db->bind(':id', $userId);
$user = $db->single();

$page_title = "Profile - PortfolioBuilder";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden bg-gray-50/50 dark:bg-gray-900">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Profile Content -->
        <main class="px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <!-- <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Profile Settings</h1> -->
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Manage your account information and security</p>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Profile Info -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.05)] border border-white/20 dark:border-gray-700/50 p-6">
                            <div class="flex flex-col items-center">
                                <div class="relative mb-4">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                        <?php echo strtoupper(substr($user->username, 0, 1)); ?>
                                    </div>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white"><?php echo htmlspecialchars($user->username); ?></h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?php echo htmlspecialchars($user->email); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Edit Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.05)] border border-white/20 dark:border-gray-700/50 p-6">
                            <?php if (!empty($errors)): ?>
                                <div class="mb-6 bg-red-50/70 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl" role="alert">
                                    <?php foreach ($errors as $error): ?>
                                        <p class="flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> <?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($success)): ?>
                                <div class="mb-6 bg-green-50/70 dark:bg-green-900/20 border border-green-200 dark:border-green-800/50 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl flex items-center" role="alert">
                                    <i class="fas fa-check-circle mr-2"></i> <?php echo htmlspecialchars($success); ?>
                                </div>
                            <?php endif; ?>

                            <form action="profile.php" method="POST">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Username</label>
                                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->username); ?>" 
                                            class="w-full px-4 py-2.5 bg-white/50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm dark:text-white">
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Email Address</label>
                                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" 
                                            class="w-full px-4 py-2.5 bg-white/50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm dark:text-white">
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Change Password</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Current Password</label>
                                                <input type="password" id="current_password" name="current_password" 
                                                    class="w-full px-4 py-2.5 bg-white/50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm dark:text-white">
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">New Password</label>
                                                    <input type="password" id="new_password" name="new_password" 
                                                        class="w-full px-4 py-2.5 bg-white/50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm dark:text-white">
                                                </div>
                                                
                                                <div>
                                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Confirm Password</label>
                                                    <input type="password" id="confirm_password" name="confirm_password" 
                                                        class="w-full px-4 py-2.5 bg-white/50 dark:bg-gray-700/50 border border-gray-200/70 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm dark:text-white">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end pt-4">
                                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 font-medium">
                                            Update Profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>