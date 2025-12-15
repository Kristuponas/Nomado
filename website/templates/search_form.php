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
        <input type="date" name="check_in" placeholder="Check-in" id="checkIn">
    </div>

    <div class="search-field">
        <i data-feather="calendar"></i>
        <input type="date" name="check_out" placeholder="Check-out" id="checkOut">
    </div>

    <div class="search-field">
        <i data-feather="users"></i>
        <input type="number" name="guests" placeholder="Guests" min="1" value="2">
    </div>

    <button type="submit" class="btn btn-primary btn-search">
        <i data-feather="search"></i>
        Search Hotels
    </button>
</form>
