<?php
require_once __DIR__ . '/../database/database.php';
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: /login.php?error=not_logged_in');
    exit();
}

$db = Database::getInstance();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profileName = isset($_POST['profile_name']) ? trim($_POST['profile_name']) : '';
    $userId = $_SESSION['user_id'];

    // Get current filter parameters
    $location = isset($_POST['location']) && $_POST['location'] !== '' ? $_POST['location'] : null;
    $minPrice = isset($_POST['min_price']) && $_POST['min_price'] !== '' ? floatval($_POST['min_price']) : 0;
    $maxPrice = isset($_POST['max_price']) && $_POST['max_price'] !== '' ? floatval($_POST['max_price']) : 0;
    $minRooms = isset($_POST['min_rooms']) && $_POST['min_rooms'] !== '' ? intval($_POST['min_rooms']) : 0;
    $season = isset($_POST['season']) && $_POST['season'] !== '' ? $_POST['season'] : null;
    $tags = isset($_POST['tags']) && !empty($_POST['tags']) ? $_POST['tags'] : array();

    // Validate profile name
    if(empty($profileName)) {
        header('Location: /search_results.php?error=empty_name');
        exit();
    }

    try {
        // Check if profile with this name already exists for this user
        $existingProfile = $db->select('filtravimo_konfiguracija',
            array('fk_Vartotojas' => $userId, 'pavadinimas' => $profileName)
        );

        if(!empty($existingProfile)) {
            $profileId = $existingProfile[0]['id'];

            // Update existing profile
            $updateData = array(
                'pavadinimas' => $profileName
            );

            // Add only if value is not 0 (meaning user actually set a value)
            if($minPrice > 0) {
                $updateData['kaina_nuo'] = $minPrice;
            } else {
                $updateData['kaina_nuo'] = 0; // Set to 0 for "no filter"
            }

            if($maxPrice > 0) {
                $updateData['kaina_iki'] = $maxPrice;
            } else {
                $updateData['kaina_iki'] = 0; // Set to 0 for "no filter"
            }

            if($minRooms > 0) {
                $updateData['kambariu_skaicius'] = $minRooms;
            } else {
                $updateData['kambariu_skaicius'] = 0; // Set to 0 for "no filter"
            }

            $db->update('filtravimo_konfiguracija',
                $updateData,
                array('id' => $profileId)
            );

            // Delete old tags for this profile
            $db->delete('filtravimo_konfiguracijos_tag',
                array('fk_Filtravimo_Konfiguracija' => $profileId)
            );
        } else {
            // Insert new profile
            $insertData = array(
                'pavadinimas' => $profileName,
                'fk_Vartotojas' => $userId,
                'kaina_nuo' => $minPrice > 0 ? $minPrice : 0,
                'kaina_iki' => $maxPrice > 0 ? $maxPrice : 0,
                'kambariu_skaicius' => $minRooms > 0 ? $minRooms : 0
            );

            $db->insert('filtravimo_konfiguracija', $insertData);

            // Get the newly inserted profile ID
            $stmt = $db->getHandler()->query("SELECT LAST_INSERT_ID() as id");
            $result = $stmt->fetch();
            $profileId = $result['id'];
        }

        // Insert tags
        if(!empty($tags)) {
            foreach($tags as $tagId) {
                // Get tag name
                $tagInfo = $db->select('tag', array('id' => $tagId));
                if(!empty($tagInfo)) {
                    $tagName = $tagInfo[0]['pavadinimas'];

                    $tagData = array(
                        'reiksme' => $tagName,
                        'parametro_tipas' => 'tag',
                        'fk_Tag' => $tagId,
                        'fk_Filtravimo_Konfiguracija' => $profileId
                    );

                    $db->insert('filtravimo_konfiguracijos_tag', $tagData);
                }
            }
        }

        // Insert season if selected
        if(!empty($season)) {
            $seasonInfo = $db->select('sezonas', array('id' => $season));
            if(!empty($seasonInfo)) {
                $seasonData = array(
                    'reiksme' => $seasonInfo[0]['name'],
                    'parametro_tipas' => 'sezonas',
                    'fk_Tag' => 0, // No tag for season
                    'fk_Filtravimo_Konfiguracija' => $profileId
                );

                $db->insert('filtravimo_konfiguracijos_tag', $seasonData);
            }
        }

        // Insert location if selected
        if(!empty($location)) {
            $locationInfo = $db->select('vietove', array('id' => $location));
            if(!empty($locationInfo)) {
                $locationData = array(
                    'reiksme' => $locationInfo[0]['miestas'],
                    'parametro_tipas' => 'tag',
                    'fk_Tag' => 0,
                    'fk_Filtravimo_Konfiguracija' => $profileId
                );

                $db->insert('filtravimo_konfiguracijos_tag', $locationData);
            }
        }

        header('Location: /search_results.php?success=profile_saved');
        exit();

    } catch(Exception $e) {
        // For debugging - show the error
        echo "Database Error: " . $e->getMessage() . "<br>";
        echo "Error occurred at line: " . $e->getLine() . "<br>";
        echo "Stack trace: " . $e->getTraceAsString() . "<br>";
        exit();

        // Or redirect with error
        // header('Location: /search_results.php?error=save_failed');
        // exit();
    }
} else {
    header('Location: /search_results.php');
    exit();
}
?>