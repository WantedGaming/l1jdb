
-- --------------------------------------------------------

--
-- Table structure for table `shop`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `shop` (
  `npc_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `item_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `selling_price` int(10) NOT NULL DEFAULT -1,
  `pack_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `purchasing_price` int(10) NOT NULL DEFAULT -1,
  `enchant` int(10) NOT NULL DEFAULT 0,
  `pledge_rank` enum('NONE(None)','RANK_NORMAL_KING(Monarch)','RANK_NORMAL_PRINCE(Vice-Monarch)','RANK_NORMAL_KNIGHT(Guardian)','RANK_NORMAL_ELITE_KNIGHT(Elite)','RANK_NORMAL_JUNIOR_KNIGHT(Common)','RANK_NORMAL_REGULAR(Training)') NOT NULL DEFAULT 'NONE(None)',
  `note` varbinary(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `shop`:
--
