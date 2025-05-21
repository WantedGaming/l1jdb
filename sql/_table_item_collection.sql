
-- --------------------------------------------------------

--
-- Table structure for table `item_collection`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_collection` (
  `itemId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(70) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `type` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_collection`:
--
