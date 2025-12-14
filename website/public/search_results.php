<?php
require_once __DIR__ . '/../src/database/database.php';
session_start();

$db = Database::getInstance();

// Handle filter profile application
if(isset($_GET['profile']) && isset($_SESSION['user_id'])) {
    $profileId = intval($_GET['profile']);
    $profile = $db->select('filtravimo_konfiguracija',
            array('id' => $profileId, 'fk_Vartotojas' => $_SESSION['user_id'])
    );

    if(!empty($profile)) {
        $config = json_decode($profile[0]['konfiguracija'], true);
        $_GET = array_merge($_GET, $config);
    }
}

// Get all tags for filters
$allTags = $db->select('tag', array(), '*');
$tagsByCategory = array();
foreach($allTags as $tag) {
    $tagsByCategory[$tag['kategorija']][] = $tag;
}

// Get all locations
$locations = $db->select('vietove', array(), '*');

// Get all seasons
$seasons = $db->select('sezonas', array(), '*');

// Get search parameters
$searchQuery = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';
$searchLocation = isset($_GET['location']) ? $_GET['location'] : '';
$checkIn = isset($_GET['check_in']) ? $_GET['check_in'] : '';
$checkOut = isset($_GET['check_out']) ? $_GET['check_out'] : '';
$guests = isset($_GET['guests']) ? $_GET['guests'] : 2;

// Get filter parameters
$selectedTags = isset($_GET['tags']) ? $_GET['tags'] : array();
$minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$minRooms = isset($_GET['min_rooms']) ? $_GET['min_rooms'] : '';
$selectedSeason = isset($_GET['season']) ? $_GET['season'] : '';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'reitingas_desc';

// Build query
$sql = "SELECT DISTINCT v.*, vt.salis, vt.miestas, vt.adresas 
        FROM viesbutis v 
        LEFT JOIN vietove vt ON v.fk_Vietove = vt.id";

$joins = array();
$conditions = array();
$params = array();

// Search query filter (searches in hotel name, city, and country)
if(!empty($searchQuery)) {
    $conditions[] = "(v.pavadinimas LIKE :search OR vt.miestas LIKE :search OR vt.salis LIKE :search)";
    $params[':search'] = '%' . $searchQuery . '%';
}

// Location filter (specific location ID)
if(!empty($searchLocation)) {
    $conditions[] = "v.fk_Vietove = :location";
    $params[':location'] = $searchLocation;
}

// Price filters
if($minPrice !== '') {
    $conditions[] = "v.kaina >= :min_price";
    $params[':min_price'] = $minPrice;
}
if($maxPrice !== '') {
    $conditions[] = "v.kaina <= :max_price";
    $params[':max_price'] = $maxPrice;
}

// Room count filter
if($minRooms !== '') {
    $conditions[] = "v.kambariu_skaicius >= :min_rooms";
    $params[':min_rooms'] = $minRooms;
}

// Season filter
if($selectedSeason !== '') {
    $conditions[] = "v.sezonas = :season";
    $params[':season'] = $selectedSeason;
}

// Tags filter
if(!empty($selectedTags)) {
    $sql .= " JOIN viesbutis_tag vtag ON v.id = vtag.fk_Viesbutis";
    $tagPlaceholders = [];
    foreach($selectedTags as $index => $tagId) {
        $tagPlaceholders[] = ":tag$index";
        $params[":tag$index"] = $tagId;
    }
    $conditions[] = "vtag.fk_Tag IN (" . implode(',', $tagPlaceholders) . ")";
}

// Add WHERE clause
if(!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Sorting
switch($sortBy) {
    case 'kaina_asc':
        $sql .= " ORDER BY v.kaina ASC";
        break;
    case 'kaina_desc':
        $sql .= " ORDER BY v.kaina DESC";
        break;
    case 'reitingas_asc':
        $sql .= " ORDER BY v.reitingas ASC";
        break;
    case 'reitingas_desc':
    default:
        $sql .= " ORDER BY v.reitingas DESC";
        break;
}

// Execute query
$stmt = $db->getHandler()->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

// Get user's filter profiles if logged in
$filterProfiles = array();
if(isset($_SESSION['user_id'])) {
    $filterProfiles = $db->select('filtravimo_konfiguracija', array('fk_Vartotojas' => $_SESSION['user_id']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Nomado</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/search.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<?php include __DIR__ . '/../templates/navbar.php' ?>

<main class="search-page" style="padding-top: 100px;">
    <div class="container">
        <!-- Success/Error Messages -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                switch($_GET['success']) {
                    case 'profile_saved':
                        echo 'Filter profile saved successfully!';
                        break;
                    case 'profile_updated':
                        echo 'Filter profile updated successfully!';
                        break;
                    case 'profile_deleted':
                        echo 'Filter profile deleted successfully!';
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
                        echo 'Please log in to save filter profiles.';
                        break;
                    case 'empty_name':
                        echo 'Please provide a name for the filter profile.';
                        break;
                    case 'no_hotels_selected':
                        echo 'Please select hotels to compare.';
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="search-layout">
            <!-- Filters Sidebar -->
            <aside class="filters-sidebar">
                <div class="filters-header">
                    <h3>Filters</h3>
                    <a href="search_results.php" class="clear-filters">Clear All</a>
                </div>

                <form method="GET" action="search_results.php" id="filterForm">
                    <!-- Search Query (if coming from home page) -->
                    <?php if(!empty($searchQuery)): ?>
                        <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <?php endif; ?>

                    <!-- Location Filter -->
                    <div class="filter-section">
                        <h4><i data-feather="map-pin"></i> Location</h4>
                        <select name="location" class="filter-select">
                            <option value="">All Locations</option>
                            <?php foreach($locations as $loc): ?>
                                <option value="<?php echo $loc['id']; ?>"
                                        <?php echo $searchLocation == $loc['id'] ? 'selected' : ''; ?>>
                                    <?php echo $loc['miestas'] . ', ' . $loc['salis']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-section">
                        <h4><i data-feather="dollar-sign"></i> Price Range</h4>
                        <div class="price-inputs">
                            <input type="number" name="min_price" placeholder="Min"
                                   min="0" max="9999" step="1"
                                   value="<?php echo $minPrice; ?>" class="price-input-small">
                            <span class="price-separator">-</span>
                            <input type="number" name="max_price" placeholder="Max"
                                   min="0" max="9999" step="1"
                                   value="<?php echo $maxPrice; ?>" class="price-input-small">
                        </div>
                    </div>

                    <!-- Room Count -->
                    <div class="filter-section">
                        <h4><i data-feather="home"></i> Minimum Rooms</h4>
                        <input type="number" name="min_rooms" placeholder="Number of rooms"
                               min="1" max="100"
                               value="<?php echo $minRooms; ?>" class="filter-input">
                    </div>

                    <!-- Season Filter -->
                    <div class="filter-section">
                        <h4><i data-feather="sun"></i> Season</h4>
                        <select name="season" class="filter-select">
                            <option value="">All Seasons</option>
                            <?php foreach($seasons as $season): ?>
                                <option value="<?php echo $season['id']; ?>"
                                        <?php echo $selectedSeason == $season['id'] ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($season['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tags Filter -->
                    <?php foreach($tagsByCategory as $category => $tags): ?>
                        <div class="filter-section">
                            <h4><i data-feather="tag"></i> <?php echo ucfirst($category); ?></h4>
                            <div class="checkbox-group">
                                <?php foreach($tags as $tag): ?>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="tags[]" value="<?php echo $tag['id']; ?>"
                                                <?php echo in_array($tag['id'], $selectedTags) ? 'checked' : ''; ?>>
                                        <span><?php echo ucfirst($tag['pavadinimas']); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary filter-apply">Apply Filters</button>
                </form>

                <!-- Filter Profiles -->
                <?php if(!empty($filterProfiles)): ?>
                    <div class="filter-section filter-profiles">
                        <h4><i data-feather="bookmark"></i> Saved Filter Profiles</h4>
                        <?php foreach($filterProfiles as $profile): ?>
                            <div class="profile-item">
                                <a href="?profile=<?php echo $profile['id']; ?>" class="profile-link">
                                    <?php echo $profile['pavadinimas']; ?>
                                </a>
                                <a href="delete_filter_profile.php?id=<?php echo $profile['id']; ?>"
                                   class="profile-delete" onclick="return confirm('Delete this profile?')">
                                    <i data-feather="trash-2"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Show filter profiles button -->
                <div class="filter-section">
                    <button type="button" class="btn btn-outline save-filter-btn" onclick="showProfiles()">
                        <i data-feather="filter"></i> Show Saved Profiles
                    </button>

                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <button type="button" class="btn btn-outline save-filter-btn" onclick="showLoginAlert()">
                            <i data-feather="save"></i> Save Current Filters
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline save-filter-btn" onclick="showSaveModal()">
                            <i data-feather="save"></i> Save Current Filters
                        </button>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Results Section -->
            <section class="results-section">
                <div class="results-header">
                    <div>
                        <h2><?php echo count($results); ?> Hotels Found</h2>
                        <?php if(!empty($searchQuery)): ?>
                            <p class="search-info">Showing results for: <strong><?php echo htmlspecialchars($searchQuery); ?></strong></p>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline" onclick="compareSelected()" style="margin-top: 10px;">
                            <i data-feather="columns"></i> Compare Selected (Max 3)
                        </button>
                    </div>
                    <div class="sort-controls">
                        <label>Sort by:</label>
                        <select name="sort" id="sortSelect" onchange="updateSort()">
                            <option value="reitingas_desc" <?php echo $sortBy == 'reitingas_desc' ? 'selected' : ''; ?>>
                                Highest Rating
                            </option>
                            <option value="reitingas_asc" <?php echo $sortBy == 'reitingas_asc' ? 'selected' : ''; ?>>
                                Lowest Rating
                            </option>
                            <option value="kaina_asc" <?php echo $sortBy == 'kaina_asc' ? 'selected' : ''; ?>>
                                Price: Low to High
                            </option>
                            <option value="kaina_desc" <?php echo $sortBy == 'kaina_desc' ? 'selected' : ''; ?>>
                                Price: High to Low
                            </option>
                        </select>
                    </div>
                </div>

                <div class="results-grid">
                    <?php if(empty($results)): ?>
                        <div class="no-results">
                            <i data-feather="search"></i>
                            <h3>No hotels found</h3>
                            <p>Try adjusting your filters to see more results</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($results as $hotel): ?>
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
                            <div class="result-card">
                                <div class="result-image" style="background-image: url('<?php echo $imagePath; ?>');">
                                    <?php
                                    // Check if hotel is in favorites
                                    $isFavorite = false;
                                    if(isset($_SESSION['user_id'])) {
                                        $favCheck = $db->getHandler()->prepare("
                                            SELECT mv.id 
                                            FROM megstamiausias_viesbutis mv
                                            JOIN megstamiausias_viesbutis_vartotojas mvv ON mv.id = mvv.fk_Megstamiausias_Viesbutis
                                            WHERE mv.fk_Viesbutis = :hotel_id AND mvv.fk_Vartotojas = :user_id
                                        ");
                                        $favCheck->execute([':hotel_id' => $hotel['id'], ':user_id' => $_SESSION['user_id']]);
                                        $isFavorite = $favCheck->fetch() !== false;
                                    }
                                    ?>
                                    <form action="<?php echo $isFavorite ? 'remove_favorite.php' : 'add_favorite.php'; ?>" method="POST" class="favorite-form">
                                        <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                                        <button type="submit" class="favorite-btn <?php echo $isFavorite ? 'active' : ''; ?>"
                                                title="<?php echo $isFavorite ? 'Remove from favorites' : 'Add to favorites'; ?>"
                                                <?php if(!isset($_SESSION['user_id'])): ?>
                                                    onclick="event.preventDefault(); alert('Please log in to add favorites'); window.location.href='login.php';"
                                                <?php endif; ?>>
                                            <i data-feather="heart"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="result-content">
                                    <div class="result-header">
                                        <h3><?php echo $hotel['pavadinimas']; ?></h3>
                                        <div class="result-rating">
                                            <i data-feather="star"></i>
                                            <span><?php echo number_format($hotel['reitingas'], 1); ?></span>
                                        </div>
                                    </div>
                                    <p class="result-location">
                                        <i data-feather="map-pin"></i>
                                        <?php echo $hotel['miestas'] . ', ' . $hotel['salis']; ?>
                                    </p>
                                    <p class="result-description"><?php echo $hotel['trumpas_aprasymas']; ?></p>
                                    <div class="result-tags">
                                        <?php foreach(array_slice($tagDetails, 0, 3) as $tag): ?>
                                            <span class="tag-badge"><?php echo $tag['pavadinimas']; ?></span>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- PRICE SECTION -->
                                    <div class="result-price-section">
                                        <div class="price-info">
                                            <span class="price-amount">$<?php echo $hotel['kaina']; ?></span>
                                            <span class="price-period">/ night</span>
                                        </div>

                                        <!-- ACTIONS SECTION (Compare + View Details) -->
                                        <div class="action-buttons">
                                            <div class="compare-action">
                                                <input type="checkbox" class="hotel-compare" value="<?php echo $hotel['id']; ?>"
                                                       id="hotel_<?php echo $hotel['id']; ?>"
                                                       onchange="updateCompareButton()">
                                                <label for="hotel_<?php echo $hotel['id']; ?>" class="compare-label">
                                                    <i data-feather="columns"></i>
                                                    <span>Compare</span>
                                                </label>
                                            </div>

                                            <form action="Hotel_Details.php" method="GET" class="details-form">
                                                <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                                                <button type="submit" class="btn btn-primary">
                                                    <i data-feather="eye"></i> View Details
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- Save Filter Profile Modal -->
<div id="saveFilterModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSaveModal()">&times;</span>
        <h2>Save Filter Profile</h2>
        <form action="save_filter_profile.php" method="POST" onsubmit="return validateProfileName()">
            <div class="form-group">
                <label for="profile_name">Profile Name:</label>
                <input type="text" id="profile_name" name="profile_name" required
                       placeholder="e.g., Beach Hotels Under $200">
                <div id="profileNameError" class="error-message" style="display: none;"></div>
            </div>

            <!-- Hidden inputs for current filter values -->
            <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="hidden" name="location" value="<?php echo $searchLocation; ?>">
            <input type="hidden" name="min_price" value="<?php echo $minPrice; ?>">
            <input type="hidden" name="max_price" value="<?php echo $maxPrice; ?>">
            <input type="hidden" name="min_rooms" value="<?php echo $minRooms; ?>">
            <input type="hidden" name="season" value="<?php echo $selectedSeason; ?>">
            <?php foreach($selectedTags as $tag): ?>
                <input type="hidden" name="tags[]" value="<?php echo $tag; ?>">
            <?php endforeach; ?>

            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeSaveModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php' ?>

<script>
    feather.replace();

    function updateSort() {
        const sortValue = document.getElementById('sortSelect').value;
        const form = document.getElementById('filterForm');
        const sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        sortInput.value = sortValue;
        form.appendChild(sortInput);
        form.submit();
    }

    function showSaveModal() {
        document.getElementById('saveFilterModal').style.display = 'block';
        document.getElementById('profile_name').focus();
    }

    function showLoginAlert() {
        alert('Please log in to save filter profiles.');
        window.location.href = 'login.php';
    }

    function showProfiles() {
        <?php if(!isset($_SESSION['user_id'])): ?>
        alert('Please log in to view your saved filter profiles.');
        window.location.href = 'login.php';
        <?php else: ?>
        // Scroll to filter profiles section
        const profilesSection = document.querySelector('.filter-profiles');
        if (profilesSection) {
            profilesSection.scrollIntoView({ behavior: 'smooth' });
            profilesSection.style.backgroundColor = '#f0f7ff';
            setTimeout(() => {
                profilesSection.style.backgroundColor = '';
            }, 2000);
        } else {
            alert('You don\'t have any saved filter profiles yet.');
        }
        <?php endif; ?>
    }

    function closeSaveModal() {
        document.getElementById('saveFilterModal').style.display = 'none';
        document.getElementById('profileNameError').style.display = 'none';
    }

    function validateProfileName() {
        const profileName = document.getElementById('profile_name').value.trim();
        const errorDiv = document.getElementById('profileNameError');

        if (profileName.length === 0) {
            errorDiv.textContent = 'Please enter a profile name';
            errorDiv.style.display = 'block';
            return false;
        }

        if (profileName.length > 50) {
            errorDiv.textContent = 'Profile name must be less than 50 characters';
            errorDiv.style.display = 'block';
            return false;
        }

        return true;
    }

    function compareSelected() {
        const checkboxes = document.querySelectorAll('.hotel-compare:checked');
        const hotelIds = Array.from(checkboxes).map(cb => cb.value);

        if(hotelIds.length < 2) {
            alert('Please select at least 2 hotels to compare.');
            return;
        }

        if(hotelIds.length > 3) {
            alert('You can compare maximum 3 hotels at a time.');
            return;
        }

        const params = hotelIds.map(id => 'hotels[]=' + id).join('&');
        window.location.href = 'compare_hotels.php?' + params;
    }

    function updateCompareButton() {
        const checkboxes = document.querySelectorAll('.hotel-compare:checked');
        const compareBtn = document.querySelector('[onclick="compareSelected()"]');

        if (checkboxes.length >= 2) {
            compareBtn.textContent = `Compare Selected (${checkboxes.length}/3)`;
        } else {
            compareBtn.textContent = 'Compare Selected (Max 3)';
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('saveFilterModal');
        if (event.target == modal) {
            closeSaveModal();
        }
    }

    // Prevent negative values in price inputs
    document.addEventListener('DOMContentLoaded', function() {
        const priceInputs = document.querySelectorAll('input[name="min_price"], input[name="max_price"]');
        priceInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (parseFloat(this.value) < 0) {
                    this.value = 0;
                }
            });
        });

        const roomInput = document.querySelector('input[name="min_rooms"]');
        if (roomInput) {
            roomInput.addEventListener('change', function() {
                if (parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.display = 'none';
        });
    }, 5000);
</script>
<style>
    .search-info {
        margin-top: 8px;
        color: #666;
        font-size: 14px;
    }
    .search-info strong {
        color: #333;
    }
</style>
</body>
</html>