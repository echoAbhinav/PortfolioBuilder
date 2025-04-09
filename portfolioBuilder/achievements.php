<?php
require_once 'includes/config.php';
require_once 'classes/Achievement.php';
require_once 'classes/CSRF.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$achievement = new Achievement();
$csrf = new CSRF();
$userId = getUserId();

// Add new achievement
if (isset($_POST['add_achievement'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $dateAchieved = trim($_POST['date_achieved']);
    $category = trim($_POST['category']);
    $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle image upload
    $imageUrl = '';
    if (isset($_FILES['achievement_image']) && $_FILES['achievement_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/achievements/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = pathinfo($_FILES['achievement_image']['name'], PATHINFO_EXTENSION);
        $fileName = 'ach_' . $userId . '_' . time() . '.' . strtolower($fileExt);
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['achievement_image']['tmp_name'], $uploadPath)) {
            $imageUrl = $uploadPath;
        }
    }
    
    if (empty($title)) {
        setMessage('error', 'Title cannot be empty.');
    } elseif (empty($dateAchieved)) {
        setMessage('error', 'Date achieved cannot be empty.');
    } else {
        if ($achievement->addAchievement($userId, $title, $description, $dateAchieved, $category, $imageUrl, $isFeatured)) {
            setMessage('success', 'Achievement added successfully!');
        } else {
            setMessage('error', 'Failed to add achievement. Please try again.');
        }
    }
    redirect('achievements.php');
}

// Update achievement
if (isset($_POST['update_achievement'])) {
    $achievementId = (int)$_POST['achievement_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $dateAchieved = trim($_POST['date_achieved']);
    $category = trim($_POST['category']);
    $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle image upload
    $imageUrl = $_POST['existing_image'];
    if (isset($_FILES['achievement_image']) && $_FILES['achievement_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/achievements/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = pathinfo($_FILES['achievement_image']['name'], PATHINFO_EXTENSION);
        $fileName = 'ach_' . $userId . '_' . time() . '.' . strtolower($fileExt);
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['achievement_image']['tmp_name'], $uploadPath)) {
            // Delete old image if it exists
            if (!empty($_POST['existing_image']) && file_exists($_POST['existing_image'])) {
                unlink($_POST['existing_image']);
            }
            $imageUrl = $uploadPath;
        }
    }
    
    if (empty($title)) {
        setMessage('error', 'Title cannot be empty.');
    } elseif (empty($dateAchieved)) {
        setMessage('error', 'Date achieved cannot be empty.');
    } else {
        if ($achievement->updateAchievement($achievementId, $userId, $title, $description, $dateAchieved, $category, $imageUrl, $isFeatured)) {
            setMessage('success', 'Achievement updated successfully!');
        } else {
            setMessage('error', 'Failed to update achievement. Please try again.');
        }
    }
    redirect('achievements.php');
}

// Delete achievement
if (isset($_POST['delete_achievement'])) {
    $achievementId = (int)$_POST['achievement_id'];
    
    // Get achievement to delete image if exists
    $ach = $achievement->getAchievement($achievementId, $userId);
    if ($ach && !empty($ach->image_url) && file_exists($ach->image_url)) {
        unlink($ach->image_url);
    }
    
    if ($achievement->deleteAchievement($achievementId, $userId)) {
        setMessage('success', 'Achievement deleted successfully!');
    } else {
        setMessage('error', 'Failed to delete achievement. Please try again.');
    }
    redirect('achievements.php');
}

// Get achievements for the current user, possibly filtered by category
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$userAchievements = $achievement->getUserAchievements($userId, $category);

// Get featured achievements
$featuredAchievements = $achievement->getFeaturedAchievements($userId);

// Get all unique achievement categories for filter dropdown
$categories = $achievement->getAchievementCategories($userId);

$page_title = "My Achievements - PortfolioBuilder";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Achievements Content -->
        <main class="px-6 py-8">
            <!-- Messages -->
            <?php displayMessages(); ?>
            
            <!-- Featured Achievements Carousel -->
            <?php if(!empty($featuredAchievements)): ?>
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8 text-white">
                <h3 class="text-xl font-bold mb-4">Featured Achievements</h3>
                <div class="splide" id="featuredAchievements">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php foreach($featuredAchievements as $ach): ?>
                            <li class="splide__slide">
                                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 h-full">
                                    <?php if(!empty($ach->image_url)): ?>
                                    <div class="h-40 overflow-hidden rounded-lg mb-3">
                                        <img src="<?php echo htmlspecialchars($ach->image_url); ?>" alt="<?php echo htmlspecialchars($ach->title); ?>" class="w-full h-full object-cover">
                                    </div>
                                    <?php endif; ?>
                                    <h4 class="font-bold text-lg"><?php echo htmlspecialchars($ach->title); ?></h4>
                                    <p class="text-sm text-white/80 mb-2"><?php echo date('F j, Y', strtotime($ach->date_achieved)); ?></p>
                                    <p class="text-sm line-clamp-2"><?php echo htmlspecialchars($ach->description); ?></p>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Add New Achievement Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 dark:bg-gray-800">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Add New Achievement</h3>
                <form action="achievements.php" method="POST" enctype="multipart/form-data">
                    <?php echo $csrf->getTokenInput(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title*</label>
                            <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required maxlength="100">
                        </div>
                        <div>
                            <label for="date_achieved" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Achieved*</label>
                            <input type="date" id="date_achieved" name="date_achieved" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                            <input type="text" id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g., Academic, Professional, Personal" maxlength="50">
                        </div>
                        <div>
                            <label for="achievement_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image (Optional)</label>
                            <input type="file" id="achievement_image" name="achievement_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Describe your achievement and what it means to you" maxlength="500"></textarea>
                    </div>
                    
                    <!-- <div class="flex items-center mb-4">
                        <input type="checkbox" id="is_featured" name="is_featured" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_featured" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Feature this achievement</label>
                    </div> -->
                    
                    <div class="flex justify-end">
                        <button type="submit" name="add_achievement" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-trophy mr-2"></i> Add Achievement
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Achievements List Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">My Achievements</h3>
                    
                    <!-- Filter by category -->
                    <div class="flex items-center space-x-2">
                        <label for="filter_category" class="text-sm text-gray-600 dark:text-gray-400">Filter by:</label>
                        <select id="filter_category" onchange="window.location='achievements.php?category='+encodeURIComponent(this.value)" class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($category === $cat) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if(empty($userAchievements)): ?>
                    <div class="text-center py-10">
                        <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">No achievements yet</h4>
                        <p class="text-gray-500 dark:text-gray-500">Start by adding your first achievement using the form above!</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($userAchievements as $ach): ?>
                            <div class="border border-gray-200 rounded-xl p-4 dark:border-gray-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col h-full">
                                <?php if(!empty($ach->image_url)): ?>
                                    <div class="h-40 overflow-hidden rounded-lg mb-3">
                                        <img src="<?php echo htmlspecialchars($ach->image_url); ?>" alt="<?php echo htmlspecialchars($ach->title); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($ach->title); ?></h4>
                                        <?php if($ach->is_featured): ?>
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Featured</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <?php echo date('M j, Y', strtotime($ach->date_achieved)); ?>
                                    </div>
                                    
                                    <?php if(!empty($ach->category)): ?>
                                        <div class="mb-3">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                <?php echo htmlspecialchars($ach->category); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($ach->description)): ?>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-3"><?php echo htmlspecialchars($ach->description); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex justify-between items-center mt-auto pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <div class="text-xs text-gray-500 dark:text-gray-500">
                                        Added: <?php echo date('M j, Y', strtotime($ach->created_at)); ?>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- <button onclick="editAchievement(<?php echo $ach->id; ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" aria-label="Edit achievement">
                                            <i class="fas fa-edit"></i>
                                        </button> -->
                                        <button onclick="confirmDelete(<?php echo $ach->id; ?>, '<?php echo htmlspecialchars(addslashes($ach->title)); ?>')" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" aria-label="Delete achievement">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteAchievementModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Confirm Deletion</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete the achievement "<span id="deleteAchievementName"></span>"? This action cannot be undone.</p>
        
        <form action="achievements.php" method="POST">
            <?php echo $csrf->getTokenInput(); ?>
            <input type="hidden" id="delete_achievement_id" name="achievement_id">
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" name="delete_achievement" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-700 dark:hover:bg-red-800">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Splide JS for featured achievements carousel -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

<script>
// Initialize featured achievements carousel
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('featuredAchievements')) {
        new Splide('#featuredAchievements', {
            type: 'loop',
            perPage: 3,
            perMove: 1,
            gap: '1rem',
            pagination: false,
            breakpoints: {
                1024: {
                    perPage: 2
                },
                640: {
                    perPage: 1
                }
            }
        }).mount();
    }
});

// Delete confirmation modal functions
function confirmDelete(achievementId, achievementName) {
    document.getElementById('delete_achievement_id').value = achievementId;
    document.getElementById('deleteAchievementName').textContent = achievementName;
    document.getElementById('deleteAchievementModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteAchievementModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    // const editModal = document.getElementById('editAchievementModal');
    const deleteModal = document.getElementById('deleteAchievementModal');
    
    if (event.target === editModal) {
        closeEditModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>

<?php include 'includes/footer.php'; ?>