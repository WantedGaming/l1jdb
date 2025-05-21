
-- --------------------------------------------------------

--
-- Table structure for table `bin_npc_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_npc_common` (
  `class_id` int(6) NOT NULL DEFAULT 0,
  `npc_id` int(11) NOT NULL,
  `with_bin_spawn` tinyint(1) NOT NULL,
  `sprite_id` int(6) NOT NULL DEFAULT 0,
  `desc_id` varchar(100) DEFAULT NULL,
  `desc_kr` varchar(100) DEFAULT NULL,
  `level` int(3) NOT NULL DEFAULT 0,
  `hp` int(9) NOT NULL DEFAULT 0,
  `mp` int(9) NOT NULL DEFAULT 0,
  `ac` int(3) NOT NULL DEFAULT 0,
  `str` int(3) NOT NULL DEFAULT 0,
  `con` int(3) NOT NULL DEFAULT 0,
  `dex` int(3) NOT NULL DEFAULT 0,
  `wis` int(3) NOT NULL DEFAULT 0,
  `inti` int(3) NOT NULL DEFAULT 0,
  `cha` int(3) NOT NULL DEFAULT 0,
  `mr` int(3) NOT NULL DEFAULT 0,
  `magic_level` int(3) NOT NULL DEFAULT 0,
  `magic_bonus` int(3) NOT NULL DEFAULT 0,
  `magic_evasion` int(3) NOT NULL DEFAULT 0,
  `resistance_fire` int(3) NOT NULL DEFAULT 0,
  `resistance_water` int(3) NOT NULL DEFAULT 0,
  `resistance_air` int(3) NOT NULL DEFAULT 0,
  `resistance_earth` int(3) NOT NULL DEFAULT 0,
  `alignment` int(6) NOT NULL DEFAULT 0,
  `big` enum('true','false') NOT NULL DEFAULT 'false',
  `drop_items` text DEFAULT NULL,
  `tendency` enum('AGGRESSIVE(2)','PASSIVE(1)','NEUTRAL(0)') NOT NULL DEFAULT 'NEUTRAL(0)',
  `category` int(10) NOT NULL DEFAULT 0,
  `is_bossmonster` enum('true','false') NOT NULL DEFAULT 'false',
  `can_turnundead` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_npc_common`:
--
