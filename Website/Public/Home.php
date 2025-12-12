<?php
require_once __DIR__ . '/database.php';

// Database instance
$db = Database::getInstance();

$currSeason = 'ziema';

// ----- Featured Rooms: 3 random hotels -----
$featuredHotels = $db->select('viesbutis', [], '*');
shuffle($featuredHotels);
$featuredHotels = array_slice($featuredHotels, 0, 3);

// ----- Seasonal Deals: hotels in current season -----
$seasonalDeals = $db->select('viesbutis', ['sezonas' => array_search($currSeason, ['vasara'=>1,'ruduo'=>2,'ziema'=>3,'pavasaris'=>4])+1]);

// ----- Recommended Hotels: based on previously viewed tags -----
session_start();
$viewedHotels = $_SESSION['viewed_hotels'] ?? []; // e.g., [1,3]
$recommendedHotels = [];

if(!empty($viewedHotels)) {
    // get tags of viewed hotels
    $tags = [];
    foreach ($viewedHotels as $vh) {
        $hotelTags = $db->select('viesbutis_tag', ['fk_Viesbutis'=>$vh]);
        foreach($hotelTags as $t) $tags[] = $t['fk_Tag'];
    }
    $tags = array_unique($tags);

    if(!empty($tags)) {
        $placeholders = implode(',', array_fill(0, count($tags), '?'));
        $stmt = $db->dbHandler->prepare("SELECT DISTINCT v.* 
            FROM viesbutis v
            JOIN viesbutis_tag vt ON v.id = vt.fk_Viesbutis
            WHERE vt.fk_Tag IN ($placeholders) AND v.id NOT IN (" . implode(',', $viewedHotels ?: [0]) . ")
            LIMIT 3");
        $stmt->execute($tags);
        $recommendedHotels = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="CSSStyles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">
            <h1>Nomado</h1>
            <p>Where comfort meets luxury</p>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="Home.html">Home</a></li>
                <li><a href="deals.html">Deals</a></li>
                <li><a href="About_Us.html">About us</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="Login.html" class="btn btn-primary">Sign Up</a>
        </div>
    </div>
</header>

<main>
    <section class="hero">
        <div class="hero-content">
            <h2>Find Your Perfect Stay</h2>
            <p>Discover luxury accommodations tailored to your needs</p>
        </div>
    </section>

    <!-- Featured Rooms -->
    <section class="featured-rooms">
        <div class="container">
            <h2 class="section-title">Featured Rooms</h2>
            <div class="rooms-grid">
                <?php foreach($featuredHotels as $hotel): ?>
                    <?php
                        $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
                        $imagePath = "Images/{$imageName}.jpg";
                        if (!file_exists($imagePath)) {
                            $imagePath = "Images/{$imageName}.jpeg";
                        }
                    ?>
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('<?php echo $imagePath; ?>');"></div>
                        <div class="room-details">
                            <h3><?php echo $hotel['pavadinimas']; ?></h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 2 Guests</span>
                                <span><i data-feather="maximize-2"></i> <?php echo $hotel['kambariu_skaicius']*20; ?>m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$<?php echo $hotel['kaina']; ?></span>
                                <span class="per-night">/ night</span>
                            </div>
                            <form action="Hotel_Details.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                <button type="submit" class="btn btn-outline">View Details</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Seasonal Deals -->
    <section class="featured-rooms">
        <div class="container">
            <h2 class="section-title">Seasonal Deals</h2>
            <div class="rooms-grid">
                <?php foreach($seasonalDeals as $hotel): ?>
                    <?php
                        $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
                        $imagePath = "Images/{$imageName}.jpg";
                        if (!file_exists($imagePath)) {
                            $imagePath = "Images/{$imageName}.jpeg";
                        }
                    ?>
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('<?php echo $imagePath; ?>');"></div>
                        <div class="room-details">
                            <h3><?php echo $hotel['pavadinimas']; ?></h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 2 Guests</span>
                                <span><i data-feather="maximize-2"></i> <?php echo $hotel['kambariu_skaicius']*20; ?>m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$<?php echo $hotel['kaina']; ?></span>
                                <span class="per-night">/ night</span>
                            </div>
                            <form action="Hotel_Details.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                <button type="submit" class="btn btn-outline">View Details</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Recommended Hotels -->
    <?php if(!empty($recommendedHotels)): ?>
        <section class="featured-rooms">
            <div class="container">
                <h2 class="section-title">Recommended for You</h2>
                <div class="rooms-grid">
                    <?php foreach($recommendedHotels as $hotel): ?>
                        <?php
                            $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
                            $imagePath = "Images/{$imageName}.jpg";
                            if (!file_exists($imagePath)) {
                                $imagePath = "Images/{$imageName}.jpeg";
                            }
                        ?>
                        <div class="room-card">
                            <div class="room-image" style="background-image: url('<?php echo $imagePath; ?>');"></div>
                            <div class="room-details">
                                <h3><?php echo $hotel['pavadinimas']; ?></h3>
                                <div class="room-features">
                                    <span><i data-feather="users"></i> 2 Guests</span>
                                    <span><i data-feather="maximize-2"></i> <?php echo $hotel['kambariu_skaicius']*20; ?>m²</span>
                                    <span><i data-feather="wifi"></i> Free WiFi</span>
                                </div>
                                <div class="room-price">
                                    <span class="price">$<?php echo $hotel['kaina']; ?></span>
                                    <span class="per-night">/ night</span>
                                </div>
                                <form action="Hotel_Details.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                    <button type="submit" class="btn btn-outline">View Details</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<footer class="footer">
    <div class="container footer-grid">
        <div class="footer-about">
            <h3>Nomado</h3>
            <p>Your gateway to luxury, comfort, and unforgettable stays. Discover curated accommodations in the world’s most desirable destinations.</p>
        </div>
    </div>
</footer>

<script>
    feather.replace();
</script>
</body>
</html>
