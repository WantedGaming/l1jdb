
-- --------------------------------------------------------

--
-- Table structure for table `item_ment`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_ment` (
  `itemId` int(10) NOT NULL DEFAULT 0,
  `itemName` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `mentType` enum('treasurebox','craft','drop','pickup') NOT NULL DEFAULT 'pickup'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_ment`:
--
