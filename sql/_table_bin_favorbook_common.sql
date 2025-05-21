
-- --------------------------------------------------------

--
-- Table structure for table `bin_favorbook_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_favorbook_common` (
  `category_id` int(2) NOT NULL DEFAULT 0,
  `desc_id` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `sort` int(2) NOT NULL DEFAULT 0,
  `slot_id` int(2) NOT NULL DEFAULT 0,
  `state_infos` text DEFAULT NULL,
  `red_dot_notice` int(2) NOT NULL DEFAULT 0,
  `default_display_item_id` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_favorbook_common`:
--
