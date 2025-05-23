<?php
// Admin monsters creation page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Monster.php';
require_once '../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Initialize monsters model
$monstersModel = new Monster();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate required fields
    if (empty($_POST['npcid'])) {
        $errors[] = "NPC ID is required.";
    } elseif (!is_numeric($_POST['npcid']) || (int)$_POST['npcid'] <= 0) {
        $errors[] = "NPC ID must be a positive number.";
    } else {
        // Check if NPC ID already exists
        $existingMonster = $monstersModel->getMonsterById((int)$_POST['npcid']);
        if ($existingMonster) {
            $errors[] = "A monster with ID {$_POST['npcid']} already exists.";
        }
    }
    
    if (empty($_POST['desc_en'])) {
        $errors[] = "English description is required.";
    }
    
    if (empty($_POST['impl']) || !in_array($_POST['impl'], ['L1Monster', 'L1BlackKnight', 'L1Doppelganger'])) {
        $errors[] = "Valid implementation type is required.";
    }
    
    // Validate numeric fields
    $numericFields = [
        'classId', 'spriteId', 'lvl', 'hp', 'mp', 'ac', 'str', 'con', 'dex', 
        'wis', 'intel', 'mr', 'exp', 'alignment', 'ranged', 'passispeed', 
        'atkspeed', 'atk_magic_speed', 'sub_magic_speed', 'agrofamily', 
        'agrogfxid1', 'agrogfxid2', 'digestitem', 'hprinterval', 'hpr', 
        'mprinterval', 'mpr', 'randomlevel', 'randomhp', 'randommp', 
        'randomac', 'randomexp', 'randomAlign', 'damage_reduction', 
        'bowSpritetId', 'karma', 'transform_id', 'transform_gfxid', 
        'light_size', 'spawnlist_door', 'count_map'
    ];
    
    foreach ($numericFields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== '' && !is_numeric($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " must be a number.";
        }
    }
    
    if (empty($errors)) {
        // Prepare data for insertion
        $data = [
            'npcid' => (int)$_POST['npcid'],
            'classId' => !empty($_POST['classId']) ? (int)$_POST['classId'] : 0,
            'desc_en' => trim($_POST['desc_en']),
            'desc_powerbook' => trim($_POST['desc_powerbook'] ?? ''),
            'desc_kr' => trim($_POST['desc_kr'] ?? ''),
            'desc_id' => trim($_POST['desc_id'] ?? ''),
            'note' => trim($_POST['note'] ?? ''),
            'impl' => $_POST['impl'],
            'spriteId' => !empty($_POST['spriteId']) ? (int)$_POST['spriteId'] : 0,
            'lvl' => !empty($_POST['lvl']) ? (int)$_POST['lvl'] : 0,
            'hp' => !empty($_POST['hp']) ? (int)$_POST['hp'] : 0,
            'mp' => !empty($_POST['mp']) ? (int)$_POST['mp'] : 0,
            'ac' => !empty($_POST['ac']) ? (int)$_POST['ac'] : 0,
            'str' => !empty($_POST['str']) ? (int)$_POST['str'] : 0,
            'con' => !empty($_POST['con']) ? (int)$_POST['con'] : 0,
            'dex' => !empty($_POST['dex']) ? (int)$_POST['dex'] : 0,
            'wis' => !empty($_POST['wis']) ? (int)$_POST['wis'] : 0,
            'intel' => !empty($_POST['intel']) ? (int)$_POST['intel'] : 0,
            'mr' => !empty($_POST['mr']) ? (int)$_POST['mr'] : 0,
            'exp' => !empty($_POST['exp']) ? (int)$_POST['exp'] : 0,
            'alignment' => !empty($_POST['alignment']) ? (int)$_POST['alignment'] : 0,
            'big' => $_POST['big'] ?? 'false',
            'weakAttr' => $_POST['weakAttr'] ?? 'NONE',
            'ranged' => !empty($_POST['ranged']) ? (int)$_POST['ranged'] : 0,
            'is_taming' => $_POST['is_taming'] ?? 'false',
            'passispeed' => !empty($_POST['passispeed']) ? (int)$_POST['passispeed'] : 0,
            'atkspeed' => !empty($_POST['atkspeed']) ? (int)$_POST['atkspeed'] : 0,
            'atk_magic_speed' => !empty($_POST['atk_magic_speed']) ? (int)$_POST['atk_magic_speed'] : 0,
            'sub_magic_speed' => !empty($_POST['sub_magic_speed']) ? (int)$_POST['sub_magic_speed'] : 0,
            'undead' => $_POST['undead'] ?? 'NONE',
            'poison_atk' => $_POST['poison_atk'] ?? 'NONE',
            'is_agro' => $_POST['is_agro'] ?? 'false',
            'is_agro_poly' => $_POST['is_agro_poly'] ?? 'false',
            'is_agro_invis' => $_POST['is_agro_invis'] ?? 'false',
            'family' => trim($_POST['family'] ?? ''),
            'agrofamily' => !empty($_POST['agrofamily']) ? (int)$_POST['agrofamily'] : 0,
            'agrogfxid1' => !empty($_POST['agrogfxid1']) ? (int)$_POST['agrogfxid1'] : -1,
            'agrogfxid2' => !empty($_POST['agrogfxid2']) ? (int)$_POST['agrogfxid2'] : -1,
            'is_picupitem' => $_POST['is_picupitem'] ?? 'false',
            'digestitem' => !empty($_POST['digestitem']) ? (int)$_POST['digestitem'] : 0,
            'is_bravespeed' => $_POST['is_bravespeed'] ?? 'false',
            'hprinterval' => !empty($_POST['hprinterval']) ? (int)$_POST['hprinterval'] : 0,
            'hpr' => !empty($_POST['hpr']) ? (int)$_POST['hpr'] : 0,
            'mprinterval' => !empty($_POST['mprinterval']) ? (int)$_POST['mprinterval'] : 0,
            'mpr' => !empty($_POST['mpr']) ? (int)$_POST['mpr'] : 0,
            'is_teleport' => $_POST['is_teleport'] ?? 'false',
            'randomlevel' => !empty($_POST['randomlevel']) ? (int)$_POST['randomlevel'] : 0,
            'randomhp' => !empty($_POST['randomhp']) ? (int)$_POST['randomhp'] : 0,
            'randommp' => !empty($_POST['randommp']) ? (int)$_POST['randommp'] : 0,
            'randomac' => !empty($_POST['randomac']) ? (int)$_POST['randomac'] : 0,
            'randomexp' => !empty($_POST['randomexp']) ? (int)$_POST['randomexp'] : 0,
            'randomAlign' => !empty($_POST['randomAlign']) ? (int)$_POST['randomAlign'] : 0,
            'damage_reduction' => !empty($_POST['damage_reduction']) ? (int)$_POST['damage_reduction'] : 0,
            'is_hard' => $_POST['is_hard'] ?? 'false',
            'is_bossmonster' => $_POST['is_bossmonster'] ?? 'false',
            'can_turnundead' => $_POST['can_turnundead'] ?? 'false',
            'bowSpritetId' => !empty($_POST['bowSpritetId']) ? (int)$_POST['bowSpritetId'] : 0,
            'karma' => !empty($_POST['karma']) ? (int)$_POST['karma'] : 0,
            'transform_id' => !empty($_POST['transform_id']) ? (int)$_POST['transform_id'] : -1,
            'transform_gfxid' => !empty($_POST['transform_gfxid']) ? (int)$_POST['transform_gfxid'] : 0,
            'light_size' => !empty($_POST['light_size']) ? (int)$_POST['light_size'] : 0,
            'is_amount_fixed' => $_POST['is_amount_fixed'] ?? 'false',
            'is_change_head' => $_POST['is_change_head'] ?? 'false',
            'spawnlist_door' => !empty($_POST['spawnlist_door']) ? (int)$_POST['spawnlist_door'] : 0,
            'count_map' => !empty($_POST['count_map']) ? (int)$_POST['count_map'] : 0,
            'cant_resurrect' => $_POST['cant_resurrect'] ?? 'false',
            'isHide' => $_POST['isHide'] ?? 'false'
        ];
        
        // Try to create the monster
        $result = $monstersModel->createMonster($data);
        
        if ($result) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'create',
                "Created new monster: {$data['desc_en']} (ID: {$data['npcid']})",
                'monster',
                $data['npcid']
            );
            
            // Redirect to index with success message
            header('Location: index.php?created=1');
            exit;
        } else {
            $errors[] = "Failed to create monster. Please try again.";
        }
    }
}

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title">Add New Monster</h1>
                <a href="index.php" class="admin-button admin-button-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Monsters
                </a>
            </div>
            
            <?php if (!empty($errors)): ?>
            <div class="admin-alert admin-alert-danger">
                <h4>Please fix the following errors:</h4>
                <ul>
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="create.php" method="post" class="admin-form">
                <!-- Basic Information -->
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Basic Information</h3>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="npcid" class="admin-form-label">NPC ID *</label>
                            <input type="number" id="npcid" name="npcid" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['npcid'] ?? ''); ?>" 
                                   required min="1">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="classId" class="admin-form-label">Class ID</label>
                            <input type="number" id="classId" name="classId" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['classId'] ?? '0'); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="spriteId" class="admin-form-label">Sprite ID</label>
                            <input type="number" id="spriteId" name="spriteId" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['spriteId'] ?? '0'); ?>">
                            <small class="admin-form-help">Used for monster image (ms{spriteId}.png)</small>
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group admin-form-group-full">
                            <label for="desc_en" class="admin-form-label">English Name *</label>
                            <input type="text" id="desc_en" name="desc_en" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['desc_en'] ?? ''); ?>" 
                                   required maxlength="100">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="desc_kr" class="admin-form-label">Korean Name</label>
                            <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['desc_kr'] ?? ''); ?>" 
                                   maxlength="45">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="desc_powerbook" class="admin-form-label">Powerbook Name</label>
                            <input type="text" id="desc_powerbook" name="desc_powerbook" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['desc_powerbook'] ?? ''); ?>" 
                                   maxlength="100">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="impl" class="admin-form-label">Implementation Type *</label>
                            <select id="impl" name="impl" class="admin-form-select" required>
                                <option value="">Select Type</option>
                                <option value="L1Monster" <?php echo (($_POST['impl'] ?? '') === 'L1Monster') ? 'selected' : ''; ?>>L1Monster</option>
                                <option value="L1BlackKnight" <?php echo (($_POST['impl'] ?? '') === 'L1BlackKnight') ? 'selected' : ''; ?>>L1BlackKnight</option>
                                <option value="L1Doppelganger" <?php echo (($_POST['impl'] ?? '') === 'L1Doppelganger') ? 'selected' : ''; ?>>L1Doppelganger</option>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="family" class="admin-form-label">Family</label>
                            <input type="text" id="family" name="family" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['family'] ?? ''); ?>" 
                                   maxlength="20">
                        </div>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Stats</h3>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="lvl" class="admin-form-label">Level</label>
                            <input type="number" id="lvl" name="lvl" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['lvl'] ?? '1'); ?>" 
                                   min="0" max="999">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="hp" class="admin-form-label">HP</label>
                            <input type="number" id="hp" name="hp" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['hp'] ?? '1'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="mp" class="admin-form-label">MP</label>
                            <input type="number" id="mp" name="mp" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['mp'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="ac" class="admin-form-label">AC</label>
                            <input type="number" id="ac" name="ac" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['ac'] ?? '0'); ?>">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="str" class="admin-form-label">STR</label>
                            <input type="number" id="str" name="str" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['str'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="con" class="admin-form-label">CON</label>
                            <input type="number" id="con" name="con" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['con'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dex" class="admin-form-label">DEX</label>
                            <input type="number" id="dex" name="dex" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['dex'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="wis" class="admin-form-label">WIS</label>
                            <input type="number" id="wis" name="wis" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['wis'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="intel" class="admin-form-label">INT</label>
                            <input type="number" id="intel" name="intel" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['intel'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="mr" class="admin-form-label">MR</label>
                            <input type="number" id="mr" name="mr" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['mr'] ?? '0'); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="exp" class="admin-form-label">Experience</label>
                            <input type="number" id="exp" name="exp" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['exp'] ?? '0'); ?>" 
                                   min="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="alignment" class="admin-form-label">Alignment</label>
                            <input type="number" id="alignment" name="alignment" class="admin-form-input" 
                                   value="<?php echo htmlspecialchars($_POST['alignment'] ?? '0'); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Type & Behavior -->
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Type & Behavior</h3>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="undead" class="admin-form-label">Undead Type</label>
                            <select id="undead" name="undead" class="admin-form-select">
                                <option value="NONE" <?php echo (($_POST['undead'] ?? 'NONE') === 'NONE') ? 'selected' : ''; ?>>None</option>
                                <option value="UNDEAD" <?php echo (($_POST['undead'] ?? '') === 'UNDEAD') ? 'selected' : ''; ?>>Undead</option>
                                <option value="DEMON" <?php echo (($_POST['undead'] ?? '') === 'DEMON') ? 'selected' : ''; ?>>Demon</option>
                                <option value="UNDEAD_BOSS" <?php echo (($_POST['undead'] ?? '') === 'UNDEAD_BOSS') ? 'selected' : ''; ?>>Undead Boss</option>
                                <option value="DRANIUM" <?php echo (($_POST['undead'] ?? '') === 'DRANIUM') ? 'selected' : ''; ?>>Dranium</option>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="weakAttr" class="admin-form-label">Weak Attribute</label>
                            <select id="weakAttr" name="weakAttr" class="admin-form-select">
                                <option value="NONE" <?php echo (($_POST['weakAttr'] ?? 'NONE') === 'NONE') ? 'selected' : ''; ?>>None</option>
                                <option value="EARTH" <?php echo (($_POST['weakAttr'] ?? '') === 'EARTH') ? 'selected' : ''; ?>>Earth</option>
                                <option value="FIRE" <?php echo (($_POST['weakAttr'] ?? '') === 'FIRE') ? 'selected' : ''; ?>>Fire</option>
                                <option value="WATER" <?php echo (($_POST['weakAttr'] ?? '') === 'WATER') ? 'selected' : ''; ?>>Water</option>
                                <option value="WIND" <?php echo (($_POST['weakAttr'] ?? '') === 'WIND') ? 'selected' : ''; ?>>Wind</option>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="poison_atk" class="admin-form-label">Poison Attack</label>
                            <select id="poison_atk" name="poison_atk" class="admin-form-select">
                                <option value="NONE" <?php echo (($_POST['poison_atk'] ?? 'NONE') === 'NONE') ? 'selected' : ''; ?>>None</option>
                                <option value="DAMAGE" <?php echo (($_POST['poison_atk'] ?? '') === 'DAMAGE') ? 'selected' : ''; ?>>Damage</option>
                                <option value="PARALYSIS" <?php echo (($_POST['poison_atk'] ?? '') === 'PARALYSIS') ? 'selected' : ''; ?>>Paralysis</option>
                                <option value="SILENCE" <?php echo (($_POST['poison_atk'] ?? '') === 'SILENCE') ? 'selected' : ''; ?>>Silence</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Boolean Flags -->
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Flags</h3>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="big" value="false">
                                <input type="checkbox" name="big" value="true" 
                                       <?php echo (($_POST['big'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Big Size
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="is_agro" value="false">
                                <input type="checkbox" name="is_agro" value="true" 
                                       <?php echo (($_POST['is_agro'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Aggressive
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="is_bossmonster" value="false">
                                <input type="checkbox" name="is_bossmonster" value="true" 
                                       <?php echo (($_POST['is_bossmonster'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Boss Monster
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="is_hard" value="false">
                                <input type="checkbox" name="is_hard" value="true" 
                                       <?php echo (($_POST['is_hard'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Hard Mode
                            </label>
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="is_taming" value="false">
                                <input type="checkbox" name="is_taming" value="true" 
                                       <?php echo (($_POST['is_taming'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Tameable
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="is_teleport" value="false">
                                <input type="checkbox" name="is_teleport" value="true" 
                                       <?php echo (($_POST['is_teleport'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Can Teleport
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="can_turnundead" value="false">
                                <input type="checkbox" name="can_turnundead" value="true" 
                                       <?php echo (($_POST['can_turnundead'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Can Turn Undead
                            </label>
                        </div>
                        
                        <div class="admin-form-group admin-form-checkbox-group">
                            <label class="admin-checkbox-label">
                                <input type="hidden" name="isHide" value="false">
                                <input type="checkbox" name="isHide" value="true" 
                                       <?php echo (($_POST['isHide'] ?? 'false') === 'true') ? 'checked' : ''; ?>>
                                Hidden
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="admin-form-actions">
                    <button type="submit" class="admin-button admin-button-primary">
                        <i class="fas fa-save"></i> Create Monster
                    </button>
                    <a href="index.php" class="admin-button admin-button-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>

<script>
// Preview monster image when sprite ID changes
document.getElementById('spriteId').addEventListener('input', function() {
    const spriteId = this.value;
    const preview = document.getElementById('sprite-preview');
    
    if (spriteId && spriteId > 0) {
        if (!preview) {
            const previewContainer = document.createElement('div');
            previewContainer.innerHTML = `
                <div class="admin-form-preview">
                    <label class="admin-form-label">Preview</label>
                    <img id="sprite-preview" src="../../assets/img/icons/ms${spriteId}.png" 
                         alt="Monster preview" class="admin-monster-icon-large"
                         onerror="this.src='../../assets/img/placeholders/monster.png'">
                </div>
            `;
            this.parentNode.appendChild(previewContainer);
        } else {
            preview.src = `../../assets/img/icons/ms${spriteId}.png`;
        }
    } else if (preview) {
        preview.parentNode.parentNode.remove();
    }
});
</script>

<?php include '../../includes/admin-footer.php'; ?> 