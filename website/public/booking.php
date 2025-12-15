<?php
session_start();
if (!empty($_SESSION['user_id']) && !empty($_GET['hotel_id'])) {
    header('Location: /login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'save':
            require_once __DIR__ . '/../src/booking/save_reservation.php';
            break;
    }
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
</head>
<body>

    <?php include __DIR__ . '/../templates/navbar.php'; ?>

    <main class="form-container">
        <h2>New Reservation</h2>

        <form action="" method="POST" class="db-form">
	<input type="hidden" name="action" value="save"></input>
        <div class="date-range">

        <!-- From -->
            <div class="form-group">
                <label for="from_date">Check-in</label>
                <input type="date"
                       id="from_date"
                       name="from_date"
                       min="<?= date('Y-m-d') ?>"
                       required>
            </div>

        <!-- To -->
            <div class="form-group">
                <label for="to_date">Check-out</label>
                <input type="date"
                       id="to_date"
                       name="to_date"
                       required>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit">Book Now</button>
        </div>

    </form>

    </main>

    <?php include __DIR__ . '/../templates/footer.php'; ?>

</body>
</html>
