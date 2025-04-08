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

// Set flash message
function setMessage($type, $message) {
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    $_SESSION['messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

// Display flash messages
function displayMessages() {
    if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
        echo '<div class="messages mb-6">';
        foreach ($_SESSION['messages'] as $message) {
            $alertClass = 'bg-gray-100 border-gray-500 text-gray-700';
            
            if ($message['type'] === 'success') {
                $alertClass = 'bg-green-100 border-green-500 text-green-700';
            } elseif ($message['type'] === 'error') {
                $alertClass = 'bg-red-100 border-red-500 text-red-700';
            } elseif ($message['type'] === 'warning') {
                $alertClass = 'bg-yellow-100 border-yellow-500 text-yellow-700';
            } elseif ($message['type'] === 'info') {
                $alertClass = 'bg-blue-100 border-blue-500 text-blue-700';
            }
            
            echo '<div class="rounded-md p-4 border-l-4 ' . $alertClass . ' mb-3">';
            echo '<div class="flex">';
            echo '<div class="flex-shrink-0">';
            
            // Icon based on message type
            if ($message['type'] === 'success') {
                echo '<svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
            } elseif ($message['type'] === 'error') {
                echo '<svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
            } elseif ($message['type'] === 'warning') {
                echo '<svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
            } elseif ($message['type'] === 'info') {
                echo '<svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>';
            } else {
                echo '<svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>';
            }
            
            echo '</div>';
            echo '<div class="ml-3">';
            echo '<p class="text-sm">' . htmlspecialchars($message['message']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        
        // Clear messages after displaying them
        unset($_SESSION['messages']);
    }
}
?>