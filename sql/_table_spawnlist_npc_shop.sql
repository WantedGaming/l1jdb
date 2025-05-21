
-- --------------------------------------------------------

--
-- Table structure for table `spawnlist_npc_shop`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `spawnlist_npc_shop` (
  `id` int(10) UNSIGNED NOT NULL,
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) NOT NULL,
  `locx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mapid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `heading` int(10) NOT NULL DEFAULT 0,
  `title` varchar(35) NOT NULL DEFAULT '',
  `shop_chat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `spawnlist_npc_shop`:
--
