
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_clandungeon`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_clandungeon` (
  `id` int(2) UNSIGNED NOT NULL,
  `type` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `stage` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `npc_templateid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `count` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `boss` enum('true','false') DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_clandungeon`:
--
