
-- --------------------------------------------------------

--
-- Table structure for table `weapon_skill_model`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `weapon_skill_model` (
  `item_id` int(10) NOT NULL,
  `desc_en` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) DEFAULT NULL,
  `procType` enum('NORMAL(MELEE)','NORMAL(RANGED)','WIDE(FRONT)','WIDE(TARGET)','CHAIN-SPOT','CHAOTIC(NO-EFFECT)','CHAOTIC(EFFECT)','POISON-DAMAGE','DICE-DAGGER','DISEASE','HOLD','HP-DRAIN','HP-DRAIN(MORE-DAMAGE)','MP-DRAIN','MP-DRAIN(MORE-DAMAGE)','MP-DRAIN(DISEASE)','PUMPKIN-CURSE','SILENCE','TURN-UNDEAD','CRITICAL-ATTACK','CRITICAL-ATTACK(DEMON)','LEGENDARY-WEAPON','ARMOR(HP-REGEN)','ARMOR(MP-REGEN)','ARMOR(HP-MP-REGEN)','ARMOR(PROB-REDUCTION)') DEFAULT NULL,
  `condition` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') DEFAULT '0',
  `default_prob` int(5) DEFAULT 0,
  `enchant_prob` int(5) DEFAULT 0,
  `stat_prob` enum('NONE','STR','DEX','CON','WIS','INT','CHA') DEFAULT 'NONE',
  `stat_weight` int(5) DEFAULT 0,
  `limit_low_val` int(10) DEFAULT 0,
  `limit_high_val` int(10) DEFAULT 0,
  `min_val` int(10) DEFAULT 0,
  `max_val` int(10) DEFAULT 0,
  `stat_val` enum('NONE','STR','DEX','CON','WIS','INT','CHA') DEFAULT 'NONE',
  `stat_val_weight` int(5) DEFAULT 0,
  `enchant_val` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') DEFAULT '0',
  `enchant_val_weight` int(5) DEFAULT 0,
  `effect` int(10) DEFAULT 0,
  `PVE_Effect` int(10) DEFAULT 0,
  `Location` int(10) DEFAULT 0,
  `attr_type` enum('NONE','EARTH','FIRE','WATER','WIND') DEFAULT 'NONE',
  `is_magic` enum('true','false') DEFAULT 'true',
  `is_sp_val` enum('false','true') DEFAULT 'false',
  `sp_val_weight` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `weapon_skill_model`:
--
