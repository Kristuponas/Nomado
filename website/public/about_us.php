<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <?php require __DIR__ . '/../templates/navbar.php' ?>
    <main>
        <h1 style="padding-top: 10%; text-align: center; margin-bottom: 10px; font-family: Old Standard TT,serif; font-weight: lighter">About us</h1>
        <hr style="margin: 0 20%;">
        <p style="font-size: 16px; padding-top: 5%; padding-left: 20%; padding-right: 20%">
            Nomado is a global platform dedicated to discovering and showcasing luxury and exotic hotels 
            for modern travelers who value quality, authenticity, and unforgettable experiences. 
            We carefully curate each property to ensure it meets our standards of design, comfort, location, and unique character. </p>
        <br>
        <p style="font-size: 16px; padding-left: 20%; padding-right: 20%"> We believe that where you stay shapes how you experience a destination. 
            That’s why Nomado goes beyond traditional bookings, connecting travelers with extraordinary places
             — from remote island hideaways and private villas to refined boutique hotels in the world’s most inspiring cities. </p>
        <br>
        <p style="font-size: 16px; padding-left: 20%; padding-right: 20%""> Our mission is to make exceptional travel effortless by offering a seamless booking experience, 
            personalized inspiration, and access to stays that turn trips into lasting memories. With Nomado, 
            every journey begins with a place worth remembering.</p>
    </main>

    <?php include __DIR__ . '/../templates/footer.php' ?>

    <script>
        feather.replace();
    </script>
    <script src="components/footer.js"></script>
</body>
</html>
