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

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Dashboard Content -->
        <main class="px-6 py-8">
            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center fade-in dark:bg-gray-800">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 dark:bg-blue-900">
                        <i class="fas fa-bullseye text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Projects</h3>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200"><?php echo $activeGoals; ?></p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center fade-in dark:bg-gray-800" style="animation-delay: 0.1s;">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 dark:bg-green-900">
                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed</h3>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200"><?php echo $completedGoals; ?></p>
                    </div>
                </div>
                <!-- <div class="bg-white rounded-lg shadow-md p-6 flex items-center fade-in dark:bg-gray-800" style="animation-delay: 0.2s;">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4 dark:bg-yellow-900">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Due</h3>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200"><?php echo $upcomingDue; ?></p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center fade-in dark:bg-gray-800" style="animation-delay: 0.3s;">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4 dark:bg-red-900">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue</h3>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200"><?php echo $overdue; ?></p>
                    </div>
                </div> -->
            </div>

            <!-- Recent Goals -->
            <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-gray-200">Recent Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php 
                $recentGoals = $goal->getAllGoals($userId, 'active');
                $animationDelay = 0;
                foreach(array_slice($recentGoals, 0, 6) as $goalItem): 
                    $animationDelay += 0.1;
                ?>
                <div class="goal-card bg-white rounded-lg shadow-md overflow-hidden fade-in dark:bg-gray-800" style="animation-delay: <?php echo $animationDelay; ?>s;">
                    <div class="p-1 <?php echo getPriorityColor($goalItem->priority); ?>"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo $goalItem->title; ?></h3>
                            <div class="flex">
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded <?php echo getPriorityBadge($goalItem->priority); ?>">
                                    <?php echo ucfirst($goalItem->priority); ?>
                                </span>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm dark:text-gray-400"><?php echo $goalItem->description; ?></p>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Progress</span>
                                <span class="text-gray-700 dark:text-gray-300"><?php echo $goalItem->progress; ?>%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar <?php echo getPriorityColor($goalItem->priority); ?>" style="width: <?php echo $goalItem->progress; ?>%"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400"><i class="far fa-calendar mr-1"></i> Due: <?php echo formatDate($goalItem->due_date); ?></span>
                            <div class="flex space-x-2">
                                <a href="edit_goal.php?id=<?php echo $goalItem->id; ?>" class="text-blue-600 hover:text-blue-800 transition-colors duration-200 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_goal.php?id=<?php echo $goalItem->id; ?>" class="text-red-600 hover:text-red-800 transition-colors duration-200 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this Project?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Recent Activity -->
            <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-gray-200">Recent Activity</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 dark:bg-gray-800">
                <div class="space-y-4">
                    <?php foreach($recentActivities as $activity): ?>
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 
                            <?php 
                            switch($activity->activity_type) {
                                case 'goal_created': echo 'bg-green-100 dark:bg-green-900'; break;
                                case 'goal_updated': echo 'bg-yellow-100 dark:bg-yellow-900'; break;
                                case 'goal_deleted': echo 'bg-red-100 dark:bg-red-900'; break;
                                case 'goal_completed': echo 'bg-blue-100 dark:bg-blue-900'; break;
                                default: echo 'bg-gray-100 dark:bg-gray-700';
                            }
                            ?>">
                            <i class="
                                <?php 
                                switch($activity->activity_type) {
                                    case 'goal_created': echo 'fas fa-plus text-green-600 dark:text-green-400'; break;
                                    case 'goal_updated': echo 'fas fa-edit text-yellow-600 dark:text-yellow-400'; break;
                                    case 'goal_deleted': echo 'fas fa-trash text-red-600 dark:text-red-400'; break;
                                    case 'goal_completed': echo 'fas fa-check text-blue-600 dark:text-blue-400'; break;
                                    default: echo 'fas fa-info-circle text-gray-600 dark:text-gray-400';
                                }
                                ?>"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <?php 
                                $activityText = "";
                                switch($activity->activity_type) {
                                    case 'goal_created':
                                        $activityText = "You created a new Project <span class='font-semibold text-green-600 dark:text-green-400'>\"{$activity->goal_title}\"</span>";
                                        break;
                                    case 'goal_updated':
                                        $activityText = "You updated goal <span class='font-semibold text-yellow-600 dark:text-yellow-400'>\"{$activity->goal_title}\"</span>";
                                        break;
                                    case 'goal_deleted':
                                        $activityText = "You deleted goal <span class='font-semibold text-red-600 dark:text-red-400'>\"{$activity->description}\"</span>";
                                        break;
                                    case 'goal_completed':
                                        $activityText = "You completed goal <span class='font-semibold text-blue-600 dark:text-blue-400'>\"{$activity->goal_title}\"</span>";
                                        break;
                                    default:
                                        $activityText = $activity->description;
                                }
                                echo $activityText;
                                ?>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo formatDate($activity->created_at); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>