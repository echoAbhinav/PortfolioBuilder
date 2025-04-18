<?php
require_once '../includes/config.php';
require_once '../classes/Skill.php';

header('Content-Type: application/json');

// Ensure the user is logged in
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'You must be logged in to access this resource']);
    exit;
}

// Check if ID is provided and valid
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Valid skill ID is required']);
    exit;
}

$skillId = (int)$_GET['id'];
$userId = getUserId();

try {
    $skill = new Skill();
    $skillData = $skill->getSkillById($skillId, $userId);

    // Check if skill exists and belongs to the user
    if (!$skillData) {
        http_response_code(404);
        echo json_encode(['error' => 'Skill not found or access denied']);
        exit;
    }

    // Return skill data as JSON
    echo json_encode([
        'id' => $skillData->id,
        'skill_name' => $skillData->skill_name,
        'proficiency' => $skillData->proficiency,
        'category' => $skillData->category,
        'description' => $skillData->description,
        'created_at' => $skillData->created_at,
        'updated_at' => $skillData->updated_at
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while processing your request']);
    error_log("Error in get_skill.php: " . $e->getMessage());
}