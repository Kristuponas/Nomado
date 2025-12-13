<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamStay Haven - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <?php include __DIR__ . '/../templates/navbar.php' ?>

    <main>
        <section class="featured-rooms">
            <div class="container">
                <h2 class="section-title">Featured Rooms</h2>
                <div class="rooms-grid">
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('./images/Danieli_image.jpeg');"></div>
                        <div class="room-details">
                            <h3>Venice Retreat</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 5 Guests</span>
                                <span><i data-feather="maximize-2"></i> 65m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$199</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button onclick = "window.location.href='home.php'" class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Belmond_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Belmond Manor</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 6 Guests</span>
                                <span><i data-feather="maximize-2"></i> 75m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$149</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Italian_four_seasons_Image.jpeg');"></div>
                        <div class="room-details">
                            <h3>Florence Suites</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 4 Guests</span>
                                <span><i data-feather="maximize-2"></i> 65m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$249</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-rooms">
            <div class="container">
                <h2 class="section-title">Seasonal Deals</h2>
                <div class="rooms-grid">
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Nordic_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Nordic Winter Escape</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 2 Guests</span>
                                <span><i data-feather="maximize-2"></i> 45m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$149</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Tuscan_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Tuskan Sun Stay</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 4 Guests</span>
                                <span><i data-feather="maximize-2"></i> 35m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$199</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Seaside_hotel.jpg');"></div>
                        <div class="room-details">
                            <h3>Seaside serenity</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 6 Guests</span>
                                <span><i data-feather="maximize-2"></i> 65m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$249</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hotel-categories">
    
<section class="featured-rooms">
            <div class="container">
                <h2 class="section-title">Elegant & Timeless</h2>
                <div class="rooms-grid">
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Four_seasons_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Four seasons stay</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 5 Guests</span>
                                <span><i data-feather="maximize-2"></i> 65m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$169</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Six_senses_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Six senses stay</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 4 Guests</span>
                                <span><i data-feather="maximize-2"></i> 50m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">219</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Aman_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Aman Resort</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 7 Guests</span>
                                <span><i data-feather="maximize-2"></i> 85m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$249</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-rooms">
            <div class="container">
                <h2 class="section-title">Nature Retreats</h2>
                <div class="rooms-grid">
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Nihi_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Indoneasian Nihi resort</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 3 Guests</span>
                                <span><i data-feather="maximize-2"></i> 45m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$169</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/Bambu_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Bambu Idah Resort</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 4 Guests</span>
                                <span><i data-feather="maximize-2"></i> 50m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">219</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('/images/El_silencio_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Costa Rican Escape</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 7 Guests</span>
                                <span><i data-feather="maximize-2"></i> 85m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$249</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    <div class="room-card">
                        <div class="room-image" style="background-image: url('../images/Soneva_Kiri_image.jpg');"></div>
                        <div class="room-details">
                            <h3>Thailand Lodge</h3>
                            <div class="room-features">
                                <span><i data-feather="users"></i> 7 Guests</span>
                                <span><i data-feather="maximize-2"></i> 85m²</span>
                                <span><i data-feather="wifi"></i> Free WiFi</span>
                            </div>
                            <div class="room-price">
                                <span class="price">$249</span>
                                <span class="per-night">/ night</span>
                            </div>
                            <button class="btn btn-outline">View Details</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <section class="hotel-categories">
        <section class="amenities">
            <div class="container">
                <h2 class="section-title">Our Amenities</h2>
                <div class="amenities-grid">
                    <div class="amenity-card">
                        <div class="amenity-icon">
                            <i data-feather="wifi"></i>
                        </div>
                        <h3>Free WiFi</h3>
                        <p>High-speed internet access throughout the property</p>
                    </div>
                    
                    <div class="amenity-card">
                        <div class="amenity-icon">
                            <i data-feather="coffee"></i>
                        </div>
                        <h3>Breakfast</h3>
                        <p>Complimentary breakfast buffet every morning</p>
                    </div>
                    
                    <div class="amenity-card">
                        <div class="amenity-icon">
                            <i data-feather="droplet"></i>
                        </div>
                        <h3>Pool</h3>
                        <p>Heated outdoor pool available year-round</p>
                    </div>
                    
                    <div class="amenity-card">
                        <div class="amenity-icon">
                            <i data-feather="umbrella"></i>
                        </div>
                        <h3>Beach Access</h3>
                        <p>Private beach access with complimentary chairs</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <h2 class="section-title">What Our Guests Say</h2>
                <div class="testimonial-slider">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="rating">
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                            </div>
                            <p>"The service was impeccable and the room was even better than the photos. Will definitely be returning!"</p>
                            <div class="guest-info">
                                <div class="guest-avatar" style="background-image: url('http://static.photos/people/100x100/1');"></div>
                                <div>
                                    <h4>Sarah Johnson</h4>
                                    <p>New York, USA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="rating">
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star" class="filled"></i>
                                <i data-feather="star"></i>
                            </div>
                            <p>"The location was perfect and the staff went above and beyond to make our stay memorable."</p>
                            <div class="guest-info">
                                <div class="guest-avatar" style="background-image: url('http://static.photos/people/100x100/2');"></div>
                                <div>
                                    <h4>Michael Chen</h4>
                                    <p>Toronto, Canada</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php include __DIR__ . '/../templates/footer.php' ?>

    <script>
        feather.replace();
    </script>
    <script src="components/footer.js"></script>
    
</body>
</html>
