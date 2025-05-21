
-- --------------------------------------------------------

--
-- Table structure for table `log_enchant`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `log_enchant` (
  `id` int(10) UNSIGNED NOT NULL,
  `char_id` int(10) NOT NULL DEFAULT 0,
  `item_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `old_enchantlvl` int(3) NOT NULL DEFAULT 0,
  `new_enchantlvl` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `log_enchant`:
--
