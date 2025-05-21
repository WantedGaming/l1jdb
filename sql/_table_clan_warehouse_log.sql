
-- --------------------------------------------------------

--
-- Table structure for table `clan_warehouse_log`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_warehouse_log` (
  `id` int(1) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `clan_name` varchar(30) NOT NULL DEFAULT '',
  `item_name` varchar(30) NOT NULL DEFAULT '',
  `item_count` int(1) UNSIGNED NOT NULL,
  `type` bit(1) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_warehouse_log`:
--
