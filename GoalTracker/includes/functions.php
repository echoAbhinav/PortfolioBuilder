<?php
// Helper functions

// Redirect to a URL
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Get current user ID
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Format date
function formatDate($date) {
    return date('M j, Y', strtotime($date));
}

// Get priority badge class
function getPriorityBadge($priority) {
    switch($priority) {
        case 'high':
            return 'bg-red-100 text-red-600';
        case 'medium':
            return 'bg-yellow-100 text-yellow-600';
        case 'low':
            return 'bg-green-100 text-green-600';
        default:
            return 'bg-gray-100 text-gray-600';
    }
}

// Get priority color for progress bar
function getPriorityColor($priority) {
    switch($priority) {
        case 'high':
            return 'bg-red-600';
        case 'medium':
            return 'bg-yellow-500';
        case 'low':
            return 'bg-green-500';
        default:
            return 'bg-blue-600';
    }
}

// Log activity
function logActivity($userId, $activityType, $goalId = null, $description = null) {
    $db = new Database();
    $db->query("INSERT INTO activities (user_id, activity_type, goal_id, description) VALUES (:user_id, :activity_type, :goal_id, :description)");
    $db->bind(':user_id', $userId);
    $db->bind(':activity_type', $activityType);
    $db->bind(':goal_id', $goalId);
    $db->bind(':description', $description);
    return $db->execute();
}
?>