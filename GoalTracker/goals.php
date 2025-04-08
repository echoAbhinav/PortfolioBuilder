<?php
require_once 'includes/config.php';
require_once 'classes/Goal.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$goal = new Goal();
$userId = getUserId();

// Get filter parameters
$status = isset($_GET['status']) ? sanitize($_GET['status']) : 'active';
$priority = isset($_GET['priority']) ? sanitize($_GET['priority']) : null;
$search = isset($_GET['search']) ? sanitize($_GET['search']) : null;

// Get goals based on filters
$query = "SELECT * FROM goals WHERE user_id = :user_id";
$params = [':user_id' => $userId];

if($status) {
    $query .= " AND status = :status";
    $params[':status'] = $status;
}

if($priority) {
    $query .= " AND priority = :priority";
    $params[':priority'] = $priority;
}

if($search) {
    $query .= " AND (title LIKE :search OR description LIKE :search)";
    $params[':search'] = "%$search%";
}

$query .= " ORDER BY due_date ASC";

$db = new Database();
$db->query($query);
foreach($params as $key => $value) {
    $db->bind($key, $value);
}
$goals = $db->resultSet();

$page_title = "Projects";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Goals Content -->
        <main class="px-6 py-8">
            <!-- Filters and Search -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    <a href="?status=active" class="px-4 py-2 <?php echo $status == 'active' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'; ?> rounded hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 dark:hover:bg-gray-600">
                        Active Projects
                    </a>
                    <a href="?status=completed" class="px-4 py-2 <?php echo $status == 'completed' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'; ?> rounded hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 dark:hover:bg-gray-600">
                        Completed
                    </a>
                    <a href="?priority=high" class="px-4 py-2 <?php echo $priority == 'high' ? 'bg-red-100 text-red-600' : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'; ?> rounded hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 dark:hover:bg-gray-600">
                        High Priority
                    </a>
                    <a href="?priority=medium" class="px-4 py-2 <?php echo $priority == 'medium' ? 'bg-yellow-100 text-yellow-600' : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'; ?> rounded hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 dark:hover:bg-gray-600">
                        Medium Priority
                    </a>
                    <a href="?priority=low" class="px-4 py-2 <?php echo $priority == 'low' ? 'bg-green-100 text-green-600' : 'bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-300'; ?> rounded hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 dark:hover:bg-gray-600">
                        Low Priority
                    </a>
                </div>
                <form method="GET" class="relative w-full md:w-64">
                    <input type="text" name="search" placeholder="Search Projects..." value="<?php echo $search ? $search : ''; ?>" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <?php if($status): ?>
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                    <?php endif; ?>
                </form>
            </div>

            <!-- Goal Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php if(empty($goals)): ?>
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">No Projects found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Create your first Project by clicking the "Add Project" button</p>
                    </div>
                <?php else: ?>
                    <?php foreach($goals as $goalItem): ?>
                    <div class="goal-card bg-white rounded-lg shadow-md overflow-hidden fade-in dark:bg-gray-800">
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
                                    <a href="delete_goal.php?id=<?php echo $goalItem->id; ?>" class="text-red-600 hover:text-red-800 transition-colors duration-200 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this goal?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>