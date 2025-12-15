<?php
require_once __DIR__ . '/../src/database/database.php';
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=not_logged_in');
    exit();
}

$db = Database::getInstance();
$userId = $_SESSION['user_id'];

// Get user's favorite hotels
$sql = "SELECT DISTINCT v.*, vt.salis, vt.miestas, vt.adresas, mv.pridejimo_data, mv.aprasas
        FROM megstamiausias_viesbutis mv
        JOIN megstamiausias_viesbutis_vartotojas mvv ON mv.id = mvv.fk_Megstamiausias_Viesbutis
        JOIN viesbutis v ON mv.fk_Viesbutis = v.id
        LEFT JOIN vietove vt ON v.fk_Vietove = vt.id
        WHERE mvv.fk_Vartotojas = :user_id
        ORDER BY mv.pridejimo_data DESC";

$stmt = $db->getHandler()->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$favoriteHotels = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorite Hotels - Nomado</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/favorites.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<?php include __DIR__ . '/../templates/navbar.php' ?>

<main class="favorites-page">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1><i data-feather="heart"></i> My Favorite Hotels</h1>
                <p class="page-subtitle">Your saved collection of amazing places to stay</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                switch($_GET['success']) {
                    case 'added':
                        echo 'Hotel added to favorites!';
                        break;
                    case 'removed':
                        echo 'Hotel removed from favorites.';
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php
                switch($_GET['error']) {
                    case 'not_logged_in':
                        echo 'Please log in to manage your favorites.';
                        break;
                    case 'already_exists':
                        echo 'This hotel is already in your favorites.';
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Favorites Grid -->
        <?php if(empty($favoriteHotels)): ?>
            <div class="empty-state">
                <i data-feather="heart"></i>
                <h2>No Favorite Hotels Yet</h2>
                <p>Start exploring and save your favorite hotels for easy access later!</p>
                <a href="search_results.php" class="btn btn-primary">
                    <i data-feather="search"></i>
                    Discover Hotels
                </a>
            </div>
        <?php else: ?>

            <div class="favorites-grid">
                <?php foreach($favoriteHotels as $hotel): ?>
                    <?php
                    $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
                    $imagePath = "Images/{$imageName}.jpg";
                    if (!file_exists($imagePath)) {
                        $imagePath = "Images/{$imageName}.jpeg";
                    }

                    // Get hotel tags
                    $hotelTags = $db->select('viesbutis_tag', array('fk_Viesbutis' => $hotel['id']));
                    $tagDetails = array();
                    foreach($hotelTags as $ht) {
                        $tagInfo = $db->select('tag', array('id' => $ht['fk_Tag']));
                        if(!empty($tagInfo)) {
                            $tagDetails[] = $tagInfo[0];
                        }
                    }
                    ?>
                    <div class="favorite-card">
                        <div class="favorite-image" style="background-image: url('<?php echo $imagePath; ?>');">
                            <form action="/favorites/remove_favorite.php" method="POST" class="remove-favorite-form">
                                <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                                <button type="submit" class="remove-favorite-btn" onclick="return confirm('Remove from favorites?')">
                                    <i data-feather="heart"></i>
                                </button>
                            </form>
                        </div>

                        <div class="favorite-content">
                            <div class="favorite-header">
                                <div>
                                    <h3><?php echo $hotel['pavadinimas']; ?></h3>
                                    <p class="favorite-location">
                                        <i data-feather="map-pin"></i>
                                        <?php echo $hotel['miestas'] . ', ' . $hotel['salis']; ?>
                                    </p>
                                </div>
                                <div class="favorite-rating">
                                    <i data-feather="star"></i>
                                    <span><?php echo number_format($hotel['reitingas'], 1); ?></span>
                                </div>
                            </div>

                            <p class="favorite-description"><?php echo $hotel['trumpas_aprasymas']; ?></p>

                            <?php if(!empty($hotel['aprasas'])): ?>
                                <div class="favorite-note">
                                    <i data-feather="message-circle"></i>
                                    <p><?php echo $hotel['aprasas']; ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="favorite-tags">
                                <?php foreach(array_slice($tagDetails, 0, 3) as $tag): ?>
                                    <span class="tag-badge"><?php echo $tag['pavadinimas']; ?></span>
                                <?php endforeach; ?>
                            </div>

                            <div class="favorite-footer">
                                <div class="favorite-price">
                                    <span class="price-amount">$<?php echo $hotel['kaina']; ?></span>
                                    <span class="price-period">/ night</span>
                                </div>
                                <div class="favorite-actions">
                                    <form action="Hotel_Details.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="eye"></i>
                                            View Details
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="favorite-date">
                                <i data-feather="calendar"></i>
                                Added on <?php echo date('M d, Y', strtotime($hotel['pridejimo_data'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../templates/footer.php' ?>

<script>
    feather.replace();

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 300);
        });
    }, 5000);
</script>

</body>
</html>
