
-- --------------------------------------------------------

--
-- Table structure for table `app_shop_rank`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_shop_rank` (
  `group_type` enum('1.All','2.Weapon','3.Armor','4.Accessory','5.Other') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1.All',
  `shop_type` enum('1.Sell','2.Buy') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1.Sell',
  `id` int(1) NOT NULL DEFAULT 0,
  `item_id` int(10) NOT NULL DEFAULT 0,
  `enchant` int(3) NOT NULL DEFAULT 0,
  `search_rank` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_shop_rank`:
--
