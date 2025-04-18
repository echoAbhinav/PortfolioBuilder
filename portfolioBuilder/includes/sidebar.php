<div id="sidebar" class="sidebar w-72 bg-gradient-to-b from-blue-50 to-white shadow-xl z-10 transition-all duration-300 dark:from-gray-800 dark:to-gray-900">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">Portfolio Pro</h1>
            <button id="toggle-sidebar" class="lg:hidden focus:outline-none">
                <i class="fas fa-bars text-gray-600 dark:text-gray-300 text-xl"></i>
            </button>
        </div>
        <div class="mt-8">
            <div class="flex items-center justify-center mb-6">
                <div class="relative">
                    <div class="w-20 h-20 bg-gradient-to-tr from-blue-400 to-indigo-500 rounded-full flex items-center justify-center shadow-lg dark:from-blue-600 dark:to-indigo-700">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <span class="absolute bottom-0 right-0 w-5 h-5 bg-green-400 rounded-full border-2 border-white dark:border-gray-800"></span>
                </div>
            </div>
            <h2 class="text-center text-lg font-semibold text-gray-800 dark:text-gray-100"><?php echo $_SESSION['username']; ?></h2>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-1">Portfolio Manager</p>
            <div class="flex justify-center mt-3">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full dark:bg-blue-900 dark:text-blue-200">Premium</span>
            </div>
        </div>
    </div>
    <nav class="mt-4 px-3">
        <a href="dashboard.php" class="flex items-center py-3 px-5 text-gray-700 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all duration-200 rounded-lg mb-1 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-white shadow-sm text-blue-600 font-medium dark:bg-gray-700 dark:text-blue-400' : 'dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
            <i class="fas fa-chart-pie mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400'; ?>"></i>
            <span>Dashboard</span>
            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-200">3</span>
        </a>
        <a href="goals.php" class="flex items-center py-3 px-5 text-gray-700 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all duration-200 rounded-lg mb-1 <?php echo basename($_SERVER['PHP_SELF']) == 'goals.php' ? 'bg-white shadow-sm text-blue-600 font-medium dark:bg-gray-700 dark:text-blue-400' : 'dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
            <i class="fas fa-tasks mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'goals.php' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400'; ?>"></i>
            <span>My Projects</span>
        </a>
        <a href="skills.php" class="flex items-center py-3 px-5 text-gray-700 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all duration-200 rounded-lg mb-1 <?php echo basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'bg-white shadow-sm text-blue-600 font-medium dark:bg-gray-700 dark:text-blue-400' : 'dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
            <i class="fas fa-lightbulb mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400'; ?>"></i>
            <span>Skills</span>
            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full dark:bg-green-900 dark:text-green-200">New</span>
        </a>
        <a href="achievements.php" class="flex items-center py-3 px-5 text-gray-700 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all duration-200 rounded-lg mb-1 <?php echo basename($_SERVER['PHP_SELF']) == 'achievements.php' ? 'bg-white shadow-sm text-blue-600 font-medium dark:bg-gray-700 dark:text-blue-400' : 'dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
            <i class="fas fa-medal mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'achievements.php' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400'; ?>"></i>
            <span>Achievements</span>
        </a>
        <div class="mt-6 mx-5 mb-4 border-t border-gray-200 dark:border-gray-700"></div>
        <a href="profile.php" class="flex items-center py-3 px-5 text-gray-700 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all duration-200 rounded-lg <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-white shadow-sm text-blue-600 font-medium dark:bg-gray-700 dark:text-blue-400' : 'dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
            <i class="fas fa-cog mr-3 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400'; ?>"></i>
            <span>Settings</span>
        </a>
    </nav>
    <div class="p-6 mt-auto">
        <div class="bg-blue-50 rounded-lg p-4 dark:bg-gray-700">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-full dark:bg-blue-900">
                    <i class="fas fa-gem text-blue-600 text-sm dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200">Upgrade Plan</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Get access to all features</p>
                </div>
            </div>
        </div>
        <a href="logout.php" class="block mt-4 text-center py-2 px-4 rounded-lg bg-white text-red-600 hover:bg-red-50 hover:shadow-sm transition-all duration-200 border border-gray-200 dark:bg-gray-700 dark:text-red-400 dark:hover:bg-gray-600 dark:border-gray-600">
            <i class="fas fa-sign-out-alt mr-2"></i>Log Out
        </a>
    </div>
</div>