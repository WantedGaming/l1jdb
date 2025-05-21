
-- --------------------------------------------------------

--
-- Table structure for table `enchant_result`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `enchant_result` (
  `item_id` int(10) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `color_item` enum('false','true') NOT NULL DEFAULT 'false',
  `bm_scroll` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `enchant_result`:
--
