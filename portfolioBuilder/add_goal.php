<?php
require_once 'includes/config.php';
require_once 'classes/Goal.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$goal = new Goal();
$userId = getUserId();

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $due_date = sanitize($_POST['due_date']);
    $priority = sanitize($_POST['priority']);
    $progress = (int)$_POST['progress'];
    
    // Validate inputs
    $errors = [];
    
    if(empty($title)) {
        $errors[] = "Title is required";
    }
    
    if(empty($due_date)) {
        $errors[] = "Due date is required";
    } elseif(strtotime($due_date) < strtotime('today')) {
        $errors[] = "Due date cannot be in the past";
    }
    
    if($progress < 0 || $progress > 100) {
        $errors[] = "Progress must be between 0 and 100";
    }
    
    if(empty($errors)) {
        if($goalId = $goal->create($userId, $title, $description, $due_date, $priority, $progress)) {
            $_SESSION['success'] = "Goal created successfully!";
            redirect('goals.php');
        } else {
            $errors[] = "Failed to create goal";
        }
    }
}

$page_title = "Add Goal - PortfolioBuilder";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Add Goal Content -->
        <main class="px-6 py-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 dark:text-gray-200">Add New Project</h2>
                    
                    <?php if(isset($errors)): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <?php foreach($errors as $error): ?>
                                <span class="block sm:inline"><?php echo $error; ?></span><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="add_goal.php" method="POST">
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Project Title</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Description</label>
                            <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Due Date</label>
                                <input type="date" id="due_date" name="due_date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </div>
                            
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Priority</label>
                                <select id="priority" name="priority" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="progress" class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Initial Progress</label>
                            <input type="range" id="progress" name="progress" min="0" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                            <div class="flex justify-between text-xs text-gray-500 mt-1 dark:text-gray-400">
                                <span>0%</span>
                                <span>100%</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <a href="goals.php" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors duration-200 dark:bg-gray-700 dark:text-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                                Add Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Update progress value display
    const progressInput = document.getElementById('progress');
    const progressValue = document.createElement('div');
    progressValue.className = 'text-center text-sm text-gray-700 dark:text-gray-300';
    progressValue.textContent = `${progressInput.value}%`;
    progressInput.parentNode.insertBefore(progressValue, progressInput.nextSibling);
    
    progressInput.addEventListener('input', () => {
        progressValue.textContent = `${progressInput.value}%`;
    });
</script>

<?php include 'includes/footer.php'; ?>