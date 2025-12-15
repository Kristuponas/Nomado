<?php
if (!isset($_GET['hotel_id'])) {
    header("Location: /");
}
session_start();

require_once __DIR__ . '/../src/database/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/hotel_details/geocode.php';

use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter(['html_input' => 'strip', 'max_nesting_level' => 5]);

$db = Database::getInstance();

$viewedTagsQueue = $_SESSION['viewed_tags_queue'] ?? [];
$viewedHotels = $_SESSION['viewed_hotels'] ?? [];

function pushTagQueue(&$queue, $tagId, $maxSize = 10) {
    $queue[] = $tagId;
    if (count($queue) > $maxSize) {
        array_shift($queue);
    }
}

if (!isset($_GET['hotel_id'])) {
    header("Location: /");
} else {
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

try {
    $hotel = $db->select('viesbutis', ['id' => $_GET['hotel_id']])[0];
    $location = $db->select('vietove', ['id' => $hotel['fk_Vietove']])[0];
    $address = $location['adresas'] . ', ' . $location['miestas'] . ', ' . $location['salis'];
    $coords = geocodeAddress($address);
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/details_style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?= $_ENV['GOOGLE_MAPS_API_KEY'] ?>&loading=async&libraries=maps,marker"></script>
    <script src="js/comments.js" defer></script>
</head>

<body>

<?php include __DIR__ . '/../templates/navbar.php' ?>

    <main>
	<div class="container">
	<h2 class="hotel-name"><?= $hotel['pavadinimas'] ?></h2>
	</div>

        <!-- Image Slider -->
        <section class="image-slider">
            <div class="slider-container">
                <div class="slide active">
                    <img src="images/Hotel_Details_Danieli4.jpg" alt="Room 1" class="slider-image">
                </div>
                <div class="slide">
                    <img src="images/Hotel_Details_Danieli5.jpg" alt="Room 2" class="slider-image">
                </div>
                <div class="slide">
                    <img src="images/Hotel_Details_Danieli3.jpg" alt="Room 3" class="slider-image">
                </div>
                <button class="prev">&#10094;</button>
                <button class="next">&#10095;</button>
            </div>
        </section>

<div class="booking-container">
    <a href="/booking.php?hotel_id=<?= $hotel['id'] ?>" class="btn btn-outline book-now-button">
        Book Now
    </a>
</div>

        <div class="hotel-description">
	    <?= $converter->convert($hotel['aprasymas'])->getContent() ?>
        </div>

        <div class="map">
	    <gmp-map
		center="<?= $coords['lat'] ?>, <?= $coords['lng'] ?>"
		zoom="17"
		map-id="DEMO_MAP_ID">
	    <gmp-advanced-marker
		position="<?= $coords['lat'] ?>, <?= $coords['lng'] ?>"
		title="<?= $hotel['pavadinimas'] ?>"
		gmp-clickable></gmp-advanced-marker>
	    </gmp-map>
        </div>

        <section class="testimonials">
            <div class="container">
                <h2 class="section-title">What Our Guests Say</h2>

                <div id="comments-wrapper">
                    <div id="comment-container">
                        <!-- Comments will be rendered here -->
                    </div>

                    <div id="comment-management">
                        <button id="page-back-button" class="nav-icon" type="button">
                            <svg width="16" height="16" viewBox="0 0 16 16">
                                <path d="M10 2 L4 8 L10 14" stroke="currentColor" fill="none" stroke-width="2"/>
                            </svg>
                        </button>

                        <button id="page-forward-button" class="nav-icon" type="button">
                            <svg width="16" height="16" viewBox="0 0 16 16">
                                <path d="M6 2 L12 8 L6 14" stroke="currentColor" fill="none" stroke-width="2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fullscreen Modal (hidden by default) -->
        <div id="imageModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="modalImg">
        </div>

    </main>

    <?php include __DIR__ . '/../templates/footer.php' ?>

    <script>
        feather.replace();
    </script>

    <script>
        // Slider functionality (same as before)
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        document.querySelector('.next').addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        });

        document.querySelector('.prev').addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        });

        // --- Image modal (click to expand) ---
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImg');
        const closeBtn = document.querySelector('.close');

        // Open modal when clicking an image
        document.querySelectorAll('.slider-image').forEach(img => {
            img.addEventListener('click', () => {
                modal.style.display = 'block';
                modalImg.src = img.src;
            });
        });

        // Close modal when clicking the ×
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Optional: close when clicking outside the image
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = 'none';
        });
    </script>
</body>
</html>
