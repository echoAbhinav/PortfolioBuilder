<?php
require_once 'includes/config.php';

if(isLoggedIn()) {
    redirect('dashboard.php');
}

$page_title = "Register - PortfolioBuilder";
include 'includes/header.php';

// Handle registration form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);
    
    // Validate inputs
    $errors = [];
    
    if(empty($username)) {
        $errors[] = "Username is required";
    }
    
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if(empty($password)) {
        $errors[] = "Password is required";
    } elseif(strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    if(empty($errors)) {
        if(registerUser($username, $email, $password)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            redirect('login.php');
        } else {
            $errors[] = "Username or email already exists";
        }
    }
}
?>

<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .input-transition {
        transition: all 0.3s ease;
    }
    .input-transition:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.3);
    }
    .btn-hover {
        transition: all 0.3s ease;
    }
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.5);
    }
    .glow {
        animation: glow 2s infinite alternate;
    }
    @keyframes glow {
        from {
            box-shadow: 0 0 5px rgba(118, 75, 162, 0.5);
        }
        to {
            box-shadow: 0 0 20px rgba(118, 75, 162, 0.8);
        }
    }
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #9CA3AF;
    }
    .divider::before, .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #E5E7EB;
    }
    .divider::before {
        margin-right: 1rem;
    }
    .divider::after {
        margin-left: 1rem;
    }
    .dark .divider::before, .dark .divider::after {
        border-bottom-color: #4B5563;
    }
    .password-strength {
        height: 4px;
        margin-top: 4px;
        border-radius: 2px;
        transition: width 0.3s ease, background-color 0.3s ease;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="w-16 h-16 rounded-full gradient-bg flex items-center justify-center shadow-lg glow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            Join PortfolioBuilder
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">
            Create your account to start building your portfolio
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
            <?php if(!empty($errors)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg dark:bg-red-900/20 dark:border-red-400" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-red-700 dark:text-red-300">
                                <?php foreach($errors as $error): ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <form class="space-y-5" action="register.php" method="POST">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Username
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="username" name="username" type="text" required 
                               class="input-transition block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-purple-500">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email address
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required 
                               class="input-transition block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-purple-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Password <span class="text-xs text-gray-500">(min 6 characters)</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required 
                               class="input-transition block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-purple-500">
                    </div>
                    <div id="password-strength" class="password-strength w-0 bg-gray-200 dark:bg-gray-600"></div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Confirm Password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="confirm_password" name="confirm_password" type="password" required 
                               class="input-transition block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-purple-500">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                    <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        I agree to the <a href="#" class="text-purple-600 hover:text-purple-500 dark:text-purple-400 hover:underline">Terms of Service</a>
                    </label>
                </div>

                <div>
                    <button type="submit" class="btn-hover w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white gradient-bg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="divider">
                    <span class="text-sm text-gray-500 dark:text-gray-400 px-2">Already have an account?</span>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <a href="login.php" class="font-medium text-purple-600 hover:text-purple-500 dark:text-purple-400 hover:underline">
                            Sign in to your account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple password strength indicator
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBar = document.getElementById('password-strength');
        let strength = 0;
        
        if (password.length > 0) strength += 25;
        if (password.length >= 6) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/\d/.test(password)) strength += 25;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 50) {
            strengthBar.style.backgroundColor = '#ef4444'; // red
        } else if (strength < 75) {
            strengthBar.style.backgroundColor = '#f59e0b'; // amber
        } else {
            strengthBar.style.backgroundColor = '#10b981'; // emerald
        }
    });
</script>

<?php include 'includes/footer.php'; ?>