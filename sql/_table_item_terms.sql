
-- --------------------------------------------------------

--
-- Table structure for table `item_terms`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_terms` (
  `itemId` int(9) NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `termMinut` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_terms`:
--
