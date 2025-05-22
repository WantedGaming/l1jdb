# PHP Architecture Analysis: Classes vs Functions

## Purpose and Differences

### Class Files Purpose (Entity-Specific Logic)
The class files represent **domain models** - each class encapsulates business logic for a specific entity type. They provide:

- **State Management**: Each class maintains a database connection instance
- **Entity-Specific Operations**: CRUD operations tailored to each entity
- **Complex Business Logic**: Transaction handling, cascading deletes, validation rules
- **Data Relationships**: Methods for handling entity associations (armor sets, weapon skills, etc.)
- **Consistent Interface**: Standardized methods across all entity types

### Functions File Purpose (Utility Helpers)
The functions.php file contains **utility functions** that are:

- **Stateless**: Pure functions without side effects
- **Cross-cutting**: Used by multiple classes and views
- **General Purpose**: Formatting, URL generation, common operations
- **Performance Optimized**: Simple operations that don't need object instantiation

## Comparison Analysis

### Overlapping Functionality ⚠️

| Function | Class Implementation | functions.php Implementation |
|----------|---------------------|----------------------------|
| **Icon URLs** | `getArmorIconUrl()`, `getWeaponIconUrl()` | `getItemIconUrl()` |
| **Monster Sprites** | `getMonsterSpriteUrl()` in multiple classes | `getMonsterSpriteUrl()` |
| **Resistance Formatting** | `formatResistName()` in Item/Weapon classes | `formatResistanceName()` |
| **Drop Data** | `getMonstersThatDropArmor()`, `getWeaponDrops()` | `getItemDrops()` |
| **Bin Data** | `getBinItemData()`, `hasBinData()` in classes | `getBinItemData()`, `hasBinData()` |

### Unique Class Functionality ✅

**Complex Operations Only Classes Can Handle:**
- **Transaction Management**: `deleteWeapon()` with cascading deletes
- **Pagination**: Database-aware pagination with conditions
- **Entity Relationships**: Armor sets, weapon skills, spawn locations
- **Authentication**: User login/logout with session management
- **Activity Logging**: Admin activity tracking

### Unique Functions Functionality ✅

**Utilities Only Functions Provide:**
- **Data Formatting**: `formatWeaponType()`, `formatArmorType()`, `formatMaterial()`
- **Display Helpers**: `formatStatBonus()`, `formatDamageRange()`, `getPaginationInfo()`
- **Text Processing**: `cleanItemName()`, removing Korean characters
- **Cache Management**: `generateCacheKey()`

## Architecture Recommendations

### 1. **Keep Both - They Serve Different Purposes**

**Classes Should Handle:**
```php
// Complex business operations
$weapon = new Weapon();
$result = $weapon->deleteWeapon($id); // Handles transactions, cascading deletes

// Entity-specific queries with pagination
$armors = $armor->filterArmor($filters, $page, $perPage);

// Authentication and session management
$user->login($username, $password);
```

**Functions Should Handle:**
```php
// Simple formatting
$displayName = cleanItemName($item['desc_en']);
$formattedType = formatWeaponType($weapon['type']);

// URL generation
$iconUrl = getItemIconUrl($item['iconId']);

// Display utilities
$statDisplay = formatStatBonus($item['add_str']);
```

### 2. **Clean Up Duplication**

**Remove from Classes:**
- Move `formatResistName()` to functions.php only
- Consolidate icon URL generation to functions.php
- Use shared `getItemDrops()` function instead of class-specific versions

**Example Refactor:**
```php
// Instead of each class having its own icon method:
class Weapon {
    public function getWeaponIconUrl($iconId) {
        return getItemIconUrl($iconId); // Use shared function
    }
}
```

### 3. **Improved Organization**

**Class Methods Should Focus On:**
- Database operations requiring state
- Business logic with validation
- Entity relationships
- Transaction management

**Functions Should Focus On:**
- Pure formatting operations
- Cross-cutting utilities
- Performance-critical helpers
- Template/view helpers

## Answer: Do We Need Both?

**YES** - but with some cleanup:

1. **Classes are essential** for complex database operations, business logic, and maintaining state
2. **Functions are essential** for reusable utilities and performance-critical operations
3. **The duplication should be eliminated** by moving shared utilities to functions.php
4. **Classes should call functions** for common operations rather than duplicating code

This creates a **layered architecture**:
- **Classes** = Business Logic Layer
- **Functions** = Utility/Helper Layer
- **Database** = Data Access Layer

# PHP Model Classes - Function List

## Armor.php - Class: Armor

### Data Retrieval Functions
- `getAllArmor($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'armor.item_id ASC')`
- `getArmorById($id)`
- `getArmorByNameId($nameId)`
- `getBinItemData($nameId)`
- `hasBinData($nameId)`

### Search & Filter Functions
- `searchArmor($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterArmor($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Filter Options Functions
- `getArmorTypes()`
- `getArmorMaterials()`
- `getArmorGrades()`

### Armor Set Functions
- `getArmorSet($setId)`
- `getAllArmorSets($page = 1, $perPage = ITEMS_PER_PAGE)`
- `getArmorSetPieces($setId)`

### Stats & Information Functions
- `getArmorStats($armorId)`

### CRUD Operations
- `createArmor($data)`
- `updateArmor($id, $data)`
- `deleteArmor($id)`
- `createArmorSet($data)`
- `updateArmorSet($id, $data)`
- `deleteArmorSet($id)`

### Recent Data Functions
- `getRecentArmor($limit = 5)`
- `getRecentArmorSets($limit = 5)`

### URL & Media Functions
- `getArmorIconUrl($iconId)`

### Drop System Functions
- `getMonstersThatDropArmor($armorId)`
- `getMonsterSpriteUrl($spriteId)`

---

## Doll.php - Class: Doll

### Data Retrieval Functions
- `getAllDolls($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'etcitem.item_id ASC')`
- `getDollById($id)`

### Search & Filter Functions
- `searchDolls($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterDolls($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Filter Options Functions
- `getDollMaterials()`
- `getDollGrades()`

### Stats & Information Functions
- `getDollStats($dollId)`
- `getDollsByLevelRange($minLevel, $maxLevel, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `getDollClassRestrictions($dollId)`

### CRUD Operations
- `createDoll($data)`
- `updateDoll($id, $data)`
- `deleteDoll($id)`

### Statistics Functions
- `getDollCount()`
- `getRecentDolls($limit = 5)`
- `getHighestLevelDolls($limit = 5)`

### URL & Media Functions
- `getDollIconUrl($iconId)`
- `getDollSpriteUrl($spriteId)`

---

## Item.php - Class: Item

### Data Retrieval Functions
- `getAllItems($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'etcitem.item_id ASC')`
- `getItemById($id)`

### Search & Filter Functions
- `searchItems($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterItems($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Filter Options Functions
- `getItemTypes()`
- `getItemUseTypes()`
- `getItemMaterials()`
- `getItemGrades()`

### Stats & Information Functions
- `getItemStats($itemId)`
- `getItemDelayInfo($itemId)`

### Category Functions
- `getItemsByType($type, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `getItemsByUseType($useType, $page = 1, $perPage = ITEMS_PER_PAGE)`

### CRUD Operations
- `createItem($data)`
- `updateItem($id, $data)`
- `deleteItem($id)`

### Recent Data Functions
- `getRecentItems($limit = 5)`

### URL & Media Functions
- `getItemIconUrl($iconId)`
- `getItemSpriteUrl($spriteId)`

### Drop System Functions
- `getItemDrops($itemId)`
- `getMonsterSpriteUrl($spriteId)`

### Utility Functions
- `formatResistName($resistName)`

---

## Map.php - Class: Map

### Data Retrieval Functions
- `getAllMaps($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'mapids.mapid ASC')`
- `getMapById($id)`
- `getMapDetails($mapId)`

### Search & Filter Functions
- `searchMaps($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterMaps($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Specialized Map Functions
- `getDungeonMaps($page = 1, $perPage = ITEMS_PER_PAGE)`
- `getUnderwaterMaps($page = 1, $perPage = ITEMS_PER_PAGE)`
- `getClonedMaps($baseMapId)`

### Map Content Functions
- `getMapNpcSpawns($mapId)`

### CRUD Operations
- `createMap($data)`
- `updateMap($id, $data)`
- `deleteMap($id)`

### Statistics Functions
- `getMapCount()`
- `getDungeonMapCount()`
- `getMapSpawnCount($mapId)`

### Recent Data Functions
- `getRecentMaps($limit = 5)`

### URL & Media Functions
- `getMapImageUrl($pngId)`

### Filter Options Functions
- `getMapTypes()`

---

## Monster.php - Class: Monster

### Data Retrieval Functions
- `getAllMonsters($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'npc.npcid ASC')`
- `getMonsterById($id)`

### Search & Filter Functions
- `searchMonsters($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterMonsters($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Filter Options Functions
- `getMonsterTypes()`
- `getMonsterUndeadTypes()`
- `getMonsterWeakAttributes()`

### Stats & Information Functions
- `getMonsterStats($monsterId)`

### Specialized Monster Functions
- `getMonstersByLevelRange($minLevel, $maxLevel, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `getBossMonsters($page = 1, $perPage = ITEMS_PER_PAGE)`

### Location Functions
- `getMonsterSpawnLocations($monsterId)`

### CRUD Operations
- `createMonster($data)`
- `updateMonster($id, $data)`
- `deleteMonster($id)`

### Recent Data Functions
- `getRecentMonsters($limit = 5)`

### URL & Media Functions
- `getMonsterSpriteUrl($spriteId)`

---

## User.php - Class: User

### Authentication Functions
- `login($username, $password)`
- `logout()`
- `isLoggedIn()`
- `isAdmin()`

### User Information Functions
- `getCurrentUser()`
- `getAllAdmins()`

### Activity Logging Functions
- `logActivity($username, $activityType, $description, $entityType = null, $entityId = null)`
- `getActivityLogs($page = 1, $perPage = ITEMS_PER_PAGE, $conditions = '', $params = [])`

### Utility Functions
- `updateLastActive($username)`

### Private Functions
- `createActivityTableIfNotExists()`

---

## Weapon.php - Class: Weapon

### Data Retrieval Functions
- `getAllWeapons($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'weapon.item_id ASC')`
- `getWeaponById($id)`
- `getWeaponsByNameId($nameId)`

### Search & Filter Functions
- `searchWeapons($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE)`
- `filterWeapons($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE)`

### Filter Options Functions
- `getWeaponTypes()`
- `getWeaponMaterials()`
- `getWeaponGrades()`

### Weapon Skills & Stats Functions
- `getWeaponSkills($weaponId)`
- `getWeaponDamage($weaponId)`
- `getWeaponAllStats($weaponId)`

### Binary Data Functions
- `hasBinData($nameId)`
- `getBinItemData($nameId)`

### CRUD Operations
- `createWeapon($data)`
- `updateWeapon($id, $data)`
- `deleteWeapon($id)`

### Recent Data Functions
- `getRecentWeapons($limit = 5)`

### URL & Media Functions
- `getWeaponIconUrl($iconId)`
- `getWeaponSpriteUrl($spriteId)`

### Drop System Functions
- `getWeaponDrops($weaponId)`
- `getMonsterSpriteUrl($spriteId)`

### Utility Functions
- `formatResistName($resistName)`

---

## Function Summary by Category

### Total Functions by Class:
- **Armor**: 25 functions
- **Doll**: 16 functions  
- **Item**: 19 functions
- **Map**: 17 functions
- **Monster**: 16 functions
- **User**: 11 functions
- **Weapon**: 21 functions

### **Total Functions: 125**

### Common Function Patterns:
- **CRUD Operations**: Create, Read, Update, Delete
- **Pagination**: Most retrieval functions support pagination
- **Search & Filter**: Advanced search and filtering capabilities
- **URL Generation**: Icon and sprite URL generation
- **Stats & Information**: Detailed statistics and information retrieval
- **Drop System**: Monster drop relationships
- **Recent Data**: Getting recently added items
- **Filter Options**: Getting available filter values