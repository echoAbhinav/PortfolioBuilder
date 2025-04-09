<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../classes/Achievement.php';

// Set headers for JSON response
header('Content-Type: application/json');

try {
    // Check if user is logged in
    if (!isLoggedIn()) {
        echo json_encode(['error' => 'Not authorized']);
        exit;
    }

    // Check if ID parameter exists
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(['error' => 'Invalid achievement ID']);
        exit;
    }

    $achievementId = (int)$_GET['id'];
    $userId = getUserId();

    // Fetch achievement details
    $achievement = new Achievement();
    $achievementData = $achievement->getAchievement($achievementId, $userId);

    if (!$achievementData) {
        echo json_encode(['error' => 'Achievement not found']);
        exit;
    }

    // Format date for HTML date input
    if (!empty($achievementData->date_achieved)) {
        $achievementData->date_achieved = date('Y-m-d', strtotime($achievementData->date_achieved));
    }

    // Return achievement data as JSON
    echo json_encode([
        'success' => true,
        'data' => $achievementData
    ]);
} catch (Exception $e) {
    // Log the error and return a generic error message
    error_log("Error fetching achievement: " . $e->getMessage());
    echo json_encode(['error' => 'Server error occurred']);
}
exit;