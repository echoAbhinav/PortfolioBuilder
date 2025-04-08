<?php
require_once 'includes/config.php';
require_once 'classes/Skill.php';
require_once 'classes/CSRF.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$skill = new Skill();
$csrf = new CSRF();
$userId = getUserId();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !$csrf->verifyToken($_POST['csrf_token'])) {
        setMessage('error', 'Invalid CSRF token. Please try again.');
        redirect('skills.php');
    }

    // Add new skill
    if (isset($_POST['add_skill'])) {
        $skillName = trim($_POST['skill_name']);
        $proficiency = (int)$_POST['proficiency'];
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);

        if (empty($skillName)) {
            setMessage('error', 'Skill name cannot be empty.');
        } elseif ($proficiency < 1 || $proficiency > 10) {
            setMessage('error', 'Proficiency level must be between 1 and 10.');
        } else {
            if ($skill->addSkill($userId, $skillName, $proficiency, $category, $description)) {
                setMessage('success', 'Skill added successfully!');
            } else {
                setMessage('error', 'Failed to add skill. Please try again.');
            }
        }
    }
    
    // Update existing skill
    if (isset($_POST['update_skill'])) {
        $skillId = (int)$_POST['skill_id'];
        $skillName = trim($_POST['skill_name']);
        $proficiency = (int)$_POST['proficiency'];
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);

        if (empty($skillName)) {
            setMessage('error', 'Skill name cannot be empty.');
        } elseif ($proficiency < 1 || $proficiency > 10) {
            setMessage('error', 'Proficiency level must be between 1 and 10.');
        } else {
            if ($skill->updateSkill($skillId, $userId, $skillName, $proficiency, $category, $description)) {
                setMessage('success', 'Skill updated successfully!');
            } else {
                setMessage('error', 'Failed to update skill. Please try again.');
            }
        }
    }
    
    // Delete skill
    if (isset($_POST['delete_skill'])) {
        $skillId = (int)$_POST['skill_id'];
        
        if ($skill->deleteSkill($skillId, $userId)) {
            setMessage('success', 'Skill deleted successfully!');
        } else {
            setMessage('error', 'Failed to delete skill. Please try again.');
        }
    }

    // Redirect to prevent form resubmission
    redirect('skills.php');
}

// Get skills for the current user, possibly filtered by category
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$userSkills = $skill->getUserSkills($userId, $category);

// Get all unique skill categories for filter dropdown
$categories = $skill->getSkillCategories($userId);

$page_title = "Skills Management - GoalTrack Pro";
include 'includes/header.php';
?>

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Top Navigation -->
        <?php include 'includes/topnav.php'; ?>

        <!-- Skills Content -->
        <main class="px-6 py-8">
            <!-- Messages -->
            <?php displayMessages(); ?>
            
            <!-- Add New Skill Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 dark:bg-gray-800">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Add New Skill</h3>
                <form action="skills.php" method="POST">
                    <?php echo $csrf->getTokenInput(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="skill_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Skill Name*</label>
                            <input type="text" id="skill_name" name="skill_name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required maxlength="100">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                            <input type="text" id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g., Programming, Language, Soft Skill" maxlength="50">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="proficiency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proficiency Level (1-10)*</label>
                        <input type="range" id="proficiency" name="proficiency" min="1" max="10" value="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" required>
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mt-1">
                            <span>Beginner</span>
                            <span>Intermediate</span>
                            <span>Expert</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Brief description of your experience with this skill" maxlength="500"></textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" name="add_skill" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                            Add Skill
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Skills List Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">My Skills</h3>
                    
                    <!-- Filter by category -->
                    <div class="flex items-center space-x-2">
                        <label for="filter_category" class="text-sm text-gray-600 dark:text-gray-400">Filter by:</label>
                        <select id="filter_category" onchange="window.location='skills.php?category='+encodeURIComponent(this.value)" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($category === $cat) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if(empty($userSkills)): ?>
                    <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                        <p>You haven't added any skills yet. Use the form above to add your first skill!</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach($userSkills as $userSkill): ?>
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-700 hover:shadow-lg transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($userSkill->skill_name); ?></h4>
                                    <div class="flex space-x-2">
                                        <button onclick="editSkill(<?php echo $userSkill->id; ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" aria-label="Edit skill">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="confirmDelete(<?php echo $userSkill->id; ?>, '<?php echo htmlspecialchars(addslashes($userSkill->skill_name)); ?>')" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" aria-label="Delete skill">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <?php if(!empty($userSkill->category)): ?>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full text-xs">
                                            <?php echo htmlspecialchars($userSkill->category); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-2 mb-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full dark:bg-blue-500" style="width: <?php echo ($userSkill->proficiency * 10); ?>%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>Level: <?php echo $userSkill->proficiency; ?>/10</span>
                                    </div>
                                </div>
                                
                                <?php if(!empty($userSkill->description)): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><?php echo htmlspecialchars($userSkill->description); ?></p>
                                <?php endif; ?>
                                
                                <div class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                    Last updated: <?php echo date('M j, Y', strtotime($userSkill->updated_at)); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Edit Skill Modal -->
<div id="editSkillModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Edit Skill</h3>
        <form id="updateSkillForm" action="skills.php" method="POST">
            <?php echo $csrf->getTokenInput(); ?>
            <input type="hidden" id="edit_skill_id" name="skill_id">
            
            <div class="mb-4">
                <label for="edit_skill_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Skill Name*</label>
                <input type="text" id="edit_skill_name" name="skill_name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required maxlength="100">
            </div>
            
            <div class="mb-4">
                <label for="edit_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <input type="text" id="edit_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="50">
            </div>
            
            <div class="mb-4">
                <label for="edit_proficiency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proficiency Level (1-10)*</label>
                <input type="range" id="edit_proficiency" name="proficiency" min="1" max="10" value="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" required>
                <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mt-1">
                    <span>Beginner</span>
                    <span>Intermediate</span>
                    <span>Expert</span>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="edit_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea id="edit_description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="500"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" name="update_skill" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                    Update Skill
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteSkillModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Confirm Deletion</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete the skill "<span id="deleteSkillName"></span>"? This action cannot be undone.</p>
        
        <form action="skills.php" method="POST">
            <?php echo $csrf->getTokenInput(); ?>
            <input type="hidden" id="delete_skill_id" name="skill_id">
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" name="delete_skill" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-700 dark:hover:bg-red-800">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Edit skill modal functions
function editSkill(skillId) {
    fetch('ajax/get_skill.php?id=' + skillId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(skill => {
            if (skill.error) {
                alert(skill.error);
                return;
            }
            
            document.getElementById('edit_skill_id').value = skill.id;
            document.getElementById('edit_skill_name').value = skill.skill_name;
            document.getElementById('edit_category').value = skill.category || '';
            document.getElementById('edit_proficiency').value = skill.proficiency;
            document.getElementById('edit_description').value = skill.description || '';
            document.getElementById('editSkillModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching skill:', error);
            alert('Error loading skill details. Please try again.');
        });
}

function closeEditModal() {
    document.getElementById('editSkillModal').classList.add('hidden');
}

// Delete confirmation modal functions
function confirmDelete(skillId, skillName) {
    document.getElementById('delete_skill_id').value = skillId;
    document.getElementById('deleteSkillName').textContent = skillName;
    document.getElementById('deleteSkillModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteSkillModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const editModal = document.getElementById('editSkillModal');
    const deleteModal = document.getElementById('deleteSkillModal');
    
    if (event.target === editModal) {
        closeEditModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}

// Update proficiency level display
document.addEventListener('DOMContentLoaded', function() {
    const proficiencyInputs = document.querySelectorAll('input[type="range"][name="proficiency"], input[type="range"][name="edit_proficiency"]');
    
    proficiencyInputs.forEach(input => {
        input.addEventListener('input', function() {
            // You can add visual feedback here if needed
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>