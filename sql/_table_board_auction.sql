
-- --------------------------------------------------------

--
-- Table structure for table `board_auction`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
-- Last check: May 21, 2025 at 07:09 AM
--

CREATE TABLE `board_auction` (
  `house_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `house_name` varchar(45) NOT NULL DEFAULT '',
  `house_area` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deadline` datetime DEFAULT NULL,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `location` varchar(45) NOT NULL DEFAULT '',
  `old_owner` varchar(45) NOT NULL DEFAULT '',
  `old_owner_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `bidder` varchar(45) NOT NULL DEFAULT '',
  `bidder_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `board_auction`:
--
