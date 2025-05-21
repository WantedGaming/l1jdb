
-- --------------------------------------------------------

--
-- Table structure for table `clan_data`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_data` (
  `clan_id` int(10) UNSIGNED NOT NULL,
  `clan_name` varchar(45) NOT NULL DEFAULT '',
  `leader_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `leader_name` varchar(45) NOT NULL DEFAULT '',
  `hascastle` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hashouse` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `alliance` varchar(100) DEFAULT NULL,
  `clan_birthday` datetime NOT NULL,
  `bot` enum('true','false') NOT NULL DEFAULT 'false',
  `bot_style` tinyint(3) NOT NULL DEFAULT 0,
  `bot_level` tinyint(3) NOT NULL DEFAULT 0,
  `max_online_user` int(10) NOT NULL DEFAULT 0,
  `announcement` varchar(160) NOT NULL,
  `introductionMessage` varchar(160) NOT NULL,
  `enter_notice` varchar(160) NOT NULL,
  `emblem_id` int(10) NOT NULL DEFAULT 0,
  `emblem_status` tinyint(1) NOT NULL DEFAULT 0,
  `contribution` int(10) NOT NULL DEFAULT 0,
  `bless` int(45) NOT NULL DEFAULT 0,
  `bless_count` int(45) NOT NULL DEFAULT 0,
  `attack` int(45) NOT NULL DEFAULT 0,
  `defence` int(45) NOT NULL DEFAULT 0,
  `pvpattack` int(45) NOT NULL DEFAULT 0,
  `pvpdefence` int(45) NOT NULL DEFAULT 0,
  `under_dungeon` tinyint(3) NOT NULL DEFAULT 0,
  `ranktime` int(10) NOT NULL DEFAULT 0,
  `rankdate` datetime DEFAULT NULL,
  `War_point` int(10) NOT NULL DEFAULT 0,
  `enable_join` enum('true','false') NOT NULL DEFAULT 'true',
  `join_type` int(1) NOT NULL DEFAULT 1,
  `total_m` int(10) NOT NULL DEFAULT 0,
  `current_m` int(10) NOT NULL DEFAULT 0,
  `join_password` varchar(45) DEFAULT NULL,
  `EinhasadBlessBuff` int(10) DEFAULT NULL,
  `Buff_List1` int(10) DEFAULT NULL,
  `Buff_List2` int(10) DEFAULT NULL,
  `Buff_List3` int(10) DEFAULT NULL,
  `dayDungeonTime` datetime DEFAULT NULL,
  `weekDungeonTime` datetime DEFAULT NULL,
  `vowTime` datetime DEFAULT NULL,
  `vowCount` int(1) NOT NULL DEFAULT 0,
  `clanNameChange` enum('true','false') NOT NULL DEFAULT 'false',
  `storeAllows` text DEFAULT NULL,
  `limit_level` int(3) NOT NULL DEFAULT 30,
  `limit_user_names` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_data`:
--
