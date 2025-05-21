
-- --------------------------------------------------------

--
-- Table structure for table `npcchat`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `npcchat` (
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `chat_timing` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `note` varchar(45) NOT NULL DEFAULT '',
  `start_delay_time` int(10) NOT NULL DEFAULT 0,
  `chat_id1` varchar(45) NOT NULL DEFAULT '',
  `chat_id2` varchar(45) NOT NULL DEFAULT '',
  `chat_id3` varchar(45) NOT NULL DEFAULT '',
  `chat_id4` varchar(45) NOT NULL DEFAULT '',
  `chat_id5` varchar(45) NOT NULL DEFAULT '',
  `chat_interval` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_shout` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_world_chat` tinyint(1) NOT NULL DEFAULT 0,
  `is_repeat` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `repeat_interval` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `game_time` int(10) NOT NULL DEFAULT 0,
  `percent` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `npcchat`:
--
