
-- --------------------------------------------------------

--
-- Table structure for table `shop_aden`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `shop_aden` (
  `id` int(10) NOT NULL,
  `itemid` int(10) DEFAULT NULL,
  `itemname` varchar(22) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `type` int(10) DEFAULT 0,
  `status` int(10) DEFAULT 0,
  `html` varchar(22) DEFAULT '',
  `pack` int(10) DEFAULT 0,
  `enchant` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `shop_aden`:
--
