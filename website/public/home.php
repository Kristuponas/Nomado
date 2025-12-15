<?php

require_once __DIR__ . '/../src/database/database.php';
session_start();

function getSeasonId($seasonName) {
    $map = ['vasara'=>1,'ruduo'=>2,'ziema'=>3,'pavasaris'=>4];
    return $map[$seasonName] ?? 0;
}

function pushTagQueue(&$queue, $tagId, $maxSize = 10) {
    $queue[] = $tagId;
    if (count($queue) > $maxSize) {
        array_shift($queue);
    }
}

function renderHotelCard($hotel) {
    $imageName = str_replace(' ', '_', $hotel['pavadinimas']);
    $imagePath = "images/{$imageName}.jpg";
    if (!file_exists($imagePath)) $imagePath = "images/{$imageName}.jpeg";
    ?>
    <div class="room-card">
        <div class="room-image" style="background-image: url('<?php echo $imagePath; ?>');"></div>
        <div class="room-details">
            <h3><?php echo $hotel['pavadinimas']; ?></h3>
            <div class="room-features">
                <span><i data-feather="users"></i> <?php echo $hotel['sveciu_skaicius']; ?> Guests</span>
                <span><i data-feather="maximize-2"></i> <?php echo $hotel['kambariu_skaicius']*20; ?>m²</span>
                <span><i data-feather="wifi"></i> Free WiFi</span>
            </div>
            <div class="room-price">
                <span class="price">$<?php echo $hotel['kaina']; ?></span>
                <span class="per-night">/ night</span>
            </div>
            <form action="hotel_details.php" method="GET">
                <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                <button type="submit" class="btn btn-outline">View Details</button>
            </form>
        </div>
    </div>
    <?php
}

$db = Database::getInstance();
$currSeason = 'ziema';

// Featured Rooms: 3 random hotels
$featuredHotels = $db->select('viesbutis', []);
shuffle($featuredHotels);
$featuredHotels = array_slice($featuredHotels, 0, 3);

// Seasonal Deals: hotels in current season
$seasonalDeals = $db->select('viesbutis', ['sezonas' => getSeasonId($currSeason)]);

// ----- Recommended Hotels: based on previously viewed tags -----
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$viewedHotels = $_SESSION['viewed_hotels'] ?? []; // e.g., [1,3]
$recommendedHotels = [];

if (isset($_GET['hotel_id'])) {
    $hotelId = (int)$_GET['hotel_id'];
    $viewedHotels[] = $hotelId;
    $viewedHotels = array_unique($viewedHotels);
    $_SESSION['viewed_hotels'] = $viewedHotels;

    $hotelTags = $db->select('viesbutis_tag', ['fk_Viesbutis' => $hotelId]);
    foreach ($hotelTags as $tag) {
        pushTagQueue($viewedTagsQueue, $tag['fk_Tag'], 10);
    }
    $_SESSION['viewed_tags_queue'] = $viewedTagsQueue;
}

$recommendedHotels = [];
if (!empty($viewedTagsQueue)) {
    $placeholders = implode(',', array_fill(0, count($viewedTagsQueue), '?'));
    $notInHotels = !empty($viewedHotels) ? implode(',', $viewedHotels) : '0';

    $stmt = $db->getHandler()->prepare("
        SELECT DISTINCT v.*
        FROM viesbutis v
        JOIN viesbutis_tag vt ON v.id = vt.fk_Viesbutis
        WHERE vt.fk_Tag IN ($placeholders)
        AND v.id NOT IN ($notInHotels)
        LIMIT 6
    ");
    $stmt->execute($viewedTagsQueue);
    $recommendedHotels = $stmt->fetchAll();
}

$locations = $db->select('vietove', [], '*');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body>

<?php include __DIR__ . '/../templates/navbar.php'; ?>

<main>
    <section class="hero">
        <div class="hero-content">
            <h2>Find Your Perfect Stay</h2>
            <p>Discover luxury accommodations tailored to your needs</p>
        </div>
    </section>

    <!-- Search Form -->
    <section class="search-section">
        <div class="container">
            <?php include __DIR__ . '/../templates/search_form.php'; ?>
        </div>
    </section>

    <!-- Featured Rooms -->
    <section class="featured-rooms">
        <div class="container">
            <h2 class="section-title">Featured Rooms</h2>
            <div class="rooms-grid">
                <?php foreach ($featuredHotels as $hotel) renderHotelCard($hotel); ?>
            </div>
        </div>
    </section>

    <!-- Seasonal Deals -->
    <?php if (!empty($seasonalDeals)): ?>
    <section class="featured-rooms">
        <div class="container">
            <h2 class="section-title">Seasonal Deals</h2>
            <div class="slider-wrapper">
                <button class="slider-arrow prev">&#10094;</button>
                <div class="rooms-slider-container">
                    <div class="rooms-slider">
                        <?php foreach ($seasonalDeals as $hotel) renderHotelCard($hotel); ?>
                    </div>
                </div>
                <button class="slider-arrow next">&#10095;</button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Recommended Hotels -->
    <?php if (!empty($recommendedHotels)): ?>
    <section class="featured-rooms">
        <div class="container">
            <h2 class="section-title">Recommended for You</h2>
            <div class="slider-wrapper">
                <button class="slider-arrow prev">&#10094;</button>
                <div class="rooms-slider-container">
                    <div class="rooms-slider">
                        <?php foreach ($recommendedHotels as $hotel) renderHotelCard($hotel); ?>
                    </div>
                </div>
                <button class="slider-arrow next">&#10095;</button>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php include __DIR__ . '/../templates/footer.php'; ?>

<script>
    feather.replace();

    function clearSearchInput() {
        document.getElementById('searchQuery').value = '';
    }

    document.querySelectorAll('.slider-wrapper').forEach(wrapper => {
        const slider = wrapper.querySelector('.rooms-slider');
        const nextBtn = wrapper.querySelector('.slider-arrow.next');
        const prevBtn = wrapper.querySelector('.slider-arrow.prev');

        if (!slider || !nextBtn || !prevBtn) return;

        let position = 0;
        const cards = slider.querySelectorAll('.room-card');
        if (cards.length === 0) return;

        const cardWidth = cards[0].offsetWidth + 20;
        const visibleCards = 3;
        const maxPosition = -(cardWidth * (cards.length - visibleCards));

        nextBtn.addEventListener('click', () => {
            if (position > maxPosition) {
                position -= cardWidth;
                slider.style.transform = `translateX(${position}px)`;
            }
        });

        prevBtn.addEventListener('click', () => {
            if (position < 0) {
                position += cardWidth;
                slider.style.transform = `translateX(${position}px)`;
            }
        });
    });


    console.log('Viewed Tags Queue:', <?php echo json_encode($viewedTagsQueue); ?>); 
    console.log('Viewed Hotels:', <?php echo json_encode($viewedHotels); ?>); 
    console.log('Recommended Hotels:', <?php echo json_encode($recommendedHotels); ?>);

    
</script>
</body>
</html>
