<?php
// Hero section include file
// Gets included after the header on pages that need a hero section

// Default hero title and subtitle if not set
if (!isset($heroTitle)) {
    $heroTitle = SITE_NAME;
}

if (!isset($heroSubtitle)) {
    $heroSubtitle = "Explore the comprehensive database for your MMORPG adventure";
}
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title"><?php echo htmlspecialchars($heroTitle); ?></h1>
        <p class="hero-subtitle"><?php echo htmlspecialchars($heroSubtitle); ?></p>
        
        <!-- Search Form -->
        <div class="search-container">
            <form action="<?php echo SITE_URL; ?>/public/search.php" method="get" class="search-form">
                <input type="text" name="q" class="search-input" placeholder="Search for weapons, armor, items, maps, monsters, or dolls..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>
</section>
