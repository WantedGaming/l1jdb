
-- --------------------------------------------------------

--
-- Table structure for table `character_shop_limit`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_shop_limit` (
  `characterId` int(10) NOT NULL DEFAULT 0,
  `buyShopId` int(9) NOT NULL DEFAULT 0,
  `buyItemId` int(9) NOT NULL DEFAULT 0,
  `buyCount` int(9) NOT NULL DEFAULT 0,
  `buyTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `limitTerm` enum('WEEK','DAY','NONE') NOT NULL DEFAULT 'DAY'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_shop_limit`:
--
