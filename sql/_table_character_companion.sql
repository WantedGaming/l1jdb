
-- --------------------------------------------------------

--
-- Table structure for table `character_companion`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_companion` (
  `item_objId` int(10) UNSIGNED NOT NULL,
  `objid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `npcId` int(10) UNSIGNED NOT NULL,
  `level` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `exp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `maxHp` int(5) UNSIGNED NOT NULL DEFAULT 160,
  `currentHp` int(5) UNSIGNED NOT NULL DEFAULT 160,
  `friend_ship_marble` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `friend_ship_guage` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `add_str` int(3) NOT NULL DEFAULT 0,
  `add_con` int(3) NOT NULL DEFAULT 0,
  `add_int` int(3) NOT NULL DEFAULT 0,
  `remain_stats` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `elixir_use_count` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `dead` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `oblivion` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `tier` int(1) NOT NULL DEFAULT 1,
  `wild` blob NOT NULL,
  `lessExp` int(10) NOT NULL DEFAULT 0,
  `traningTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `character_companion`:
--
