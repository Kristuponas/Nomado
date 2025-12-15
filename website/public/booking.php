<?php
session_start();
if (!empty($_SESSION['user_id'])) {
    header('Location: /');
}

echo var_dump($_SESSION['user_id']);

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

    <form action="save_reservation.php" method="POST" class="db-form">

        <!-- Pradžios data -->
        <div class="form-group">
            <label for="pradzios_data">Start Date & Time</label>
            <input type="datetime-local" id="pradzios_data" name="pradzios_data" required>
        </div>

        <!-- Pabaigos data -->
        <div class="form-group">
            <label for="pabaigos_data">End Date & Time</label>
            <input type="datetime-local" id="pabaigos_data" name="pabaigos_data" required>
        </div>

        <!-- FK: Vartotojas -->
        <div class="form-group">
            <label for="fk_Vartotojas">User ID</label>
            <input type="number" id="fk_Vartotojas" name="fk_Vartotojas" required>
        </div>

        <!-- FK: Viesbutis -->
        <div class="form-group">
            <label for="fk_Viesbutis">Hotel ID</label>
            <input type="number" id="fk_Viesbutis" name="fk_Viesbutis" required>
        </div>

        <!-- Submit -->
        <div class="form-actions">
            <button type="submit">Save</button>
            <button type="reset">Clear</button>
        </div>

    </form>
</main>

<?php include __DIR__ . '/../templates/footer.php'; ?>

</body>
</html>
