<?php
require_once __DIR__ . '/../database/database.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: /login.php?error=not_logged_in');
    exit();
}

$db = Database::getInstance();
$profileId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userId = $_SESSION['user_id'];

if($profileId > 0) {
    // Verify that this profile belongs to the current user
    $profile = $db->select('filtravimo_konfiguracija',
        array('id' => $profileId, 'fk_Vartotojas' => $userId)
    );

    if(!empty($profile)) {
        // Delete the profile
        $db->delete('filtravimo_konfiguracija', array('id' => $profileId));
        header('Location: /search_results.php?success=profile_deleted');
    } else {
        header('Location: /search_results.php?error=unauthorized');
    }
} else {
    header('Location: /search_results.php?error=invalid_profile');
}
exit();
?>