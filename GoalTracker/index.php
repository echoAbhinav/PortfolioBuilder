<?php
require_once 'includes/config.php';

if(isLoggedIn()) {
    redirect('dashboard.php');
}

$page_title = "GoalTrack Pro - Professional Goal Tracker";
include 'includes/header.php';
?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 dark:bg-gray-900">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h1 class="text-center text-4xl font-extrabold text-blue-600 dark:text-blue-400">Portfolio Builder</h1>
        <h2 class="mt-6 text-center text-2xl font-bold text-gray-900 dark:text-gray-100">
            Professional Portfolio Builder
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 dark:bg-gray-800">
            <div class="flex flex-col space-y-4">
                <a href="login.php" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in
                </a>
                <a href="register.php" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800">
                    Register new account
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>