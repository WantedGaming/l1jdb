
-- --------------------------------------------------------

--
-- Table structure for table `item_buff`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_buff` (
  `item_id` int(10) NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `skill_ids` varchar(100) NOT NULL DEFAULT '',
  `delete` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_buff`:
--
