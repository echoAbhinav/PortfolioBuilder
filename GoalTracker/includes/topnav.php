<header class="bg-white shadow-sm dark:bg-gray-800">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <button id="mobile-menu" class="lg:hidden mr-4 focus:outline-none">
                <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
            </button>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                <?php 
                $page = basename($_SERVER['PHP_SELF']);
                switch($page) {
                    case 'dashboard.php': echo 'Dashboard'; break;
                    case 'goals.php': echo 'My Project'; break;
                    case 'skills.php': echo 'Calendar'; break;
                    case 'profile.php': echo 'Profile Settings'; break;
                    case 'add_goal.php': echo 'Add New Project'; break;
                    case 'edit_goal.php': echo 'Edit Project'; break;
                    default: echo 'GoalTrack Pro';
                }
                ?>
            </h1>
        </div>
        <div class="flex items-center">
            <?php if(basename($_SERVER['PHP_SELF']) != 'add_goal.php' && basename($_SERVER['PHP_SELF']) != 'edit_goal.php'): ?>
                <a href="add_goal.php" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Project</span>
                </a>
            <?php endif; ?>
            <div class="relative ml-4">
                <button class="relative focus:outline-none">
                    <i class="fas fa-bell text-gray-600 dark:text-gray-400"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                </button>
            </div>
        </div>
    </div>
</header>