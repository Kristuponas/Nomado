<form action="search_results.php" method="GET" class="search-box" id="searchForm">
    <div class="search-field">
        <i data-feather="map-pin"></i>
        <input type="text"
               name="search_query"
               id="searchQuery"
               placeholder="Enter city or country"
               autocomplete="off">
    </div>

    <div class="search-field">
        <i data-feather="calendar"></i>
        <input type="date"
               name="check_in"
               placeholder="Check-in"
               id="checkIn"
               min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="search-field">
        <i data-feather="calendar"></i>
        <input type="date"
               name="check_out"
               placeholder="Check-out"
               id="checkOut"
               min="<?php echo date('Y-m-d'); ?>">
    </div>

    <button type="submit" class="btn btn-primary btn-search">
        <i data-feather="search"></i>
        Search Hotels
    </button>
</form>

<script>
    // Patikrinimas, kad check-out būtų vėlesnis nei check-in
    document.addEventListener('DOMContentLoaded', function() {
        const checkIn = document.getElementById('checkIn');
        const checkOut = document.getElementById('checkOut');

        // Nustatyti minimalias datos
        const today = new Date().toISOString().split('T')[0];
        checkIn.min = today;
        checkOut.min = today;

        // Kai keičiasi check-in data, atnaujinti check-out minimalią datą
        checkIn.addEventListener('change', function() {
            if (checkIn.value) {
                checkOut.min = checkIn.value;

                // Jei check-out data ankstesnė nei nauja check-in data
                if (checkOut.value && checkOut.value < checkIn.value) {
                    checkOut.value = checkIn.value;
                }
            }
        });
    });
</script>
