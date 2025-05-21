
-- --------------------------------------------------------

--
-- Table structure for table `shop_limit`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `shop_limit` (
  `shopId` int(9) NOT NULL DEFAULT 0,
  `itemId` int(9) NOT NULL DEFAULT 0,
  `itemName` varchar(50) DEFAULT NULL,
  `limitTerm` enum('WEEK','DAY','NONE') NOT NULL DEFAULT 'DAY',
  `limitCount` int(9) NOT NULL DEFAULT 0,
  `limitType` enum('ACCOUNT','CHARACTER') NOT NULL DEFAULT 'ACCOUNT'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `shop_limit`:
--
