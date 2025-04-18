<?php
require_once 'includes/config.php';
require_once 'classes/Goal.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$goal = new Goal();
$userId = getUserId();

// Get goal counts
$goalCounts = $goal->getGoalsCount($userId);
$activeGoals = $goalCounts['active'];
$completedGoals = $goalCounts['completed'];

// Get upcoming goals (due in next 7 days)
$upcomingGoals = $goal->getUpcomingGoals($userId, 7);
$upcomingDue = count($upcomingGoals);

// Get overdue goals
$overdueGoals = $goal->getOverdueGoals($userId);
$overdue = count($overdueGoals);

// Get recent activities
$recentActivities = $goal->getRecentActivities($userId, 5);

$page_title = "Dashboard - PortfolioBuilder";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Dashboard Content -->
        <main class="px-6 py-8 max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Overview</h1>
                    <p class="text-gray-500/90 dark:text-gray-400/80 mt-2">Welcome back! Here's what's happening today.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <?php if(basename($_SERVER['PHP_SELF']) != 'add_goal.php' && basename($_SERVER['PHP_SELF']) != 'edit_goal.php'): ?>
                    <a href="add_goal.php" class="flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add Project</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Active Projects Card -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-custom-light p-6 transition-all duration-300 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] hover:border-blue-200/50 dark:hover:border-blue-900/30">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-blue-100/80 to-blue-200/50 dark:from-blue-900/30 dark:to-blue-800/30 shadow-inner mr-4">
                            <i class="fas fa-bullseye text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80">Active Projects</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"><?php echo $activeGoals; ?></h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100/50 dark:border-gray-700/50 flex items-center justify-between">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50/70 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 shadow-inner">
                            <i class="fas fa-clock mr-1"></i> <?php echo $upcomingDue; ?> due soon
                        </span>
                        <!-- <a href="#" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                            View all <i class="fas fa-chevron-right ml-1"></i>
                        </a> -->
                    </div>
                </div>

                <!-- Completed Projects Card -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] p-6 transition-all duration-300 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] hover:border-green-200/50 dark:hover:border-green-900/30">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-green-100/80 to-green-200/50 dark:from-green-900/30 dark:to-green-800/30 shadow-inner mr-4">
                            <i class="fas fa-check text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80">Completed</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"><?php echo $completedGoals; ?></h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100/50 dark:border-gray-700/50 flex items-center justify-between">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-50/70 dark:bg-green-900/20 text-green-600 dark:text-green-400 shadow-inner">
                            <i class="fas fa-arrow-up mr-1"></i> +2 this week
                        </span>
                        <a href="#" class="text-xs text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors">
                            View all <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Overdue Projects Card -->
                <!-- <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] p-6 transition-all duration-300 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] hover:border-red-200/50 dark:hover:border-red-900/30">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-red-100/80 to-red-200/50 dark:from-red-900/30 dark:to-red-800/30 shadow-inner mr-4">
                            <i class="fas fa-exclamation text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80">Overdue</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"><?php echo $overdue; ?></h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100/50 dark:border-gray-700/50 flex items-center justify-between">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-red-50/70 dark:bg-red-900/20 text-red-600 dark:text-red-400 shadow-inner">
                            <i class="fas fa-warning mr-1"></i> Needs attention
                        </span>
                        <a href="#" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors">
                            View all <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div> -->

                <!-- Upcoming Projects Card -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] p-6 transition-all duration-300 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] hover:border-amber-200/50 dark:hover:border-amber-900/30">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-amber-100/80 to-amber-200/50 dark:from-amber-900/30 dark:to-amber-800/30 shadow-inner mr-4">
                            <i class="fas fa-clock text-amber-600 dark:text-amber-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80">Upcoming</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"><?php echo $upcomingDue; ?></h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100/50 dark:border-gray-700/50 flex items-center justify-between">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50/70 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 shadow-inner">
                            <i class="fas fa-calendar mr-1"></i> Next 7 days
                        </span>
                        <!-- <a href="#" class="text-xs text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 transition-colors">
                            View all <i class="fas fa-chevron-right ml-1"></i>
                        </a> -->
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Recent Projects</h2>
                    <!-- <a href="goals.php" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center transition-colors group">
                        View all <i class="fas fa-chevron-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a> -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    $recentGoals = $goal->getAllGoals($userId, 'active');
                    foreach(array_slice($recentGoals, 0, 6) as $goalItem): 
                    ?>
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] overflow-hidden transition-all duration-300 hover:shadow-[0_12px_28px_rgba(0,0,0,0.1)] hover:-translate-y-1">
                        <div class="h-1.5 <?php echo getPriorityColor($goalItem->priority); ?>"></div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1"><?php echo $goalItem->title; ?></h3>
                                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full <?php echo getPriorityBadge($goalItem->priority); ?> shadow-inner">
                                        <?php echo ucfirst($goalItem->priority); ?>
                                    </span>
                                </div>
                                <div class="relative">
                                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <p class="text-gray-600/90 dark:text-gray-400/80 mb-4 text-sm line-clamp-2"><?php echo $goalItem->description; ?></p>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-500/90 dark:text-gray-400/80">Progress</span>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium"><?php echo $goalItem->progress; ?>%</span>
                                </div>
                                <div class="w-full bg-gray-100/50 dark:bg-gray-700/50 rounded-full h-2 shadow-inner">
                                    <div class="h-2 rounded-full <?php echo getPriorityColor($goalItem->priority); ?>" style="width: <?php echo $goalItem->progress; ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500/90 dark:text-gray-400/80 flex items-center">
                                    <i class="far fa-calendar mr-1.5"></i> 
                                    <span class="<?php echo Goal::isDateApproaching($goalItem->due_date) ? 'text-amber-600 dark:text-amber-400' : ''; ?>">
                                        <?php echo formatDate($goalItem->due_date); ?>
                                    </span>
                                </span>
                                <div class="flex space-x-2">
                                    <a href="edit_goal.php?id=<?php echo $goalItem->id; ?>" class="w-8 h-8 rounded-full bg-gray-100/70 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 flex items-center justify-center hover:bg-gray-200/70 dark:hover:bg-gray-600/50 transition-colors shadow-sm">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>
                                    <a href="delete_goal.php?id=<?php echo $goalItem->id; ?>" class="w-8 h-8 rounded-full bg-red-50/70 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center hover:bg-red-100/70 dark:hover:bg-red-900/30 transition-colors shadow-sm" onclick="return confirm('Are you sure you want to delete this Project?');">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Recent Activity</h2>
                        <!-- <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center transition-colors group">
                            View all <i class="fas fa-chevron-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a> -->
                    </div>
                    
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] p-6">
                        <div class="space-y-6">
                            <?php foreach($recentActivities as $activity): ?>
                            <div class="flex items-start group">
                                <div class="relative flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-inner 
                                        <?php 
                                        switch($activity->activity_type) {
                                            case 'goal_created': echo 'bg-gradient-to-br from-green-100/80 to-green-200/50 dark:from-green-900/30 dark:to-green-800/30'; break;
                                            case 'goal_updated': echo 'bg-gradient-to-br from-amber-100/80 to-amber-200/50 dark:from-amber-900/30 dark:to-amber-800/30'; break;
                                            case 'goal_deleted': echo 'bg-gradient-to-br from-red-100/80 to-red-200/50 dark:from-red-900/30 dark:to-red-800/30'; break;
                                            case 'goal_completed': echo 'bg-gradient-to-br from-blue-100/80 to-blue-200/50 dark:from-blue-900/30 dark:to-blue-800/30'; break;
                                            default: echo 'bg-gray-100/70 dark:bg-gray-700/50';
                                        }
                                        ?>">
                                        <i class="
                                            <?php 
                                            switch($activity->activity_type) {
                                                case 'goal_created': echo 'fas fa-plus text-green-600 dark:text-green-400'; break;
                                                case 'goal_updated': echo 'fas fa-edit text-amber-600 dark:text-amber-400'; break;
                                                case 'goal_deleted': echo 'fas fa-trash text-red-600 dark:text-red-400'; break;
                                                case 'goal_completed': echo 'fas fa-check text-blue-600 dark:text-blue-400'; break;
                                                default: echo 'fas fa-info-circle text-gray-600 dark:text-gray-400';
                                            }
                                            ?>"></i>
                                    </div>
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700/90 dark:text-gray-300/90">
                                        <?php 
                                        $activityText = "";
                                        switch($activity->activity_type) {
                                            case 'goal_created':
                                                $activityText = "Created new project <span class='font-semibold text-green-600 dark:text-green-400'>\"{$activity->goal_title}\"</span>";
                                                break;
                                            case 'goal_updated':
                                                $activityText = "Updated project <span class='font-semibold text-amber-600 dark:text-amber-400'>\"{$activity->goal_title}\"</span>";
                                                break;
                                            case 'goal_deleted':
                                                $activityText = "Deleted project <span class='font-semibold text-red-600 dark:text-red-400'>\"{$activity->description}\"</span>";
                                                break;
                                            case 'goal_completed':
                                                $activityText = "Completed project <span class='font-semibold text-blue-600 dark:text-blue-400'>\"{$activity->goal_title}\"</span>";
                                                break;
                                            default:
                                                $activityText = $activity->description;
                                        }
                                        echo $activityText;
                                        ?>
                                    </p>
                                    <p class="text-xs text-gray-500/80 dark:text-gray-400/70 mt-1.5"><?php echo date('M j, Y \a\t g:i A', strtotime($activity->created_at)); ?></p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div>
                    <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mb-6">Quick Stats</h2>
                    
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 shadow-[0_8px_24px_rgba(0,0,0,0.05)] p-6">
                        <div class="space-y-5">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80 mb-2">Productivity Score</h3>
                                <div class="relative pt-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200/70 dark:text-blue-400 dark:bg-blue-900/20 shadow-inner">
                                                Weekly
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block text-blue-600 dark:text-blue-400">
                                                78%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-100/50 dark:bg-blue-900/30 shadow-inner">
                                        <div style="width:78%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-100/50 dark:border-gray-700/50 pt-5">
                                <h3 class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80 mb-3">Project Distribution</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-green-100/80 to-green-200/50 dark:from-green-900/30 dark:to-green-800/30 flex items-center justify-center mb-2 shadow-inner">
                                            <span class="text-green-600 dark:text-green-400 font-bold text-sm"><?php echo $completedGoals; ?></span>
                                        </div>
                                        <p class="text-xs text-gray-500/90 dark:text-gray-400/80">Done</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-blue-100/80 to-blue-200/50 dark:from-blue-900/30 dark:to-blue-800/30 flex items-center justify-center mb-2 shadow-inner">
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-sm"><?php echo $activeGoals; ?></span>
                                        </div>
                                        <p class="text-xs text-gray-500/90 dark:text-gray-400/80">Active</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="mx-auto w-12 h-12 rounded-full bg-gradient-to-br from-amber-100/80 to-amber-200/50 dark:from-amber-900/30 dark:to-amber-800/30 flex items-center justify-center mb-2 shadow-inner">
                                            <span class="text-amber-600 dark:text-amber-400 font-bold text-sm"><?php echo $upcomingDue; ?></span>
                                        </div>
                                        <p class="text-xs text-gray-500/90 dark:text-gray-400/80">Upcoming</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-100/50 dark:border-gray-700/50 pt-5">
                                <h3 class="text-sm font-medium text-gray-500/90 dark:text-gray-400/80 mb-3">Recent Achievements</h3>
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-100/80 to-purple-200/50 dark:from-purple-900/30 dark:to-purple-800/30 flex items-center justify-center mr-3 shadow-inner">
                                        <i class="fas fa-trophy text-purple-600 dark:text-purple-400 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700/90 dark:text-gray-300/90">Project Master</p>
                                        <p class="text-xs text-gray-500/80 dark:text-gray-400/70">Completed 10 projects</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-100/80 to-green-200/50 dark:from-green-900/30 dark:to-green-800/30 flex items-center justify-center mr-3 shadow-inner">
                                        <i class="fas fa-star text-green-600 dark:text-green-400 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700/90 dark:text-gray-300/90">Early Bird</p>
                                        <p class="text-xs text-gray-500/80 dark:text-gray-400/70">Completed project early</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Glass morphism effect */
    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    
    /* Smooth shadow transitions */
    .shadow-custom-light {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }
    
    .shadow-custom {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    }
    
    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
    
    /* Priority colors */
    .bg-priority-high {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }
    .dark .bg-priority-high {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.1) 100%);
    }
    .text-priority-high {
        color: #dc2626;
    }
    .dark .text-priority-high {
        color: #f87171;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    // Add subtle animation to cards when they come into view
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.transition-all');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => {
            card.classList.add('opacity-0', 'translate-y-4');
            observer.observe(card);
        });
    });
</script>