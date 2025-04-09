<div id="sidebar" class="sidebar w-64 bg-white shadow-md z-10 transition-all duration-300 dark:bg-gray-800">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">Portfolio</h1>
            <button id="toggle-sidebar" class="lg:hidden focus:outline-none">
                <i class="fas fa-bars text-gray-500 dark:text-gray-400"></i>
            </button>
        </div>
        <div class="mt-8">
            <div class="flex items-center justify-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                    <i class="fas fa-user text-blue-600 text-xl dark:text-blue-400"></i>
                </div>
            </div>
            <h2 class="text-center text-lg font-semibold text-gray-700 dark:text-gray-300">Welcome, <?php echo $_SESSION['username']; ?></h2>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">Add your projects and skills with ease</p>
        </div>
    </div>
    <nav class="mt-2">
        <a href="dashboard.php" class="flex items-center py-3 px-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'border-blue-600 bg-blue-50 dark:bg-gray-700' : 'border-transparent'; ?> dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-chart-pie mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'text-blue-600 dark:text-blue-400' : ''; ?>"></i>
            <span>Dashboard</span>
        </a>
        <a href="goals.php" class="flex items-center py-3 px-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'goals.php' ? 'border-blue-600 bg-blue-50 dark:bg-gray-700' : 'border-transparent'; ?> dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-tasks mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'goals.php' ? 'text-blue-600 dark:text-blue-400' : ''; ?>"></i>
            <span>My Projects</span>
        </a>
        <a href="skills.php" class="flex items-center py-3 px-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'border-blue-600 bg-blue-50 dark:bg-gray-700' : 'border-transparent'; ?> dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-lightbulb mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'text-blue-600 dark:text-blue-400' : ''; ?>"></i>
            <span>Skills</span>
        </a>
        <a href="achievements.php" class="flex items-center py-3 px-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'achievements.php' ? 'border-blue-600 bg-blue-50 dark:bg-gray-700' : 'border-transparent'; ?> dark:text-gray-300 dark:hover:bg-gray-700">
            <i class="fas fa-medal mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'achievements.php' ? 'text-blue-600 dark:text-blue-400' : ''; ?>"></i>
            <span>Achievements</span>
        </a>
        <a href="profile.php" class="flex items-center py-3 px-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-l-4 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'border-blue-600 bg-blue-50 dark:bg-gray-700' : 'border-transparent'; ?> dark:text-gray-300 dark:hover:bg-gray-700 mt-auto">
            <i class="fas fa-cog mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-blue-600 dark:text-blue-400' : ''; ?>"></i>
            <span>Settings</span>
        </a>
    </nav>
    <div class="p-6 mt-auto">
        <!-- <div class="flex justify-between items-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">Dark Mode</span>
            <label class="switch">
                <input type="checkbox" id="dark-mode-toggle" <?php echo $_SESSION['dark_mode'] ? 'checked' : ''; ?>>
                <span class="w-10 h-5 bg-gray-300 rounded-full flex items-center p-1 cursor-pointer dark:bg-gray-600">
                    <span class="toggle-dot w-4 h-4 bg-white rounded-full shadow-md transform duration-300 ease-in-out dark:translate-x-5"></span>
                </span>
            </label>
        </div> -->
        <a href="logout.php" class="block mt-4 text-center py-2 px-4 rounded bg-red-100 text-red-600 hover:bg-red-200 transition-colors duration-200 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800">
            <i class="fas fa-sign-out-alt mr-2"></i>Log Out
        </a>
    </div>
</div>