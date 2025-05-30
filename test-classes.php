<?php
// Test each class individually
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

echo "<h1>Testing Classes</h1>";

// Test User class
try {
    require_once __DIR__ . '/classes/User.php';
    $user = new User();
    echo "<p>✓ User class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ User class error: " . $e->getMessage() . "</p>";
}

// Test Weapon class
try {
    require_once __DIR__ . '/classes/Weapon.php';
    $weapons = new Weapon();
    echo "<p>✓ Weapon class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Weapon class error: " . $e->getMessage() . "</p>";
}

// Test getting recent weapons
try {
    $recentWeapons = $weapons->getRecentWeapons(4);
    echo "<p>✓ Got " . count($recentWeapons) . " recent weapons</p>";
} catch (Exception $e) {
    echo "<p>✗ Recent weapons error: " . $e->getMessage() . "</p>";
}

// Test Armor class
try {
    require_once __DIR__ . '/classes/Armor.php';
    $armor = new Armor();
    echo "<p>✓ Armor class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Armor class error: " . $e->getMessage() . "</p>";
}

// Test Item class
try {
    require_once __DIR__ . '/classes/Item.php';
    $items = new Item();
    echo "<p>✓ Item class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Item class error: " . $e->getMessage() . "</p>";
}

// Test Map class
try {
    require_once __DIR__ . '/classes/Map.php';
    $maps = new Map();
    echo "<p>✓ Map class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Map class error: " . $e->getMessage() . "</p>";
}

// Test Monster class
try {
    require_once __DIR__ . '/classes/Monster.php';
    $monster = new Monster();
    echo "<p>✓ Monster class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Monster class error: " . $e->getMessage() . "</p>";
}

// Test Doll class
try {
    require_once __DIR__ . '/classes/Doll.php';
    $dolls = new Doll();
    echo "<p>✓ Doll class loaded</p>";
} catch (Exception $e) {
    echo "<p>✗ Doll class error: " . $e->getMessage() . "</p>";
}

echo "<h2>All tests completed</h2>";
?>