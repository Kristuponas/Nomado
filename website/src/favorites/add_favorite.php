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
    header('Location: search_results.php?error=invalid_request');
    exit();
}

$db = Database::getInstance();
$userId = $_SESSION['user_id'];
$hotelId = intval($_POST['hotel_id']);

try {
    // Check if hotel exists
    $hotel = $db->select('viesbutis', ['id' => $hotelId]);
    if(empty($hotel)) {
        header('Location: search_results.php?error=hotel_not_found');
        exit();
    }

    // Check if already in favorites
    $sql = "SELECT mv.id 
            FROM megstamiausias_viesbutis mv
            JOIN megstamiausias_viesbutis_vartotojas mvv ON mv.id = mvv.fk_Megstamiausias_Viesbutis
            WHERE mv.fk_Viesbutis = :hotel_id AND mvv.fk_Vartotojas = :user_id";

    $stmt = $db->getHandler()->prepare($sql);
    $stmt->execute([':hotel_id' => $hotelId, ':user_id' => $userId]);
    $existing = $stmt->fetch();

    if($existing) {
        header('Location: search_results.php?error=already_exists');
        exit();
    }

    // Insert into megstamiausias_viesbutis table
    $sqlInsertFavorite = "INSERT INTO megstamiausias_viesbutis (pridejimo_data, aprasas, fk_Viesbutis) 
                          VALUES (CURDATE(), '', :hotel_id)";

    $stmt = $db->getHandler()->prepare($sqlInsertFavorite);
    $stmt->execute([':hotel_id' => $hotelId]);
    $favoriteId = $db->getHandler()->lastInsertId();

    // Insert into megstamiausias_viesbutis_vartotojas table
    $sqlLinkUser = "INSERT INTO megstamiausias_viesbutis_vartotojas (fk_Megstamiausias_Viesbutis, fk_Vartotojas) 
                    VALUES (:favorite_id, :user_id)";

    $stmt = $db->getHandler()->prepare($sqlLinkUser);
    $stmt->execute([':favorite_id' => $favoriteId, ':user_id' => $userId]);

    // Redirect back to the referring page or search results
    $referer = $_SERVER['HTTP_REFERER'] ?? '/search_results.php';

    // Add success parameter to URL
    $separator = (strpos($referer, '?') !== false) ? '&' : '?';
    header('Location: ' . $referer . $separator . 'success=added_favorite');
    exit();

} catch(Exception $e) {
    error_log("Add favorite error: " . $e->getMessage());
    header('Location: search_results.php?error=add_failed');
    exit();
}
?>