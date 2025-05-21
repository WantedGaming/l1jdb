
-- --------------------------------------------------------

--
-- Table structure for table `craft_block`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `craft_block` (
  `craft_id` int(5) NOT NULL DEFAULT 0,
  `craft_name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `craft_block`:
--
