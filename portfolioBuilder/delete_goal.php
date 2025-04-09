<?php
require_once 'includes/config.php';
require_once 'classes/Goal.php';


if(!isLoggedIn()) {
    redirect('login.php');
}

$goal = new Goal();
$userId = getUserId();

// Get goal ID from URL
$goalId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Delete goal
if($goal->delete($goalId, $userId)) {
    $_SESSION['success'] = "Goal deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete goal or goal not found";
}

redirect('goals.php');
?>