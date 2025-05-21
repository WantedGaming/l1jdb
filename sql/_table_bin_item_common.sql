
-- --------------------------------------------------------

--
-- Table structure for table `bin_item_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_item_common` (
  `name_id` int(6) NOT NULL DEFAULT 0,
  `icon_id` int(6) NOT NULL DEFAULT 0,
  `sprite_id` int(6) NOT NULL DEFAULT 0,
  `desc_id` varchar(100) DEFAULT NULL,
  `real_desc` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) DEFAULT NULL,
  `material` enum('DRANIUM(23)','ORIHARUKON(22)','MINERAL(21)','GEMSTONE(20)','GLASS(19)','PLASTIC(18)','MITHRIL(17)','PLATINUM(16)','GOLD(15)','SILVER(14)','COPPER(13)','METAL(12)','IRON(11)','DRAGON_HIDE(10)','BONE(9)','WOOD(8)','LEATHER(7)','CLOTH(6)','PAPER(5)','FLESH(4)','VEGGY(3)','WAX(2)','LIQUID(1)','NONE(0)') NOT NULL DEFAULT 'NONE(0)',
  `weight_1000ea` int(10) NOT NULL DEFAULT 0,
  `level_limit_min` int(3) NOT NULL DEFAULT 0,
  `level_limit_max` int(3) NOT NULL DEFAULT 0,
  `prince_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `knight_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `elf_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `magician_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `darkelf_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `dragonknight_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `illusionist_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `warrior_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `fencer_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `lancer_permit` enum('true','false') NOT NULL DEFAULT 'false',
  `equip_bonus_list` text DEFAULT NULL,
  `interaction_type` int(3) NOT NULL DEFAULT 0,
  `real_weight` int(10) NOT NULL DEFAULT 0,
  `spell_range` int(2) NOT NULL DEFAULT 0,
  `item_category` enum('WAND(1013)','AUTO_USED_BY_BUFF_ITEM(1012)','SPELL_EXTRACTOR(1011)','ARROW(1010)','POTION_MANA(1009)','LUCKY_BAG(1008)','WAND_CALL_LIGHTNING(1007)','ARMOR_SERIES_MAIN(1006)','ARMOR_SERIES(1005)','SCROLL(1004)','SCROLL_TELEPORT_HOME(1003)','SCROLL_TELEPORT_TOWN(1002)','POTION_HEAL(1001)','POTION(1000)','ITEM(23)','LIGHT(22)','FOOD(21)','ARMOR(19)','WEAPON(1)','NONE(0)') NOT NULL DEFAULT 'NONE(0)',
  `body_part` enum('BODYPART_ALL(-1)','BP_PENDANT(33554432)','BP_INSIGNIA(16777216)','BP_PAULDRON(8388608)','BP_HERALDRY(4194304)','EXT_SLOTS(2097152)','RUNE(1048576)','L_WRIST(524288)','R_WRIST(262144)','BACK(131072)','L_SHOULDER(65536)','R_SHOULDER(32768)','EAR(16384)','WAIST(8192)','NECK(4096)','R_FINGER(2048)','L_FINGER(1024)','R_HOLD(512)','L_HOLD(256)','R_HAND(128)','L_HAND(64)','FOOT(32)','LEG(16)','CLOAK(8)','SHIRT(4)','TORSO(2)','HEAD(1)','NONE(0)') NOT NULL DEFAULT 'NONE(0)',
  `ac` int(6) NOT NULL DEFAULT 0,
  `extended_weapon_type` enum('WEAPON_EX_NOT_EQUIPPED(13)','WEAPON_EX_KIRINGKU(12)','WEAPON_EX_DOUBLE_AXE(11)','WEAPON_EX_CHAIN_SWORD(10)','WEAPON_EX_GAUNTLET(9)','WEAPON_EX_CRAW(8)','WEAPON_EX_DOUBLE_SWORD(7)','WEAPON_EX_LARGE_SWORD(6)','WEAPON_EX_DAGGER(5)','WEAPON_EX_STAFF(4)','WEAPON_EX_SPEAR(3)','WEAPON_EX_BOW(2)','WEAPON_EX_AXE(1)','WEAPON_EX_ONEHAND_SWORD(0)','NONE(-1)') NOT NULL DEFAULT 'NONE(-1)',
  `large_damage` int(3) NOT NULL DEFAULT 0,
  `small_damage` int(3) NOT NULL DEFAULT 0,
  `hit_bonus` int(3) NOT NULL DEFAULT 0,
  `damage_bonus` int(3) NOT NULL DEFAULT 0,
  `armor_series_info` text DEFAULT NULL,
  `cost` int(10) NOT NULL DEFAULT 0,
  `can_set_mage_enchant` enum('true','false') NOT NULL DEFAULT 'false',
  `merge` enum('true','false') NOT NULL DEFAULT 'false',
  `pss_event_item` enum('true','false') NOT NULL DEFAULT 'false',
  `market_searching_item` enum('true','false') NOT NULL DEFAULT 'false',
  `lucky_bag_reward_list` text DEFAULT NULL,
  `element_enchant_table` int(3) NOT NULL DEFAULT 0,
  `accessory_enchant_table` int(3) NOT NULL DEFAULT 0,
  `bm_prob_open` int(3) NOT NULL DEFAULT 0,
  `enchant_type` int(3) NOT NULL DEFAULT 0,
  `is_elven` enum('true','false') NOT NULL DEFAULT 'false',
  `forced_elemental_enchant` int(3) NOT NULL DEFAULT 0,
  `max_enchant` int(3) NOT NULL DEFAULT 0,
  `energy_lost` enum('true','false') NOT NULL DEFAULT 'false',
  `prob` int(6) NOT NULL DEFAULT 0,
  `pss_heal_item` enum('false','true') NOT NULL DEFAULT 'false',
  `useInterval` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_item_common`:
--
