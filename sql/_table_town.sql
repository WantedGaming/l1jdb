
-- --------------------------------------------------------

--
-- Table structure for table `town`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `town` (
  `town_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `leader_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `leader_name` varchar(45) DEFAULT NULL,
  `tax_rate` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tax_rate_reserved` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sales_money` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sales_money_yesterday` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `town_tax` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `town_fix_tax` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `town`:
--
