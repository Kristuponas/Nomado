<?php
require_once __DIR__ . '/../src/database/database.php';
session_start();

$db = Database::getInstance();

// Get hotel IDs from URL
$hotelIds = isset($_GET['hotels']) ? $_GET['hotels'] : array();

if(empty($hotelIds) || !is_array($hotelIds)) {
    header('Location: search_results.php?error=no_hotels_selected');
    exit();
}

// Limit to maximum 3 hotels for comparison
$hotelIds = array_slice($hotelIds, 0, 3);

// Fetch hotel details
$hotels = array();
foreach($hotelIds as $hotelId) {
    $hotelId = intval($hotelId);
    if($hotelId > 0) {
        $hotelData = $db->select('viesbutis', array('id' => $hotelId));
        if(!empty($hotelData)) {
            $hotel = $hotelData[0];

            // Get location details
            $location = $db->select('vietove', array('id' => $hotel['fk_Vietove']));
            $hotel['location'] = !empty($location) ? $location[0] : null;

            // Get tags
            $hotelTags = $db->select('viesbutis_tag', array('fk_Viesbutis' => $hotelId));
            $tagDetails = array();
            foreach($hotelTags as $ht) {
                $tagInfo = $db->select('tag', array('id' => $ht['fk_Tag']));
                if(!empty($tagInfo)) {
                    $tagDetails[] = $tagInfo[0];
                }
            }
            $hotel['tags'] = $tagDetails;

            // Get season
            $season = $db->select('sezonas', array('id' => $hotel['sezonas']));
            $hotel['season_name'] = !empty($season) ? $season[0]['name'] : 'N/A';

            $hotels[] = $hotel;
        }
    }
}

if(empty($hotels)) {
    header('Location: search_results.php?error=hotels_not_found');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Hotels - Nomado</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/search.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<?php include __DIR__ . '/../templates/navbar.php' ?>

<main class="compare-page">
    <div class="container">
        <div class="page-header">
            <h1><i data-feather="columns"></i> Compare Hotels</h1>
            <a href="search_results.php" class="btn btn-outline">
                <i data-feather="arrow-left"></i> Back to Results
            </a>
        </div>

        <div class="comparison-table">
            <table>
                <thead>
                <tr>
                    <th class="feature-column">Feature</th>
                    <?php foreach($hotels as $hotel): ?>
                        <th class="hotel-column">
                            <?php
                            $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
                            $imagePath = "Images/{$imageName}.jpg";
                            if (!file_exists($imagePath)) {
                                $imagePath = "Images/{$imageName}.jpeg";
                            }
                            ?>
                            <div class="hotel-header">
                                <div class="hotel-image" style="background-image: url('<?php echo $imagePath; ?>');"></div>
                                <h3><?php echo $hotel['pavadinimas']; ?></h3>
                            </div>
                        </th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <!-- Location -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="map-pin"></i> Location
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td>
                            <?php
                            if($hotel['location']) {
                                echo $hotel['location']['miestas'] . ', ' . $hotel['location']['salis'];
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Price -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="dollar-sign"></i> Price per Night
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td class="price-cell">$<?php echo $hotel['kaina']; ?></td>
                    <?php endforeach; ?>
                </tr>

                <!-- Rating -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="star"></i> Rating
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td>
                            <div class="rating-badge">
                                <?php echo number_format($hotel['reitingas'], 1); ?>/5.0
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Number of Rooms -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="home"></i> Number of Rooms
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td><?php echo $hotel['kambariu_skaicius']; ?></td>
                    <?php endforeach; ?>
                </tr>

                <!-- Season -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="sun"></i> Best Season
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td><?php echo ucfirst($hotel['season_name']); ?></td>
                    <?php endforeach; ?>
                </tr>

                <!-- Description -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="file-text"></i> Description
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td class="description-cell">
                            <?php echo $hotel['trumpas_aprasymas']; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Full Description -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="align-left"></i> Full Description
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td class="description-cell">
                            <?php echo $hotel['aprasymas']; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Tags/Amenities -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="tag"></i> Amenities
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td>
                            <div class="tags-list">
                                <?php if(!empty($hotel['tags'])): ?>
                                    <?php foreach($hotel['tags'] as $tag): ?>
                                        <span class="tag-badge"><?php echo ucfirst($tag['pavadinimas']); ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">No amenities listed</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Discount -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="percent"></i> Discount
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td>
                            <?php if($hotel['nuolaida'] > 0): ?>
                                <span class="discount-badge"><?php echo $hotel['nuolaida']; ?>% OFF</span>
                            <?php else: ?>
                                <span class="text-muted">No discount</span>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Action Buttons -->
                <tr>
                    <td class="feature-name">
                        <i data-feather="zap"></i> Actions
                    </td>
                    <?php foreach($hotels as $hotel): ?>
                        <td>
                            <form action="Hotel_Details.php" method="GET" style="margin-bottom: 10px;">
                                <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="eye"></i>
                                    View Details
                                </button>
                            </form>

                            <?php
                            // Check if hotel is in favorites
                            $isFavorite = false;
                            if(isset($_SESSION['user_id'])) {
                                $favCheck = $db->getHandler()->prepare("
                                    SELECT mv.id 
                                    FROM megstamiausias_viesbutis mv
                                    JOIN megstamiausias_viesbutis_vartotojas mvv ON mv.id = mvv.fk_Megstamiausias_Viesbutis
                                    WHERE mv.fk_Viesbutis = :hotel_id AND mvv.fk_Vartotojas = :user_id
                                ");
                                $favCheck->execute([':hotel_id' => $hotel['id'], ':user_id' => $_SESSION['user_id']]);
                                $isFavorite = $favCheck->fetch() !== false;
                            }
                            ?>
                            <form action="<?php echo $isFavorite ? '/favorites/remove_favorite.php' : '/favorites/add_favorite.php'; ?>"  method="POST" class="favorite-form">
                                <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                                <button type="submit" class="btn <?php echo $isFavorite ? 'btn-outline-danger' : 'btn-outline'; ?>"
                                        <?php if(!isset($_SESSION['user_id'])): ?>
                                            onclick="event.preventDefault(); alert('Please log in to add favorites'); window.location.href='Login.html';"
                                        <?php endif; ?>>
                                    <i data-feather="heart"></i>
                                    <?php echo $isFavorite ? 'Remove from Favorites' : 'Add to Favorites'; ?>
                                </button>
                            </form>
                        </td>
                    <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../templates/footer.php' ?>

<script>
    feather.replace();
</script>

</body>
</html>