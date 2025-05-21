
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_ub`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_ub` (
  `id` int(10) UNSIGNED NOT NULL,
  `ub_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pattern` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `npc_templateid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `spawn_delay` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `seal_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `isBoss` enum('false','true') NOT NULL DEFAULT 'false',
  `isGateKeeper` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_ub`:
--
