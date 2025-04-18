<?php
require_once 'includes/config.php';

if(!isLoggedIn()) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $darkMode = isset($_POST['dark_mode']) ? (int)$_POST['dark_mode'] : 0;
    
    if(updateDarkModePreference(getUserId(), $darkMode)) {
        $_SESSION['dark_mode'] = $darkMode;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>