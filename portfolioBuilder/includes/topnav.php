<header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700/30 shadow-sm">
    <div class="flex items-center justify-between px-6 py-3.5">
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button with modern design -->
            <button id="mobile-menu" class="lg:hidden p-2 rounded-lg bg-gray-100/50 dark:bg-gray-700/50 hover:bg-gray-200/60 dark:hover:bg-gray-600/50 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                <i class="fas fa-bars text-gray-700 dark:text-gray-300 text-lg"></i>
            </button>
            
            <!-- Page title with gradient text -->
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">
                <?php 
                $page = basename($_SERVER['PHP_SELF']);
                switch($page) {
                    case 'dashboard.php': echo 'Dashboard'; break;
                    case 'goals.php': echo 'My Projects'; break;
                    case 'skills.php': echo 'Skills'; break;
                    case 'achievements.php': echo 'Achievements'; break;
                    case 'profile.php': echo 'Profile Settings'; break;
                    case 'add_goal.php': echo 'Add New Project'; break;
                    case 'edit_goal.php': echo 'Edit Project'; break;
                    default: echo 'Portfolio Builder'; 
                }
                ?>
            </h1>
        </div>
        
        <!-- User controls with modern design -->
        <div class="flex items-center space-x-4">
            <!-- Dark mode toggle -->
            <!-- <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100/50 dark:bg-gray-700/50 hover:bg-gray-200/60 dark:hover:bg-gray-600/50 transition-colors">
                <i class="fas fa-moon text-gray-700 dark:text-yellow-400"></i>
                <i class="fas fa-sun text-yellow-400 dark:text-gray-700 hidden"></i>
            </button> -->
            
            <!-- Notification bell with indicator -->
            <!-- <div class="relative">
                <button class="p-2 rounded-lg bg-gray-100/50 dark:bg-gray-700/50 hover:bg-gray-200/60 dark:hover:bg-gray-600/50 transition-colors relative">
                    <i class="fas fa-bell text-gray-700 dark:text-gray-300"></i>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border border-white dark:border-gray-800"></span>
                </button>
            </div> -->
            
            <!-- User profile dropdown -->
            <div class="relative">
                <button id="user-menu" class="flex items-center space-x-2 focus:outline-none group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-medium">
                        <?php echo substr($_SESSION['username'], 0, 1); ?>
                    </div>
                    <span class="hidden md:inline-block font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <i class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors hidden md:inline-block"></i>
                </button>
                
                <!-- Dropdown menu -->
                <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-300 dark:border-gray-700 py-1 z-50 hidden transition-all duration-200 origin-top-right transform opacity-0 scale-95">
                    <a href="profile.php" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-user-circle mr-2"></i> Profile
                    </a>
                    <a href="settings.php" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <div class="border-t border-gray-300 dark:border-gray-700 my-1"></div>
                    <a href="logout.php" class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all rounded-lg flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt text-red-500"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    /* Smooth transitions for dropdown */
    #user-dropdown.show {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Glass morphism effect */
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    /* Gradient text animation */
    .bg-gradient-to-r {
        background-size: 200% auto;
        animation: gradientText 3s ease infinite;
    }
    
    @keyframes gradientText {
        0% { background-position: 0% center; }
        50% { background-position: 100% center; }
        100% { background-position: 0% center; }
    }
</style>

<script>
    // Toggle user dropdown
    document.getElementById('user-menu').addEventListener('click', function() {
        const dropdown = document.getElementById('user-dropdown');
        dropdown.classList.toggle('hidden');
        dropdown.classList.toggle('show');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const userMenu = document.getElementById('user-menu');
        
        if (!userMenu.contains(event.target)) {
            dropdown.classList.add('hidden');
            dropdown.classList.remove('show');
        }
    });
    
    // Theme toggle functionality
    document.getElementById('theme-toggle').addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
    });
</script>