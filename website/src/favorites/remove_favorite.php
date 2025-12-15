<?php
require_once __DIR__ . '/../database/database.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: Login.html?error=not_logged_in');
    exit();
}

// Check if hotel_id is provided
if(!isset($_POST['hotel_id'])) {
    header('Location: favorites.php?error=invalid_request');
    exit();
}

$db = Database::getInstance();
$userId = $_SESSION['user_id'];
$hotelId = intval($_POST['hotel_id']);

try {
    // Find the favorite entry
    $sql = "SELECT mv.id 
            FROM megstamiausias_viesbutis mv
            JOIN megstamiausias_viesbutis_vartotojas mvv ON mv.id = mvv.fk_Megstamiausias_Viesbutis
            WHERE mv.fk_Viesbutis = :hotel_id AND mvv.fk_Vartotojas = :user_id";

    $stmt = $db->getHandler()->prepare($sql);
    $stmt->execute([':hotel_id' => $hotelId, ':user_id' => $userId]);
    $favorite = $stmt->fetch();

    if(!$favorite) {
        header('Location: favorites.php?error=not_found');
        exit();
    }

    $favoriteId = $favorite['id'];

    // Delete from megstamiausias_viesbutis_vartotojas first (foreign key constraint)
    $sqlDeleteLink = "DELETE FROM megstamiausias_viesbutis_vartotojas 
                      WHERE fk_Megstamiausias_Viesbutis = :favorite_id AND fk_Vartotojas = :user_id";

    $stmt = $db->getHandler()->prepare($sqlDeleteLink);
    $stmt->execute([':favorite_id' => $favoriteId, ':user_id' => $userId]);

    // Check if other users have this as favorite
    $sqlCheckOtherUsers = "SELECT COUNT(*) as count FROM megstamiausias_viesbutis_vartotojas 
                           WHERE fk_Megstamiausias_Viesbutis = :favorite_id";

    $stmt = $db->getHandler()->prepare($sqlCheckOtherUsers);
    $stmt->execute([':favorite_id' => $favoriteId]);
    $result = $stmt->fetch();

    // If no other users have this favorite, delete the favorite entry
    if($result['count'] == 0) {
        $sqlDeleteFavorite = "DELETE FROM megstamiausias_viesbutis WHERE id = :favorite_id";
        $stmt = $db->getHandler()->prepare($sqlDeleteFavorite);
        $stmt->execute([':favorite_id' => $favoriteId]);
    }

    // Redirect back to favorites page
    header('Location: /favorites.php?success=removed');
    exit();

} catch(Exception $e) {
    error_log("Remove favorite error: " . $e->getMessage());
    header('Location: /favorites.php?error=remove_failed');
    exit();
}
?>