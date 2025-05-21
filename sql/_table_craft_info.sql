
-- --------------------------------------------------------

--
-- Table structure for table `craft_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `craft_info` (
  `craft_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `output_name_id` int(10) NOT NULL DEFAULT 0,
  `probability_million` int(10) NOT NULL DEFAULT 0,
  `preserve_name_ids` text DEFAULT NULL,
  `success_preserve_count` text DEFAULT NULL,
  `failure_preserve_count` text DEFAULT NULL,
  `is_success_count_type` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `craft_info`:
--
