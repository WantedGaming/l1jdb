
-- --------------------------------------------------------

--
-- Table structure for table `mobgroup`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `mobgroup` (
  `id` int(10) UNSIGNED NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  `remove_group_if_leader_die` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `leader_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion1_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion1_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion2_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion2_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion3_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion3_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion4_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion4_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion5_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion5_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion6_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion6_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion7_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion7_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion8_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minion8_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `mobgroup`:
--
