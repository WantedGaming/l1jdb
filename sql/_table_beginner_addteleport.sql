
-- --------------------------------------------------------

--
-- Table structure for table `beginner_addteleport`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `beginner_addteleport` (
  `id` int(10) UNSIGNED NOT NULL,
  `num_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `speed_id` int(10) NOT NULL DEFAULT -1,
  `char_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `locx` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `locy` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mapid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `randomX` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `randomY` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `item_obj_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `beginner_addteleport`:
--
